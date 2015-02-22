<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CreditManager.class.php");
require_once (CLASSES_PATH . "/managers/CreditSuppliersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CreditLoad extends BaseUserCompanyLoad {

    public function load() {
        $do_shipping = $_REQUEST["do_shipping"];
        $this->addParam("do_shipping", $do_shipping);
        
        $checkoutManager = CheckoutManager::getInstance();
        list($totalPromoDiscountAmd, $totalDealDiscountAmd,
                $all_non_bundle_items_has_vat, $minimum_order_amount_exceed,
                $customerCartChangesMessages, $discountAvailable, $pv,
                $groupedCartItems, $allItemsAreAvailable,
                $emptyCart, $grandTotalAMD, $grandTotalUSD, $calcCartTotalDealerPrice) = $checkoutManager->calculateCustomerCartParams($this->getCustomer(), $this->getUserLevel());
            $this->addParam("grandTotalAMD", $grandTotalAMD);
            $this->addParam("grandTotalUSD", $grandTotalUSD);

            //credit supplier
            $creditSuppliersManager = CreditSuppliersManager::getInstance();
            $allCreditSuppliers = $creditSuppliersManager->getAllCreditSuppliers();
            $allCreditSuppliers = $creditSuppliersManager->getCreditSuppliersInMapArrayById($allCreditSuppliers);
            $creditSuppliersDisplayNamesIds = $creditSuppliersManager->getSuppliersDisplayNameIdsArray($allCreditSuppliers);
            $creditSuppliersDisplayNames = $this->getPhrases($creditSuppliersDisplayNamesIds);
            $defaultCreditSupplierDto = reset($allCreditSuppliers);
            $selected_credit_supplier_id = $defaultCreditSupplierDto->getId();
            if (isset($_REQUEST['cho_credit_supplier_id'])) {
                $selected_credit_supplier_id = $_REQUEST['cho_credit_supplier_id'];
            }
            $_REQUEST['cho_credit_supplier_id'] = $selected_credit_supplier_id;
            $this->addParam("creditSuppliersIds", array_keys($allCreditSuppliers));
            $this->addParam("creditSuppliersDisplayNames", $creditSuppliersDisplayNames);

            $selectedCreditSupplierDto = $allCreditSuppliers[$selected_credit_supplier_id];

            //credit supplier possible months
            $possibleCreditMonths = explode(',', $selectedCreditSupplierDto->getPossibleCreditMonths());

            $cho_selected_credit_months = $possibleCreditMonths[0];
            if (isset($_REQUEST['cho_selected_credit_months'])) {
                $cho_selected_credit_months = $_REQUEST['cho_selected_credit_months'];
            }
            if (!in_array($cho_selected_credit_months, $possibleCreditMonths)) {
                $cho_selected_credit_months = $possibleCreditMonths[0];
            }
            $_REQUEST['cho_selected_credit_months'] = $cho_selected_credit_months;
            $this->addParam("cho_selected_credit_months", $cho_selected_credit_months);

            $this->addParam("possibleCreditMonths", $possibleCreditMonths);

            //deposit amount
            $depositAmd = 0;
            if (isset($_REQUEST['deposit_amd'])) {
                $depositAmd= intval($this->secure($_REQUEST['deposit_amd']));
            }
            $_REQUEST['deposit_amd'] = $depositAmd;
            
            $this->addParam("deposit_amd", $depositAmd);
            
            //credit supplier interest
            $commission = $selectedCreditSupplierDto->getCommission();
            $annualInterestPercent = floatval($selectedCreditSupplierDto->getAnnualInterestPercent());
            $credit_supplier_annual_commision = floatval($selectedCreditSupplierDto->getAnnualCommision());
            $this->addParam("credit_supplier_interest_percent", $annualInterestPercent);
            $this->addParam("credit_supplier_annual_commision", $credit_supplier_annual_commision);

            //credit monthly payment calculation
            $creditManager = CreditManager::getInstance();
            $monthlyPayment = $creditManager->calcCredit($grandTotalAMD, $depositAmd, $annualInterestPercent + $credit_supplier_annual_commision, $cho_selected_credit_months, $commission);
            $this->addParam("credit_monthly_payment", round($monthlyPayment));

            $this->addParam("minimum_credit_amount", intval($selectedCreditSupplierDto->getMinimumCreditAmount()));
            $grandTotalAmdWithCommission = intval($grandTotalAMD / (1 - $commission / 100));
            $this->addParam("grandTotalAmdWithCommission", $grandTotalAmdWithCommission);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/payment/credit.tpl";
    }

}

?>