<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/BannersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class BannersLoad extends BaseAdminLoad {

    public function load() {
        $this->initErrorMessages();
        $this->initSucessMessages();
        $bannersManager = BannersManager::getInstance();
        $bannersDtos = $bannersManager->selectAll();
        $this->addParam('bannersDtos', $bannersDtos);
    }


    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/banners.tpl";
    }

}

?>