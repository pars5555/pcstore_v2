<?php

require_once (CLASSES_PATH . "/actions/servicecompany/BaseServiceCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class UpdateProfileAction extends BaseServiceCompanyAction {

    public function service() {
        $serviceCompanyManager = new ServiceCompanyManager();
        $name = $this->secure($_REQUEST["name"]);
        $url = $this->secure($_REQUEST["url"]);
        $validFields = $this->validateUserProfileFields($name, $url);
        if ($this->getUserLevel() === UserGroups::$ADMIN) {
            $serviceCompanyId = intval($_REQUEST['company_id']);
        } else {
            $serviceCompanyId = $this->getUserId();
        }
        if ($_REQUEST['change_logo'] == 1) {
            $bigLgo = IMG_TMP_DIR . '/service_company_' . $serviceCompanyId . '_logo_120_75.png';
            $smallLgo = IMG_TMP_DIR . '/service_company_' . $serviceCompanyId . '_logo_55_30.png';
            if (file_exists($bigLgo) && file_exists($smallLgo)) {
                copy($bigLgo, DATA_IMAGE_DIR . '/service_company_logo/' . 'service_company_' . $serviceCompanyId . '_logo_120_75.png');
                copy($smallLgo, DATA_IMAGE_DIR . '/service_company_logo/' . 'service_company_' . $serviceCompanyId . '_logo_55_30.png');
            }
        }

        if ($validFields === true) {
            $serviceCompanyManager->updateProfile($serviceCompanyId, $name, $url);
            if ($this->getUserLevel() === UserGroups::$ADMIN) {
                $password = $this->secure($_REQUEST["password"]);
                $serviceCompanyManager->changePassword($serviceCompanyId, $password);
            }
            $_SESSION['success_message'] = $this->getPhrase(655);
            if ($this->getUserLevel() === UserGroups::$ADMIN) {
                $this->redirect('/admin/scompanies/' . $serviceCompanyId);
            } else {
                $this->redirect('scprofile');
            }
        } else {
            $_SESSION['error_message'] = $validFields;
            if ($this->getUserLevel() === UserGroups::$ADMIN) {
                $this->redirect('/admin/scompanies/' . $serviceCompanyId);
            } else {
                $this->redirect('scprofile');
            }
        }
    }

    public function validateUserProfileFields($name, $url) {

        if (empty($name)) {
            return $this->getPhrase(635);
        }
        if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->getPhrase(657);
        }
        return true;
    }

}

?>