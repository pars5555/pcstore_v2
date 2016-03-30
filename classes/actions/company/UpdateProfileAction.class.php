<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class UpdateProfileAction extends BaseCompanyAction {

    public function service() {
        $companyManager = new CompanyManager();
        $name = $this->secure($_REQUEST["name"]);
        $url = $this->secure($_REQUEST["url"]);
        $validFields = $this->validateUserProfileFields($name, $url);
        if ($this->getUserLevel() === UserGroups::$ADMIN) {
            $companyId = intval($_REQUEST['company_id']);
        } else {
            $companyId = $this->getUserId();
        }
        if ($_REQUEST['change_logo'] == 1) {
            $bigLgo = IMG_TMP_DIR . '/company_' . $companyId . '_logo_120_75.png';
            $smallLgo = IMG_TMP_DIR . '/company_' . $companyId . '_logo_55_30.png';
            if (file_exists($bigLgo) && file_exists($smallLgo)) {
                copy($bigLgo, DATA_IMAGE_DIR . '/company_logo/' . 'company_' . $companyId . '_logo_120_75.png');
                copy($smallLgo, DATA_IMAGE_DIR . '/company_logo/' . 'company_' . $companyId . '_logo_55_30.png');
            }
        }

        if ($validFields === true) {
            $companyManager->updateProfile($companyId, $name, $url);
            if ($this->getUserLevel() === UserGroups::$ADMIN) {
                $password = $this->secure($_REQUEST["password"]);
                $companyManager->changePassword($companyId, $password);
            }
            $_SESSION['success_message'] = $this->getPhrase(655);
            if ($this->getUserLevel() === UserGroups::$ADMIN) {
                $this->redirect('/admin/companies/' . $companyId);
            } else {
                $this->redirect('cprofile');
            }
        } else {
            $_SESSION['error_message'] = $validFields;
            if ($this->getUserLevel() === UserGroups::$ADMIN) {
                $this->redirect('/admin/companies/' . $companyId);
            } else {
                $this->redirect('cprofile');
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