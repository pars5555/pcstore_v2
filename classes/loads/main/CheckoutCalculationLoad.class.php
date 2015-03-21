<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CheckoutCalculationLoad extends BaseUserCompanyLoad {

    public function load() {
        $checkoutManager = CheckoutManager::getInstance();
        list($totalPromoDiscountAmd, $totalDealDiscountAmd,
                $all_non_bundle_items_has_vat, $minimum_order_amount_exceed,
                $customerCartChangesMessages, $discountAvailable, $pv,
                $groupedCartItems, $allItemsAreAvailable,
                $emptyCart, $grandTotalAMD, $grandTotalUSD, $calcCartTotalDealerPrice) = $checkoutManager->calculateCustomerCartParams($this->getCustomer(), $this->getUserLevel());
        $this->addParam('grandTotalUSD', $grandTotalUSD);
        $this->addParam('priceVariety', $pv);

        $doShipping = 0;
        if (isset($_POST['do_shipping'])) {
            $doShipping = intval($_POST['do_shipping']);
        }
        $this->addParam('do_shipping', $doShipping);
        $shippingCost = 0;
        if ($doShipping == 1 && $_POST['payment_type'] == 'credit') {
            $this->addParam("shipping_not_available_for_credit", 1);    
        }
        if ($doShipping == 1) {
            $region = $_POST['region'];
            $shippingCost = $checkoutManager->getShippingCost($region, $grandTotalAMD);
            if ($shippingCost >= 0) {
                $this->addParam('shipping_cost', $shippingCost);
            } else {
                $this->addParam('shipping_not_available', 1);
            }
        }
        
        $this->addParam('grandTotalAMD', $grandTotalAMD + $shippingCost);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/checkout_calculation.tpl";
    }

}

?>