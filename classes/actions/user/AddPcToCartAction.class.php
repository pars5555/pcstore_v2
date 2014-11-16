<?php

require_once (CLASSES_PATH . "/actions/user/BaseUserAction.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");
require_once (CLASSES_PATH . "/managers/BundleItemsManager.class.php");
require_once (CLASSES_PATH . "/managers/SpecialFeesManager.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/pcc_managers/PcConfiguratorManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class AddPcToCartAction extends BaseUserAction {

    public function service() {
        $customer = $this->getCustomer();
        $customerEmail = strtolower($customer->getEmail());
        $customerCartManager = CustomerCartManager::getInstance();
        $bundleItemsManager = BundleItemsManager::getInstance();
        $itemManager = ItemManager::getInstance();
        $userLevel = $this->getUserLevel();
        $user_id = $this->getUserId();
        if (isset($_REQUEST['bundle_items_ids'])) {
            $bundle_items_ids = $this->secure($_REQUEST['bundle_items_ids']);
        } else {
            $_SESSION['error_message'] = "System error: Try to add empty bundle to cart!";
            $this->redirect('buidpc');
        }
        $userManager = UserManager::getInstance();
        $vipCustomer = $userManager->isVip($customer);
        if ($vipCustomer) {
            $discount = floatval($this->getCmsVar('vip_pc_configurator_discount'));
        } else {
            $discount = floatval($this->getCmsVar('pc_configurator_discount'));
        }

        $bundle_display_name_id = 287;         //means "computer"
        $bundle_items_ids_array = explode(',', $bundle_items_ids);
        $itemsDto = $itemManager->getItemsForOrder($bundle_items_ids_array, $user_id, $userLevel);
        if (count($itemsDto) !== count($bundle_items_ids_array)) {
            $_SESSION['error_message'] = "Some items are not available!";
            $this->redirect('buidpc');
        }
        $last_dealer_price = 0;
        foreach ($itemsDto as $key => $itemDto) {
            $last_dealer_price += $itemDto->getDealerPrice();
        }
        $replaceing_bundle_id = null;
        if (isset($_REQUEST['replace_cart_row_id']) && $_REQUEST['replace_cart_row_id'] > 0) {
            $replace_cart_row_id = $_REQUEST['replace_cart_row_id'];
            $dto = $customerCartManager->selectByPK($replace_cart_row_id);
            if (isset($dto)) {
                $replaceing_bundle_id = $dto->getBundleId();
                $addedItemId = $customerCartManager->updateById($replace_cart_row_id, $customerEmail, 0, $replaceing_bundle_id, $last_dealer_price, $discount, $dto->getCount());
                $bundleItemsManager->deleteBundle($replaceing_bundle_id);
            } else {
                $_SESSION['error_message'] = "System Error: Bundle is not available in your cart!";
                $this->redirect('buidpc');
            }
        }

        $bundle_id = $bundleItemsManager->createBundle($bundle_display_name_id, $bundle_items_ids, "", $replaceing_bundle_id);

        if (!isset($addedItemId)) {
            $addedItemId = $customerCartManager->addToCart($customerEmail, 0, $bundle_id, $last_dealer_price, $add_count);
        }

        ///////////start add build fee if it should be add///////////////////

        $bundleItems = $customerCartManager->getCustomerCart($customerEmail, $user_id, $userLevel, $addedItemId);
        //list($bpAMD, $bpUSD, $specialFeesTotalAMD) = $bundleItemsManager->calcBundlePriceForCustomerWithoutDiscount($bundleItems, $userLevel);
        $specialFeesManager = SpecialFeesManager::getInstance();
        $pccm = PcConfiguratorManager::getInstance();
        $bundleProfitWithoutDiscountUSD = 0;
        if ($userLevel === UserGroups::$USER) {
            $bundleProfitWithoutDiscountUSD = $bundleItemsManager->calcBundleProfitWithDiscount($bundleItems, $discount);
        }
        $pcBuildFee = $pccm->calcPcBuildFee($bundleProfitWithoutDiscountUSD);
        $pcBuildFeeId = $specialFeesManager->getPcBuildFee()->getId();
        $special_fees = array($pcBuildFeeId => $pcBuildFee);
        if ($pcBuildFee > 0) {
            $bundleItemsManager->addSpecialFeesToBundle($bundle_id, $bundle_display_name_id, $special_fees);
        }
        ///////////end add  build fee if it should be add///////////////////
        $this->redirect('cart');
    }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}
