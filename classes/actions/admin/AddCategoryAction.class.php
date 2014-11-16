<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class AddCategoryAction extends BaseAdminAction {

    public function service() {
        $categoryManager = new CategoryManager();
        $categoryHierarchyManager = new CategoryHierarchyManager();
        $categoryTitle = $this->secure($_REQUEST["title"]);
        $parentCategoryId = $this->secure($_REQUEST["parent_category_id"]);
        $sortIndex = count($categoryHierarchyManager->getCategoryChildrenIdsArray($parentCategoryId)) + 1;
        $categoryId = $categoryManager->addCategory($categoryTitle, '0', '0', '1');
        $categoryHierarchyManager->addSubCategoryToCategory($parentCategoryId, $categoryId, $sortIndex);
        $this->ok();
    }

}

?>