<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CategoryDetailsLoad extends BaseAdminLoad {

    public function load() {
        $categoryManager = CategoryManager::getInstance();
        //$categoryHierarchyManager = CategoryHierarchyManager::getInstance();
        $categoryId = $_REQUEST['category_id'];
        $categoryDto = $categoryManager->getCategoryById($categoryId);
        $this->addParam('categoryDto', $categoryDto);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/category_details.tpl";
    }

}

?>