<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/CmsSettingsManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SaveSettingAction extends BaseAdminAction {

    public function service() {
        $var = $this->secure($_REQUEST['var']);
        $value = $_REQUEST['value'];
        $cmsSettings = CmsSettingsManager::getInstance();
        $cmsSettings->updateTextField($var, 'value', $value, false);
        $this->redirect('admin/settings');
    }

}

?>