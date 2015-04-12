<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SaveItemCategoriesAction extends BaseAdminAction {

    public function service() {
        $itemId = $this->secure($_REQUEST['item_id']);
        $categories_ids = $this->secure($_REQUEST['categories_ids']);
        $categoriesIdsArray = explode(',', trim($categories_ids, ','));
        $itemManager = ItemManager::getInstance();
        $itemManager->setItemCategories($itemId, $categoriesIdsArray);
        $this->ok();
    }

}

?>