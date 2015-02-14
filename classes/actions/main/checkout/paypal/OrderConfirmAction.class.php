<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/OrdersManager.class.php");
require_once (CLASSES_PATH . "/managers/PaypalManager.class.php");
require_once (CLASSES_PATH . "/managers/PaypalTransactionsManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class OrderConfirmAction extends GuestAction {

    public function service() {
        $token = urlencode($_SESSION['TOKEN']);
        $ordersManager = OrdersManager::getInstance($this->config, $this->args);
        $orderBy3rdPartyToken = $ordersManager->getOrderBy3rdPartyToken($token);
        if (!isset($orderBy3rdPartyToken)) {
            $_SESSION['error_message'] = $this->getPhrase(595);
            $this->redirect('orders');
        }
        $paypalTransactionsManager = PaypalTransactionsManager::getInstance($this->config, $this->args);
        $orderId = $orderBy3rdPartyToken->getId();
        $res = $this->getPaypalShippingDetails();
        if ($res === true) {
            $res = $this->confirmOrder();
            if ($res === true) {
                $_SESSION['success_message'] = sprintf($this->getPhrase(593), $orderId);
                $ordersManager->updateNumericField($orderId, '3rd_party_payment_received', 1);
                $paypalTransactionsManager->setOrderCompleted($orderId);
            } else {
                $paypalTransactionsManager->setOrderPaymentError($orderId, $res);
                $_SESSION['error_message'] = $res;
            }
        } else {
            $paypalTransactionsManager->setOrderPaymentError($orderId, $res);
            $_SESSION['error_message'] = $res;
        }
        $this->redirect('orders');
    }

    private function getPaypalShippingDetails() {
        $paypalManager = PaypalManager::getInstance();
        $token = urlencode($_SESSION['TOKEN']);
        $resArray = $paypalManager->GetShippingDetails($token);
        $ack = strtoupper($resArray["ACK"]);
        if ($ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") {
            /*
              ' The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review
              ' page
             */
            $email = $resArray["EMAIL"]; // ' Email address of payer.
            $payerId = $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
            $payerStatus = $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
            $salutation = $resArray["SALUTATION"]; // ' Payer's salutation.
            $firstName = $resArray["FIRSTNAME"]; // ' Payer's first name.
            $middleName = $resArray["MIDDLENAME"]; // ' Payer's middle name.
            $lastName = $resArray["LASTNAME"]; // ' Payer's last name.
            $suffix = $resArray["SUFFIX"]; // ' Payer's suffix.
            $cntryCode = $resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
            $business = $resArray["BUSINESS"]; // ' Payer's business name.
            $shipToName = $resArray["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
            $shipToStreet = $resArray["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
            $shipToStreet2 = $resArray["PAYMENTREQUEST_0_SHIPTOSTREET2"]; // ' Second street address.
            $shipToCity = $resArray["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
            $shipToState = $resArray["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
            $shipToCntryCode = $resArray["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code. 
            $shipToZip = $resArray["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
            $addressStatus = $resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal   
            $invoiceNumber = $resArray["INVNUM"]; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
            $phonNumber = $resArray["PHONENUM"]; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one. 
            return true;
        } else {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
            $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
            $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
            $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

            $ret = "GetExpressCheckoutDetails API call failed. ";
            $ret .= ". Detailed Error Message: " . $ErrorLongMsg;
            $ret .=". Short Error Message: " . $ErrorShortMsg;
            $ret .=". Error Code: " . $ErrorCode;
            $ret .=". Error Severity Code: " . $ErrorSeverityCode;
            return $ret;
        }
    }

    private function confirmOrder() {
        $paypalManager = PaypalManager::getInstance();
        $finalPaymentAmount = $_SESSION["Payment_Amount"];
        $resArray = $paypalManager->ConfirmPayment($finalPaymentAmount);
        $ack = strtoupper($resArray["ACK"]);

        if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
            $transactionId = $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
            $transactionType = $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
            $paymentType = $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
            $orderTime = $resArray["PAYMENTINFO_0_ORDERTIME"];  //' Time/date stamp of payment
            $amt = $resArray["PAYMENTINFO_0_AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
            $currencyCode = $resArray["PAYMENTINFO_0_CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
            $feeAmt = $resArray["PAYMENTINFO_0_FEEAMT"];  //' PayPal fee amount charged for the transaction
            $settleAmt = $resArray["PAYMENTINFO_0_SETTLEAMT"];  //' Amount deposited in your PayPal account after a currency conversion.
            $taxAmt = $resArray["PAYMENTINFO_0_TAXAMT"];  //' Tax charged on the transaction.
            $exchangeRate = $resArray["PAYMENTINFO_0_EXCHANGERATE"];  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.

            /*
              ' Status of the payment:
              'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
              'Pending: The payment is pending. See the PendingReason element for more information.
             */

            $paymentStatus = $resArray["PAYMENTINFO_0_PAYMENTSTATUS"];

            /*
              'The reason the payment is pending:
              '  none: No pending reason
              '  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile.
              '  echeck: The payment is pending because it was made by an eCheck that has not yet cleared.
              '  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview.
              '  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment.
              '  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment.
              '  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service.
             */

            $pendingReason = $resArray["PAYMENTINFO_0_PENDINGREASON"];

            /*
              'The reason for a reversal if TransactionType is reversal:
              '  none: No reason code
              '  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer.
              '  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee.
              '  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer.
              '  refund: A reversal has occurred on this transaction because you have given the customer a refund.
              '  other: A reversal has occurred on this transaction due to a reason not listed above.
             */

            $reasonCode = $resArray["PAYMENTINFO_0_REASONCODE"];
            return $paymentStatus == 'Completed';
        } else {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
            $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
            $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
            $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

            $ret = "GetExpressCheckoutDetails API call failed. ";
            $ret .= " Detailed Error Message: " . $ErrorLongMsg;
            $ret .=". Short Error Message: " . $ErrorShortMsg;
            $ret .=". Error Code: " . $ErrorCode;
            $ret .=". Error Severity Code: " . $ErrorSeverityCode;
            return $ret;
        }
    }

    public function getRequestGroup() {
        return RequestGroups::$userRequest;
    }

}

?>