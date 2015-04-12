<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ItemPicturesPopupLoad extends BaseAdminLoad {

    public function load() {
        $item_id = intval($_REQUEST['item_id']);
        $itemManager = ItemManager::getInstance();
        $itemDto = $itemManager->selectByPK($item_id);
        $this->addParam('itemDto', $itemDto);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/list_item_pictures_popup.tpl";
    }

}

?>