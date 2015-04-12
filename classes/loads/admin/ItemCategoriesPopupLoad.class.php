<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ItemCategoriesPopupLoad extends BaseAdminLoad {

    public function load() {
        $itemId = intval($_REQUEST['item_id']);
        $itemManager = ItemManager::getInstance();
        $itemDto = $itemManager->selectByPK($itemId);
        $categoriesIds = $itemDto->getCategoriesIds();
        $categoriesIds = trim($categoriesIds, ',');
        $this->addParam('item_categories', $categoriesIds);
        $this->addParam('item_id', $itemId);

        $categoryManager = CategoryManager::getInstance();
        $rootDto = $categoryManager->getRoot();
        $this->addParam('rootDto', $rootDto);
        $this->addParam('categoryManager', $categoryManager);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/list_item_categories_popup.tpl";
    }

}

?>