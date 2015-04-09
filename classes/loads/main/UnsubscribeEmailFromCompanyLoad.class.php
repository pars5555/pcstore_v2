<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyExtendedProfileManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class UnsubscribeEmailFromCompanyLoad extends BaseGuestLoad {

    public function load() {
        if (!isset($this->args[0])) {
            exit;
        }
        if (!isset($this->args[1])) {
            exit;
        }
        if (!isset($_REQUEST['email'])) {
            exit;
        }
        $companyId = intval($this->args[1]);
        $serviceCompanyParam = $this->secure($this->args[0]);
        switch ($serviceCompanyParam) {
            case 'sc':
                $isServiceCompany = true;
                break;
            case 'c':
                $isServiceCompany = false;
                break;
            default:
                exit;
        }
        if ($isServiceCompany) {
            $companyExtendedProfileManager = ServiceCompanyExtendedProfileManager::getInstance();
        } else {
            $companyExtendedProfileManager = CompanyExtendedProfileManager::getInstance();
        }
        $md_email = $this->secure($_REQUEST['email']);
        $companyExtendedProfileManager->addUnsubscribeEmailForCompany($companyId, $md_email);
    }

    public function getDefaultLoads($args) {
        $loads = array();
        return $loads;
    }

    public function isValidLoad($namespace, $load) {
        return true;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/unsubscribe_email_from_company.tpl";
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

    protected function logRequest() {
        return false;
    }

}

?>