<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");
require_once (CLASSES_PATH . "/managers/BundleItemsManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");

class CartLoad extends BaseUserCompanyLoad {

    public function load() {
        $userManager = UserManager::getInstance();
        $customerCartManager = CustomerCartManager::getInstance();
        $checkoutManager = CheckoutManager::getInstance();
        $bundleItemsManager = BundleItemsManager::getInstance();
        $itemManager = ItemManager::getInstance();


        $customer = $this->getCustomer();
        $vipCustomer = $userManager->isVip($customer);
        if ($vipCustomer) {
            $pccDiscount = floatval($this->getCmsVar('vip_pc_configurator_discount'));
        } else {
            $pccDiscount = floatval($this->getCmsVar('pc_configurator_discount'));
        }


        $customerEmail = strtolower($customer->getEmail());
        $userLevel = $this->getUserLevel();
        $user_id = $this->getUserId();

        $_cartItemsDtos = $customerCartManager->getCustomerCart($customerEmail, $user_id, $userLevel);
        $_groupedCartItems = $customerCartManager->groupBundleItemsInArray($_cartItemsDtos);
        $checkoutManager->setCartItemsDiscount($_groupedCartItems, $pccDiscount);
        $cartItemsDtos = $customerCartManager->getCustomerCart($customerEmail, $user_id, $userLevel);
        $pv = $checkoutManager->getPriceVariety($cartItemsDtos, $userLevel);
        $discountAvailable = $checkoutManager->isDiscountAvailableForAtleastOneItem($cartItemsDtos);
        $groupedCartItems = $customerCartManager->groupBundleItemsInArray($cartItemsDtos);
        $cartChanges = $customerCartManager->getCustomerCartItemsChanges($groupedCartItems);
        $customerCartManager->setCustomerCartItemsPriceChangesToCurrentItemPrices($groupedCartItems);
        $customerCartChangesMessages = $checkoutManager->getCustomerCartChangesMessages($cartChanges);

        //all cart items, bundle items grouped in sub array
        $includeVat = intval($customer->getCartIncludedVat());

        if (!empty($_REQUEST['promo_codes'])) {
            $promoCodes = $this->secure($_REQUEST['promo_codes']);
            $cho_promo_codes_arrray = explode(',', $promoCodes);
            $validPromoDiscount = $checkoutManager->applyAllItemsPromoOnCartItems($groupedCartItems, $cho_promo_codes_arrray, $includeVat);
            $existingDealsPromoCodesArray = $checkoutManager->applyDealsDiscountsOnCartItems($groupedCartItems, $cho_promo_codes_arrray, $includeVat);
            $existingDealsPromoCodesArray [] = $validPromoDiscount;
            $_REQUEST['promo_codes'] = implode(',', $existingDealsPromoCodesArray);
        }

        list($grandTotalAMD, $grandTotalUSD) = $customerCartManager->calcCartTotal($groupedCartItems, true, $userLevel, $includeVat);
        $all_non_bundle_items_has_vat = $customerCartManager->checkAllNonBundleItemsHasVatPrice($groupedCartItems);
        if (!$all_non_bundle_items_has_vat && $includeVat == 1) {
            $customerCartChangesMessages[] = $this->getPhraseSpan(566);
        }
        $this->addParam("all_non_bundle_items_has_vat", $all_non_bundle_items_has_vat);
        $this->addParam("minimum_order_amount_exceed", $grandTotalAMD >= intval($this->getCmsVar("minimum_order_amount_amd")));
        $this->addParam("minimum_order_amount_amd", $this->getCmsVar("minimum_order_amount_amd"));
        if (!empty($customerCartChangesMessages)) {
            $this->addParam('customerMessages', $customerCartChangesMessages);
        }
        $allItemsAreAvailable = $customerCartManager->areAllItemsAvailableInCustomerCart($groupedCartItems);

        //discount available for at leat one item in the cart
        $this->addParam('discountAvailable', $discountAvailable);

        //priceVariety the price variety in customer cart. Can be 'amd', 'usd' or 'both'
        $this->addParam('priceVariety', $pv);
        $this->addParam('checkoutManager', $checkoutManager);
        //all cart items, bundle items grouped in sub array 
        $this->addParam('cartItems', $groupedCartItems);
        $this->addParam('itemManager', $itemManager);
        $this->addParam('allItemsAreAvailable', $allItemsAreAvailable);
        $this->addParam('emptyCart', empty($cartItemsDtos));
        $this->addParam('bundleItemsManager', $bundleItemsManager);
        //cart grand total included discounts, this is the final value that customer should pay for his cart (shipping cost not included)
        $this->addParam('grandTotalAMD', $grandTotalAMD);
        $this->addParam('grandTotalUSD', $grandTotalUSD);
        $this->addParam('maxItemCartCount', intval($this->getCmsVar('max_item_cart_count')));
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/cart/main.tpl";
    }

}

?>