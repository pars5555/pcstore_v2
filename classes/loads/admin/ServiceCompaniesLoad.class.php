<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ServiceCompaniesLoad extends BaseAdminLoad {

    public function load() {
        $serviceCompanyManager = ServiceCompanyManager::getInstance();
        $allCompaniesDtos = $serviceCompanyManager->selectAll();
        $this->addParam('allCompaniesDtos', $allCompaniesDtos);
        $selectedServiceCompanyDto = null;
        if (isset($this->args[0])) {
            $selectedServiceCompanyId = intval($this->args[0]);
            $selectedServiceCompanyDto = $serviceCompanyManager->selectByPK($selectedServiceCompanyId);
            if (file_exists(DATA_IMAGE_DIR . '/service_company_logo/service_company_' . $selectedServiceCompanyId . '_logo_120_75.png')) {
                $this->addParam('hasLogo', 1);
            }
        }
        $this->addParam("selectedCompanyDto", $selectedServiceCompanyDto);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/service_companies.tpl";
    }

}

?>