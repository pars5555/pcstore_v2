<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");

require_once (CLASSES_PATH . "/managers/OrdersManager.class.php");
require_once (CLASSES_PATH . "/managers/OrderDetailsManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");
require_once (CLASSES_PATH . "/managers/BundleItemsManager.class.php");
require_once (CLASSES_PATH . "/managers/SpecialFeesManager.class.php");
require_once (CLASSES_PATH . "/managers/CreditOrdersManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CreditManager.class.php");
require_once (CLASSES_PATH . "/managers/CreditSuppliersManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailAccountsManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");
require_once (CLASSES_PATH . "/managers/DiscountPromoCodesManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ConfirmOrderAction extends GuestAction {

    public function service() {
        $recipient_name = $this->secure($_POST['recipient_name']);
        $ship_addr = $this->secure($_POST['ship_addr']);
        $shipping_region = $this->secure($_POST['shipping_region']);
        $ship_cell_tel = $this->secure($_POST['ship_cell_tel']);
        $ship_tel = $this->secure($_POST['ship_tel']);
        $paymentType = $this->secure($_POST['payment_type']);
        $doShipping = $this->secure($_POST['do_shipping']);
        $customerCartManager = CustomerCartManager::getInstance();
        $ordersManager = OrdersManager::getInstance();
        $orderDetailsManager = OrderDetailsManager::getInstance();
        $checkoutManager = CheckoutManager::getInstance();

        $userTypeString = $this->getUserLevelString();
        $customer = $this->getCustomer();
        $userEmail = $customer->getEmail();
        $dollarExchange = $this->getCmsVar("us_dollar_exchange");

        list($totalPromoDiscountAmd, $totalDealDiscountAmd,
                $all_non_bundle_items_has_vat, $minimum_order_amount_exceed,
                $customerCartChangesMessages, $discountAvailable, $pv,
                $groupedCartItems, $allItemsAreAvailable,
                $emptyCart, $grandTotalAMD, $grandTotalUSD, $calcCartTotalDealerPrice) = $checkoutManager->calculateCustomerCartParams($this->getCustomer(), $this->getUserLevel());

        $shippingCost = $checkoutManager->getShippingCost($shipping_region, $grandTotalAMD);
        if (!$allItemsAreAvailable) {
            $this->redirect('cart');
        }
        if ($grandTotalAMD < intval($this->getCmsVar("minimum_order_amount_amd"))) {
            $this->redirect('cart');
        }
        $usablePoints = 0;

        /*
          if ($userLevel === UserGroups::$USER) {
          $grandTotalAMDWithShipping = $grandTotalAMD + $shippingCost;
          $userPoints = $customer->getPoints();
          if ($userPoints > 0 && $grandTotalAMDWithShipping > 0 && $cho_apply_user_points == 1) {
          if ($userPoints > $grandTotalAMDWithShipping) {
          $usablePoints = $grandTotalAMDWithShipping;
          } else {
          $usablePoints = $userPoints;
          }
          }
          }
         */
        //start order confirming

        $metadataObject = new stdClass();
        if ($paymentType === 'bank') {
            $company_name = $this->secure($_POST['company_name']);
            $company_hvhh = $this->secure($_POST['company_hvhh']);
            $company_address = $this->secure($_POST['company_address']);
            $company_bank = $this->secure($_POST['company_bank']);
            $company_bank_account_number = $this->secure($_POST['company_bank_account_number']);
            $company_delivering_address = $this->secure($_POST['company_delivering_address']);
            $metadataObject->company_name = $company_name;
            $metadataObject->company_hvhh = $company_hvhh;
            $metadataObject->company_address = $company_address;
            $metadataObject->company_bank = $company_bank;
            $metadataObject->bank_account_number = $company_bank_account_number;
            $metadataObject->company_delivering_address = $company_delivering_address;
        }
        $promo_codes = "";
        if (isset($_COOKIE['promo_codes'])) {
            $promo_codes = $_COOKIE['promo_codes'];
        }
        $orderId = $ordersManager->addOrder($userEmail, $calcCartTotalDealerPrice, $ship_tel, $ship_tel, $ship_cell_tel, $ship_cell_tel, $paymentType, $userTypeString, $dollarExchange, $doShipping, $ship_addr, $ship_addr, $shipping_region, $recipient_name, $recipient_name, $shipping_region, true, $usablePoints, $shippingCost, $grandTotalAMD, $grandTotalUSD, $promo_codes, ($totalPromoDiscountAmd + $totalDealDiscountAmd), $customer->getCartIncludedVat(), $metadataObject);
        $orderDetailsManager->addOrderDetails($orderId, $userEmail, $this->getUser(), $customer->getCartIncludedVat());

        //reduce user point if any used
        /*  if ($usablePoints > 0) {
          $userManager = UserManager::getInstance();
          $description = "User points used to pay for order numer $orderId.";
          $userManager->subtractUserPoints($this->getUserId(), $usablePoints, $description);
          } */

        if ($paymentType == 'credit') {
            $credit_supplier_id = intval($_REQUEST['credit_supplier_id']);
            $deposit_amd= intval($_REQUEST['deposit_amd']);
            $selected_credit_months = intval($_REQUEST['selected_credit_months']);
            $creditOrdersManager = CreditOrdersManager::getInstance();
            $creditSuppliersManager = CreditSuppliersManager::getInstance();
            $creditSupplierDto = $creditSuppliersManager->selectByPK($credit_supplier_id);
            $annualInterestPercent = floatval($creditSupplierDto->getAnnualInterestPercent());
            $annualInterestPercent += floatval($creditSupplierDto->getAnnualCommision());
            $commission = $creditSupplierDto->getCommission();
            $creditMonthlyPayment = CreditManager::calcCredit($grandTotalAMD, $deposit_amd, $annualInterestPercent, $selected_credit_months, $commission);
            $creditOrdersManager->addCreditOrder($orderId, $deposit_amd, $credit_supplier_id, $selected_credit_months, $annualInterestPercent, $creditMonthlyPayment);
        }
        $customerCartManager->emptyCustomerCart($userEmail);
        $this->emailOrderDetails($orderId);

        /* if (isset($validPromoDiscount)) {
          $discountPromoCodesManager = DiscountPromoCodesManager::getInstance();
          $discountDto = $discountPromoCodesManager->getByPromoCode($validPromoDiscount);
          if ($discountDto) {
          $discountDto->setUsed(1);
          $discountPromoCodesManager->updateByPK($discountDto);
          }
          } */

        $_SESSION['success_message'] = $orderId;
        $this->redirect('orders');
    }

    private function emailOrderDetails($orderId) {
        $emailSenderManager = new EmailSenderManager('gmail');
        $ordersManager = OrdersManager::getInstance();
        $customer = $this->getCustomer();
        $userManager = UserManager::getInstance();
        $customerEmail = $userManager->getRealEmailAddressByUserDto($customer);
        $emailAccountsManager = EmailAccountsManager::getInstance();
        $infoEmailAddress = $emailAccountsManager->getEmailAddressById('info');
        $recipients = array($customerEmail, $infoEmailAddress);
        $lname = $customer->getLastName();
        $userName = $customer->getName();
        if (isset($lname)) {
            $userName .= ' ' . $lname;
        }

        $orderJoinedDetailsDtos = $ordersManager->getOrderJoinedWithDetails($orderId);

        $goupedOrderJoinedDetailsDtos = $this->groupBundlesInOrderJoinedDetailsDtos($orderJoinedDetailsDtos);

        $paymentType = $orderJoinedDetailsDtos[0]->getPaymentType();
        $payment_option_values = explode(',', $this->getCmsVar('payment_option_values'));
        $payment_options_display_names_ids = explode(',', $this->getCmsVar('payment_options_display_names_ids'));
        $index = array_search($paymentType, $payment_option_values);
        $paymentTypeDisplayNameId = $payment_options_display_names_ids[$index];
        $subject = $this->getPhrase(299);
        if ($paymentType == 'credit') {
            $template = "customer_credit_order";
        } else {
            $template = "customer_cash_order";
        }
        $params = array("user_name" => $userName, "dtos" => $goupedOrderJoinedDetailsDtos, "itemManager" => ItemManager::getInstance(), "support_phone" => $this->getCmsVar('pcstore_support_phone_number'), 'paymentTypeDisplayNameId' => $paymentTypeDisplayNameId);
        if ($paymentType == 'credit') {
            $creditSuppliersManager = CreditSuppliersManager::getInstance();
            $csid = $orderJoinedDetailsDtos[0]->getCreditOrdersCreditSupplierId();
            $creditSupplierDto = $creditSuppliersManager->selectByPK($csid);
            $commission = $creditSupplierDto->getCommission();
            $grandTotalAMD = intval($orderJoinedDetailsDtos[0]->getOrderTotalAmd());
            $grandTotalAmdWithCommission = intval($grandTotalAMD / (1 - $commission / 100));
            $params['grandTotalAmdWithCommission'] = $grandTotalAmdWithCommission;
        }
        $emailSenderManager->sendEmail('orders', $recipients, $subject, $template, $params, '', '', true, false);
    }

    public function groupBundlesInOrderJoinedDetailsDtos($orderJoinedDetailsDtos) {
        $ret = array();
        $lbid = 0;
        foreach ($orderJoinedDetailsDtos as $key => $orderItem) {
            $bid = $orderItem->getOrderDetailsBundleId();
            if ($bid > 0) {
                if ($lbid != $bid) {
                    $ret[] = array($orderItem);
                } else {
                    $ret[count($ret) - 1][] = $orderItem;
                }
                $lbid = $bid;
            } else {
                $ret[] = $orderItem;
            }
        }
        return $ret;
    }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}

?>