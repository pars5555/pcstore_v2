<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CmsSettingsManager.class.php");


/**
 *
 * @author Vahagn Sookiasian
 *
 */
class SettingsLoad extends BaseAdminLoad {

    public function load() {
        $cmsSettings = CmsSettingsManager::getInstance();
        $allSettings  =$cmsSettings ->selectAll();
        $this->addParam('settings', $allSettings);
    }


    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/settings.tpl";
    }

}

?>