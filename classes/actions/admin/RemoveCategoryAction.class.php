<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class RemoveCategoryAction extends BaseAdminAction {

    public function service() {
        $categoryManager = CategoryManager::getInstance($this->config, $this->args);
        $categoryHierarchyManager = CategoryHierarchyManager::getInstance($this->config, $this->args);
        $categoryId = $this->secure($_REQUEST["category_id"]);
        if ($categoryHierarchyManager->hasCategoryChildren($categoryId)) {
            $this->error(array('message' => "You can only remove 'Leaf' categories!"));
        }
        $categoryManager->deleteByPK($categoryId);
        $categoryHierarchyManager->removeCategoryHierarchyByChildCategoryID($categoryId);
        //todo remove category name from items table `categories_names` field.  
        $this->ok();
    }

}

?>