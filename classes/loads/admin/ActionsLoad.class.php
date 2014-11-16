<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");


/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ActionsLoad extends BaseAdminLoad {

    public function load() {
        $companyManager = CompanyManager::getInstance();
        $allCompanies = $companyManager->getAllCompanies(true, true);
        $companies = array();
        $companies[0] = 'All';
        foreach ($allCompanies as $company) {
            $companies[$company->getId()] = $company->getName();
        }
        $this->addParam("companies", $companies);
    }


    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/actions.tpl";
    }

}

?>