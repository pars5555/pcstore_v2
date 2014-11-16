<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ChangeCategoryAttributesAction extends BaseAdminAction {

    public function service() {

        $categoryManager = new CategoryManager();
        $categoryId = $this->secure($_REQUEST["category_id"]);
        $display_name = $this->secure($_REQUEST["name"]);
        $last_clickable = $this->secure($_REQUEST["is_last_clickable"]);
        $categoryDto = $categoryManager->getCategoryById($categoryId);
        if (!isset($categoryDto)) {
            $this->error(array('message' => "System Error: Category doesn't exist!"));
        }
        $categoryManager->updateCategoryAttributes($categoryId, $display_name, $last_clickable);
        $this->ok();
    }

}

?>