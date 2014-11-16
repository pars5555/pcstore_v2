<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");
require_once (CLASSES_PATH . "/util/admin/categories/TreeView.php");
require_once (CLASSES_PATH . "/util/admin/categories/ItemsCategoryTreeView.php");
require_once (CLASSES_PATH . "/util/admin/categories/TreeViewModel.php");
require_once (CLASSES_PATH . "/util/admin/categories/ItemsCategoryTreeViewModel.php");
require_once (CLASSES_PATH . "/util/admin/categories/TreeNode.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CategoriesLoad extends BaseAdminLoad {

    public function load() {
        $categoryManager = CategoryManager::getInstance();
        $rootDto = $categoryManager->getRoot();
        $this->addParam('rootDto', $rootDto);
        $this->addParam('categoryManager', $categoryManager);
    }


    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/categories.tpl";
    }

}

?>