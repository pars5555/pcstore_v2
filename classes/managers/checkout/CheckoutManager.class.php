<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");
require_once (CLASSES_PATH . "/managers/BundleItemsManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/SpecialFeesManager.class.php");
require_once (CLASSES_PATH . "/managers/DealsManager.class.php");
require_once (CLASSES_PATH . "/managers/DiscountPromoCodesManager.class.php");
require_once (CLASSES_PATH . "/managers/SpecialFeesManager.class.php");

/**
 * PcConfiguratorManager class is responsible for creating,
 */
class CheckoutManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
     *

     * @return
     */
    function __construct() {


        //$this->itemManager = ItemManager::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CheckoutManager();
        }
        return self::$instance;
    }

    public function initShippingParamsFromRequest() {
        $cho_include_vat = $_REQUEST['cho_include_vat'];
        $cho_do_shipping = $_REQUEST['cho_do_shipping'];
        $cho_shipping_recipient_name = $_REQUEST['cho_shipping_recipient_name'];
        $cho_shipping_address = $_REQUEST['cho_shipping_address'];
        $cho_shipping_region = $_REQUEST['cho_shipping_region'];
        $cho_shipping_tel = $_REQUEST['cho_shipping_tel'];
        $cho_shipping_cell = $_REQUEST['cho_shipping_cell'];
        $cho_payment_type = $_REQUEST['cho_payment_type'];
        $cho_credit_supplier_id = $_REQUEST['cho_credit_supplier_id'];
        $cho_selected_deposit_amount = $_REQUEST['cho_selected_deposit_amount'];
        $cho_selected_credit_months = $_REQUEST['cho_selected_credit_months'];
        $metadataObject = null;
        if ($cho_payment_type === 'bank') {
            $cho_company_name = $this->secure($_REQUEST['cho_company_name']);
            $cho_company_hvhh = $this->secure($_REQUEST['cho_company_hvhh']);
            $cho_company_address = $this->secure($_REQUEST['cho_company_address']);
            $cho_company_bank = $this->secure($_REQUEST['cho_company_bank']);
            $cho_company_bank_account_number = $this->secure($_REQUEST['cho_company_bank_account_number']);
            $cho_company_delivering_address = $this->secure($_REQUEST['cho_company_delivering_address']);
            $metadataObject = new stdClass();
            $metadataObject->company_name = $cho_company_name;
            $metadataObject->company_hvhh = $cho_company_hvhh;
            $metadataObject->company_address = $cho_company_address;
            $metadataObject->company_bank = $cho_company_bank;
            $metadataObject->bank_account_number = $cho_company_bank_account_number;
            $metadataObject->company_delivering_address = $cho_company_delivering_address;
        }

        $billing_is_different_checkbox = $_REQUEST['billing_is_different_checkbox'];
        if ($billing_is_different_checkbox != '1') {
            $cho_billing_recipient_name = $cho_shipping_recipient_name;
            $cho_billing_address = $cho_shipping_address;
            $cho_billing_region = $cho_shipping_region;
            $cho_billing_tel = $cho_shipping_tel;
            $cho_billing_cell = $cho_shipping_cell;
        } else {
            $cho_billing_recipient_name = $_REQUEST['cho_billing_recipient_name'];
            $cho_billing_address = $_REQUEST['cho_billing_address'];
            $cho_billing_region = $_REQUEST['cho_billing_region'];
            $cho_billing_cell = $_REQUEST['cho_billing_cell'];
            $cho_billing_tel = $_REQUEST['cho_billing_tel'];
        }
        $cho_apply_user_points = $_REQUEST['cho_apply_user_points'];

        return array($cho_include_vat, $cho_do_shipping, $cho_shipping_recipient_name,
            $cho_shipping_address, $cho_shipping_region, $cho_shipping_tel,
            $cho_shipping_cell, $billing_is_different_checkbox, $cho_billing_recipient_name,
            $cho_billing_address, $cho_billing_region, $cho_billing_tel, $cho_billing_cell,
            $cho_payment_type, $cho_apply_user_points, $cho_credit_supplier_id,
            $cho_selected_deposit_amount, $cho_selected_credit_months, $metadataObject);
    }

    /**
     * @param $groupedCartItems should have getCustomerCart function format and
     * then group the result item using groupBundleItemsInArray function.
     * Return following format
     * array("CartRowId"=>change, ...)
     * if change is array(0=>ItemDisplayName, 1=>false) meanse item is not available,
     * if change is array(0=>ItemDisplayName, 1=>oldDealerPrice, 2=>currentDealerPrice) then meanse item price is changed
     * if change is array("ItemId"=>change, ...) meanse item is bundle and there are changes,
     */
    public function getCustomerCartChangesMessages($cartChanges) {
        if (empty($cartChanges)) {
            return array();
        }
        $messages = array();
        foreach ($cartChanges as $cartRowId => $change) {
            if (isset($change[0]) && isset($change[1]) && isset($change[2])) {
                $messages[] = $this->getItemPriceChangedMessage($change[0], $change[1], $change[2]);
                //this is the case that item price is changed
            } else if (isset($change[0]) && isset($change[1])) {
                //this is the case that item is not available
                $messages[] = $this->getItemNoLongerAvailableMessage($change[0]);
            } else {
                //TODO show all details messages to user about bundle's items changes
                foreach ($change as $itemId => $itemChange) {
                    if (isset($itemChange[0]) && isset($itemChange[1]) && isset($itemChange[2])) {
                        $messages[] = $this->getItemPriceChangedMessage($itemChange[0], $itemChange[1], $itemChange[2]);
                        //this is the case that item price is changed
                    } else if (isset($itemChange[0]) && isset($itemChange[1])) {
                        //this is the case that item is not available
                        $messages[] = $this->getItemNoLongerAvailableMessage($itemChange[0]);
                    }
                }
            }
        }
        return $messages;
    }

    public function applyDealsDiscountsOnCartItems($groupedCartItems, $promo_codes_arrray, $vatIncluded = 0) {
        $dealsManager = DealsManager::getInstance();
        $realDealsPromos = array();
        $totalDiscountAmd = 0;
        foreach ($promo_codes_arrray as $promoCode) {

            $deal = $dealsManager->getDealsByPromoCode($promoCode);

            if (isset($deal)) {
                list($dealExist, $tdAmd) = $this->applyDealItemDiscountOnCustomerCartItems($groupedCartItems, $deal, $vatIncluded);
                if ($dealExist) {
                    $totalDiscountAmd+=$tdAmd;
                    if (!in_array($deal->getPromoCode(), $realDealsPromos)) {
                        $realDealsPromos[] = $deal->getPromoCode();
                    }
                }
            }
        }
        return array($realDealsPromos, $totalDiscountAmd);
    }

    public function applyAllItemsPromoOnCartItems($groupedCartItems, $promo_codes_arrray, $vatIncluded = 0) {
        $discountPromoCodesManager = DiscountPromoCodesManager::getInstance();
        foreach ($promo_codes_arrray as $promoCode) {
            $dto = $discountPromoCodesManager->getByPromoCode($promoCode);
            if (isset($dto) && $dto->getEnable() == 1) {
                $totalDiscountAmd = $this->applyDiscountPromoOnCustomerCartItems($groupedCartItems, $dto, $vatIncluded);
                return array($promoCode, $totalDiscountAmd);
            }
        }
        return array(null, 0);
    }

    public function setCartItemsDiscount($groupedCartItems, $pccDiscount) {
        $customerCartManager = CustomerCartManager::getInstance();
        foreach ($groupedCartItems as $ci) {
            if (is_array($ci)) {
                $customerCartManager->setItemDiscount($ci[0]->getId(), $pccDiscount);
            }
        }
    }

    public function getBundleItemTotalDealsDiscountAMD($bundleItem) {
        $ret = 0;
        foreach ($bundleItem as $item) {
            if ($item->getDealDiscountAmd() > 0) {
                $ret +=$item->getDealDiscountAmd();
            }
        }
        return $ret;
    }

    public function getCartTotalDealsDiscountAMD($groupedCartItems) {
        $ret = 0;
        foreach ($groupedCartItems as $cartUnit) {
            if (is_array($cartUnit)) {
                $bundleItemTotalDealsDiscountAMD = $this->getBundleItemTotalDealsDiscountAMD($cartUnit);
                if ($bundleItemTotalDealsDiscountAMD > 0) {
                    $bundleCount = intval($cartUnit[0]->getCount());
                    $ret +=$bundleItemTotalDealsDiscountAMD * $bundleCount;
                }
            } else {
                if ($cartUnit->getDealDiscountAmd() > 0) {
                    $ret+=$cartUnit->getDealDiscountAmd() * $cartUnit->getCount();
                }
            }
        }
        return $ret;
    }

    public function applyDealItemDiscountOnCustomerCartItems($groupedCartItems, $dealDto, $vatIncluded = 0) {
        $itemManager = ItemManager::getInstance();
        $dealItemId = $dealDto->getItemId();
        $dealPrice = $dealDto->getPriceAmd();
        $dealExist = false;
        $totalDiscountAmd = 0;
        foreach ($groupedCartItems as $cartUnit) {
            if (is_array($cartUnit)) {
                foreach ($cartUnit as $bundleItem) {
                    $itemId = $bundleItem->getBundleItemId();
                    if ($itemId == $dealItemId && $bundleItem->isDealerOfThisCompany() == 0) {
                        $customerItemPriceAmd = $itemManager->exchangeFromUsdToAMD($bundleItem->getCustomerItemPrice());
                        $discoutAMD = $customerItemPriceAmd - $dealPrice;
                        $bundleItem->setDealDiscountAmd($discoutAMD);
                        $totalDiscountAmd+=intval($bundleItem->getBundleItemCount())*$discoutAMD;
                        $dealExist = true;
                    }
                }
            } else {
                $itemId = $cartUnit->getItemId();
                if ($itemId == $dealItemId && $cartUnit->isDealerOfThisCompany() == 0) {
                    $discoutAMD = 0;
                    if ($vatIncluded == 1) {
                        $customerItemPriceAmd = $itemManager->exchangeFromUsdToAMD($cartUnit->getCustomerVatItemPrice());
                        $discoutAMD = $customerItemPriceAmd - $dealPrice;
                    } else {
                        $customerItemPriceAmd = $itemManager->exchangeFromUsdToAMD($cartUnit->getCustomerItemPrice());
                        $discoutAMD = $customerItemPriceAmd - $dealPrice;
                    }
                    $totalDiscountAmd+=intval($cartUnit->getCount())*$discoutAMD;
                    $cartUnit->setDealDiscountAmd($discoutAMD);
                    $dealExist = true;
                }
            }
        }
        return array($dealExist, $totalDiscountAmd);
    }

    public function applyDiscountPromoOnCustomerCartItems($groupedCartItems, $discountDto, $vatIncluded = 0) {
        $totalDiscountAmd = 0;
        $itemManager = ItemManager::getInstance();
        $discountParam = 1 - intval($discountDto->getDiscountPercent()) / 100;
        foreach ($groupedCartItems as $cartUnit) {
            if (is_array($cartUnit)) {
                foreach ($cartUnit as $bundleItem) {
                    if ($bundleItem->getIsDealerOfThisCompany() == 0) {
                        $itemId = $bundleItem->getBundleItemId();
                        $itemDto = $itemManager->selectByPK($itemId);
                        if (isset($itemDto)) {
                            $itemListPrice = $itemDto->getListPriceAmd();
                            $itemPriceAfterDiscount = $itemListPrice * $discountParam;
                            $customerItemPriceAmd = $itemManager->exchangeFromUsdToAMD($bundleItem->getCustomerItemPrice());
                            $discoutAMD = $customerItemPriceAmd - $itemPriceAfterDiscount;
                            if ($discoutAMD <= 0) {
                                $discoutAMD = 0;
                            }
                            if ($bundleItem->getDealDiscountAmd() < $discoutAMD) {
                                
                                $totalDiscountAmd+=intval($bundleItem->getBundleItemCount())*$discoutAMD;
                                $bundleItem->setDealDiscountAmd($discoutAMD);
                            }
                        }
                    }
                }
            } else {
                $itemId = $cartUnit->getItemId();
                if ($cartUnit->isDealerOfThisCompany() == 0) {
                    if ($vatIncluded != 1) {
                        $itemDto = $itemManager->selectByPK($itemId);
                        $itemListPrice = $itemDto->getListPriceAmd();
                        $itemListPrice = $itemDto->getListPriceAmd();
                        $itemPriceAfterDiscount = $itemListPrice * $discountParam;
                        $customerItemPriceAmd = $itemManager->exchangeFromUsdToAMD($cartUnit->getCustomerItemPrice());
                        $discoutAMD = $customerItemPriceAmd - $itemPriceAfterDiscount;
                        if ($discoutAMD <= 0) {
                            $discoutAMD = 0;
                        }
                        if ($cartUnit->getDealDiscountAmd() < $discoutAMD) {
                            
                            $totalDiscountAmd+=intval($cartUnit->getCount())*$discoutAMD;
                            $cartUnit->setDealDiscountAmd($discoutAMD);
                        }
                    }
                }
            }
        }
        return $totalDiscountAmd;
    }

    public function getItemPriceChangedMessage($itemDisplayName, $itemOldPrice, $itemCurrentPrice) {
        if ($itemOldPrice < $itemCurrentPrice) {
            return $this->getPhraseSpan(369) . ' - ' . $itemDisplayName;
        } else {
            return $this->getPhraseSpan(371) . ' - ' . $itemDisplayName;
        }
    }

    public function getItemNoLongerAvailableMessage($itemDisplayName) {
        if (strlen($itemDisplayName) > 100) {
            $itemDisplayName = substr($itemDisplayName, 0, 100) . '...';
        }
        return $itemDisplayName . ' - ' . $this->getPhraseSpan(294);
    }

    public function getBundleChangeMessage($itemDisplayName) {
        if (strlen($itemDisplayName) > 100) {
            $itemDisplayName = substr($itemDisplayName, 0, 100) . '...';
        }
        return $itemDisplayName . ' - ' . $this->getPhraseSpan(294);
    }

    /**
     * Returns 'amd' if $cartItemsDtos contains only AMD items for customer,
     * 				 'usd' if $cartItemsDtos contains only USD items for customer,
     *   	 		 'both' if $cartItemsDtos contains both AMD and USD items for customer.
     *   	 		 null if $cartItemsDtos is empty.
     */
    public function getPriceVariety($cartItemsDtos, $userLevel) {
        assert(is_array($cartItemsDtos));
        if (empty($cartItemsDtos)) {
            return null;
        }
        $isUsdItem = (($cartItemsDtos[0]->getIsDealerOfThisCompany() == 1) || $userLevel == UserGroups::$ADMIN || $userLevel == UserGroups::$COMPANY) && !($cartItemsDtos[0]->getSpecialFeePrice() > 0);
        $ret = $isUsdItem ? 'usd' : 'amd';
        foreach ($cartItemsDtos as $cartItem) {
            $isUsdItem = (($cartItem->getIsDealerOfThisCompany() == 1) || $userLevel == UserGroups::$ADMIN || $userLevel == UserGroups::$COMPANY) && !($cartItem->getSpecialFeePrice() > 0);
            if ($isUsdItem && $ret === 'amd')
                return 'both';
            if (!$isUsdItem && $ret === 'usd')
                return 'both';
        }
        return $ret;
    }

    public function isDiscountAvailableForAtleastOneItem($cartItemsDtos) {
        assert(is_array($cartItemsDtos));
        if (empty($cartItemsDtos)) {
            return false;
        }
        foreach ($cartItemsDtos as $key => $cartItem) {
            if ($cartItem->getDiscount() > 0)
                return true;
        }
        return false;
    }

    public function getCustomerCartGrandTotals($customer, $sesUser, $userLevel) {
        $customerEmail = strtolower($customer->getEmail());
        $customerCartManager = CustomerCartManager::getInstance();
        $userLevel = $sesUser->getLevel();
        $user_id = $sesUser->getId();
        $cartItemsDtos = $customerCartManager->getCustomerCart($customerEmail, $user_id, $userLevel);
        $groupedCartItems = $customerCartManager->groupBundleItemsInArray($cartItemsDtos);
        list($grandTotalAMD, $grandTotalUSD) = $customerCartManager->calcCartTotal($groupedCartItems, true, $userLevel);
        return array($grandTotalAMD, $grandTotalUSD);
    }

    public function calculateCustomerCartParams($customer, $userLevel) {
        $userManager = UserManager::getInstance();
        $customerCartManager = CustomerCartManager::getInstance();
        $checkoutManager = CheckoutManager::getInstance();


        $vipCustomer = $userManager->isVip($customer);
        if ($vipCustomer) {
            $pccDiscount = floatval($this->getCmsVar('vip_pc_configurator_discount'));
        } else {
            $pccDiscount = floatval($this->getCmsVar('pc_configurator_discount'));
        }
        $customerEmail = strtolower($customer->getEmail());
        $user_id = $customer->getId();

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

        $calcCartTotalDealerPrice = $customerCartManager->calcCartTotalDealerPrice($cartItemsDtos, $customer->getCartIncludedVat());
        //all cart items, bundle items grouped in sub array
        $includeVat = intval($customer->getCartIncludedVat());
        $totalPromoDiscountAmd = 0;
        $totalDealDiscountAmd = 0;
        if (!empty($_COOKIE['promo_codes'])) {
            $promoCodes = $this->secure($_COOKIE['promo_codes']);
            $promoCodsArray = explode(',', $promoCodes);
            list($existingDealsPromoCodesArray, $totalDealDiscountAmd) = $checkoutManager->applyDealsDiscountsOnCartItems($groupedCartItems, $promoCodsArray, $includeVat);
            list($validPromoDiscount, $totalPromoDiscountAmd) = $checkoutManager->applyAllItemsPromoOnCartItems($groupedCartItems, $promoCodsArray, $includeVat);
            $existingDealsPromoCodesArray [] = $validPromoDiscount;
            $_COOKIE['promo_codes'] = implode(',', $existingDealsPromoCodesArray);
            setcookie('promo_codes', $_COOKIE['promo_codes'], time() + 60 * 60 * 24, '/');
        }
        list($grandTotalAMD, $grandTotalUSD) = $customerCartManager->calcCartTotal($groupedCartItems, true, $userLevel, $includeVat);
        $all_non_bundle_items_has_vat = $customerCartManager->checkAllNonBundleItemsHasVatPrice($groupedCartItems);
        if (!$all_non_bundle_items_has_vat && $includeVat == 1) {
            $customerCartChangesMessages[] = $this->getPhraseSpan(566);
        }
        $minimum_order_amount_exceed = $grandTotalAMD >= intval($this->getCmsVar("minimum_order_amount_amd"));

        if (!empty($customerCartChangesMessages)) {
            //$this->addParam('customerMessages', $customerCartChangesMessages);
        }
        $allItemsAreAvailable = $customerCartManager->areAllItemsAvailableInCustomerCart($groupedCartItems);
        return array($totalPromoDiscountAmd, $totalDealDiscountAmd, $all_non_bundle_items_has_vat, $minimum_order_amount_exceed, $customerCartChangesMessages,
            $discountAvailable, $pv, $groupedCartItems, $allItemsAreAvailable, empty($cartItemsDtos), $grandTotalAMD, $grandTotalUSD, $calcCartTotalDealerPrice);
    }

    public function getShippingCost($region, $grandTotalAMD) {
        $specialFeesManager = SpecialFeesManager::getInstance();
        $shippingCostDto = $specialFeesManager->getShippingCost($region);
        if (isset($shippingCostDto)) {
            if ($grandTotalAMD < intval($this->getCmsVar('shipping_in_yerevan_free_amd_over'))) {
                return intval($shippingCostDto->getPrice());
            } else {
                return 0;
            }
        } else {
            return -1;
        }
    }

    public function getMapper() {
        return null;
    }

}

?>