<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/BundleItemsManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");

class CartLoad extends BaseUserCompanyLoad {

    public function load() {
        $bundleItemsManager = BundleItemsManager::getInstance();
        $itemManager = ItemManager::getInstance();
        $checkoutManager = CheckoutManager::getInstance();

        $this->addParam('maxItemCartCount', intval($this->getCmsVar('max_item_cart_count')));
        $this->addParam("minimum_order_amount_amd", $this->getCmsVar("minimum_order_amount_amd"));
        $this->addParam('checkoutManager', $checkoutManager);
        $this->addParam('itemManager', $itemManager);
        $this->addParam('bundleItemsManager', $bundleItemsManager);

        list($totalPromoDiscountAmd, $totalDealDiscountAmd,
                $all_non_bundle_items_has_vat, $minimum_order_amount_exceed,
                $customerCartChangesMessages, $discountAvailable, $pv,
                $groupedCartItems, $allItemsAreAvailable,
                $emptyCart, $grandTotalAMD, $grandTotalUSD, $calcCartTotalDealerPrice) = $checkoutManager->calculateCustomerCartParams($this->getCustomer(), $this->getUserLevel());
        $this->addParam("all_non_bundle_items_has_vat", $all_non_bundle_items_has_vat);
        $this->addParam("minimum_order_amount_exceed", $minimum_order_amount_exceed);
        if (!empty($customerCartChangesMessages)) {
            $this->addParam('customerMessages', $customerCartChangesMessages);
        }
        $this->addParam("totalPromoDiscountAmd", $totalPromoDiscountAmd);
        $this->addParam("totalDealDiscountAmd", $totalDealDiscountAmd);
        $this->addParam('discountAvailable', $discountAvailable);

        //priceVariety the price variety in customer cart. Can be 'amd', 'usd' or 'both'
        $this->addParam('priceVariety', $pv);
        $this->addParam('checkoutManager', $checkoutManager);
        //all cart items, bundle items grouped in sub array 
        $this->addParam('cartItems', $groupedCartItems);
        $this->addParam('itemManager', $itemManager);
        $this->addParam('allItemsAreAvailable', $allItemsAreAvailable);
        $this->addParam('emptyCart', $emptyCart);
        $this->addParam('bundleItemsManager', $bundleItemsManager);
        //cart grand total included discounts, this is the final value that customer should pay for his cart (shipping cost not included)
        $this->addParam('grandTotalAMD', $grandTotalAMD);
        $this->addParam('grandTotalUSD', $grandTotalUSD);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/cart/main.tpl";
    }

}

?>