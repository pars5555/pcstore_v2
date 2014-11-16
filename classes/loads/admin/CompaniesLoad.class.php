<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CompaniesLoad extends BaseAdminLoad {

    public function load() {
        $companyManager = CompanyManager::getInstance();
        $allCompaniesDtos = $companyManager->getAllCompanies(true, true);
        $this->addParam('allCompaniesDtos', $allCompaniesDtos);
        $selectedCompanyDto = null;
        if (isset($this->args[0])) {
            $selectedCompanyId = intval($this->args[0]);
            $selectedCompanyDto = $companyManager->selectByPK($selectedCompanyId);
            if (file_exists(DATA_IMAGE_DIR . '/company_logo/company_' . $selectedCompanyId . '_logo_120_75.png')) {
                $this->addParam('hasLogo', 1);
            }
        }
        $this->addParam("selectedCompanyDto", $selectedCompanyDto);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/companies.tpl";
    }

}

?>