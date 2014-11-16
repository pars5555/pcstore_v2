<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyDealersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class UsersLoad extends BaseAdminLoad {

    public function load() {
        $userManager = UserManager::getInstance();
        $allUsersDtos = $userManager->selectAll();
        $this->addParam("users", $allUsersDtos);
        $companyDealersManager = CompanyDealersManager::getInstance();
        $serviceCompanyDealersManager = ServiceCompanyDealersManager::getInstance();
        $allCompanyDealers = $companyDealersManager->getAllUsersCompaniesFull();
        $userCompanies = $this->getUserCompaniesArray($allCompanyDealers);
        $allServiceCompanyDealers = $serviceCompanyDealersManager->getAllUsersCompaniesFull();
        $userServiceCompanies = $this->getUserCompaniesArray($allServiceCompanyDealers);
        $this->addParam('userCompanies', $userCompanies);
        $this->addParam('userServiceCompanies', $userServiceCompanies);
    }

    private function getUserCompaniesArray($allCompanyDealers) {
        $ret = array();
        foreach ($allCompanyDealers as $companyDealerDto) {
            $userId = $companyDealerDto->getUserId();
            $companyName = $companyDealerDto->getCompanyName();
            $ret[$userId][] = $companyName;
        }
        return $ret;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/users.tpl";
    }

}

?>