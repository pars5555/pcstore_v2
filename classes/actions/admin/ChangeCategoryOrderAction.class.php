<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ChangeCategoryOrderAction extends BaseAdminAction {

    public function service() {

        $categoryHierarchyManager = new CategoryHierarchyManager();
        $move_up = $this->secure($_REQUEST["move_up"]);
        $categoryId = $this->secure($_REQUEST["category_id"]);
        if ($move_up == '1') {
            $categoryHierarchyManager->MoveCategoryOrderUp($categoryId);
        } else {
            $categoryHierarchyManager->MoveCategoryOrderDown($categoryId);
        }
        $this->ok();
    }

}

?>