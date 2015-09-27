<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ImportItemCategoriesPopupLoad extends BaseAdminLoad {

    public function load() {
        $categoriesIds = $this->secure($_REQUEST['categories_ids']);
        $categoriesIdsArray = [];
        if (!empty($categoriesIds)) {
            $categoriesIdsArray = explode(',', $categoriesIds);
        }
        $this->addParam('item_categories', $categoriesIds);
        $categoryManager = CategoryManager::getInstance();
        $rootDto = $categoryManager->getRoot();
        $this->addParam('rootDto', $rootDto);
        $this->addParam('categoryManager', $categoryManager);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import/import_item_categories_popup.tpl";
    }

}

?>