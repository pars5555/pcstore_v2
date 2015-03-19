<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/BannersManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class DeleteBannerAction extends BaseAdminAction {

    public function service() {
        $bannersManager = new BannersManager();
        $id = $_REQUEST['banner_id'];
        $bannersManager->deleteByPK($id);
        unlink(BANNERS_ROOT_DIR . '/' . $id . '.jpg');
        $this->redirect("admin/banners");
    }

}

?>