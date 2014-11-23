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
        $item_id = intval($this->args[0]);
        $userLevel = $this->getUserLevel();
        $userId = $this->getUserId();
        $itemDto = $itemManager->getItemsForOrder($item_id, $userId, $userLevel, true);

        if ($itemDto) {
            $this->addParam('item_id', $itemDto->getId());
            $itemManager->growItemShowsCountByOne($itemDto);
            $itemPicturesCount = $itemDto->getPicturesCount();
            $this->addParam('item', $itemDto);
            $this->addParam('itemManager', $itemManager);
            $this->addParam('itemPicturesCount', $itemPicturesCount);
            $this->addParam('itemPropertiesHierarchy', $itemManager->getItemProperties($itemDto->getId()));
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

    protected function getPageDescription() {
        $item_id = intval($this->args[0]);
        if ($item_id <= 0) {
            return "";
        }
        $itemManager = ItemManager::getInstance();
        $itemDto = $itemManager->selectByPK($item_id, true);
        $brand = $itemDto->getBrand();
        $model = $itemDto->getModel();
        $displayName = $itemDto->getDisplayName();
        $description = "";
        if (!empty($brand)) {
            $description .= ($brand . ' ');
        }
        if (!empty($model)) {
            $description .= ($model . ' ');
        }
        if (!empty($displayName)) {
            $description .= $displayName;
        }
        return $description;
    }

    protected function getPageKeywords() {
         $item_id = intval($this->args[0]);
        if ($item_id <= 0) {
            return "";
        }
        $itemManager = ItemManager::getInstance();
        $itemDto = $itemManager->selectByPK($item_id, true);
        $brand = $itemDto->getBrand();
        $model = $itemDto->getModel();
        $displayName = $itemDto->getDisplayName();
        $keywords = "";
        if (!empty($brand)) {
            $keywords .= ($brand . ',');
        }
        if (!empty($model)) {
            $keywords .= ($model . ',');
        }
        if (!empty($displayName)) {
            $parts = preg_split('/ +/', $displayName);
            $keywords .= implode(',', $parts);
        }
        return $keywords;
    }

    protected function getPageTitle() {
        return $this->getPageDescription();
    }

}

?>