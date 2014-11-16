<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ItemLoad extends BaseGuestLoad {

    public function load() {
        $customer = $this->getCustomer();
        $vipCustomer = false;
        if (isset($customer)) {
            $userManager = UserManager::getInstance();
            $vipCustomer = $userManager->isVip($customer);
        }
        if ($vipCustomer) {
            $pccDiscount = floatval($this->getCmsVar('vip_pc_configurator_discount'));
        } else {
            $pccDiscount = floatval($this->getCmsVar('pc_configurator_discount'));
        }


        $itemManager = ItemManager::getInstance();
        if (isset($_REQUEST["item_id"])) {
            $item_id = $_REQUEST["item_id"];
        } elseif ($this->args[0]) {
            $item_id = $this->args[0];
        }
        $selectedItemDto = $itemManager->selectByPK($item_id);
        $userLevel = $this->getUserLevel();
        $userId = $this->getUserId();
        $itemDto = $itemManager->getItemsForOrder($item_id, $userId, $userLevel, true);

        $this->addParam('item_id', $item_id);

        if ($itemDto) {
            $itemManager->growItemShowsCountByOne($itemDto);
            $itemPicturesCount = $itemDto->getPicturesCount();
            $this->addParam('item', $itemDto);

            //$this->addParam('userLevel', $userLevel);

            $this->addParam('itemManager', $itemManager);
            $this->addParam('itemPicturesCount', $itemPicturesCount);
            $this->addParam('itemPropertiesHierarchy', $itemManager->getItemProperties($item_id));
        }


        if ($this->getUserLevel() === UserGroups::$ADMIN) {
            $this->initRootCategories();
        }
    }

    private function initRootCategories() {
        $categoryManager = CategoryManager::getInstance();
        $categoryHierarchyManager = CategoryHierarchyManager::getInstance();
        $rootDto = $categoryManager->getRoot();

        $firstLevelCategoriesHierarchyDtos = $categoryHierarchyManager->getCategoryChildren($rootDto->getId());
        $firstLevelCategoriesNamesDtos = $categoryHierarchyManager->getCategoriesNamesByParentCategoryId($rootDto->getId());

        $firstLevelCategoriesIds = array();
        foreach ($firstLevelCategoriesHierarchyDtos as $key => $category) {
            $firstLevelCategoriesIds[] = $category->getChildId();
        }
        $firstLevelCategoriesNames = array();
        foreach ($firstLevelCategoriesNamesDtos as $key => $category) {
            $firstLevelCategoriesNames[] = $category->getDisplayName();
        }

        $this->addParam('firstLevelCategoriesNames', $firstLevelCategoriesNames);
        $this->addParam('firstLevelCategoriesIds', $firstLevelCategoriesIds);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/item.tpl";
    }

}

?>