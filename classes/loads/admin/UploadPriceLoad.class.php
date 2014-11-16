<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class UploadPriceLoad extends BaseAdminLoad {

    public function load() {
        $companyManager = CompanyManager::getInstance();
        $allCompaniesDtos = $companyManager->getAllCompanies(true, true);
        $this->addParam('allCompaniesDtos', $allCompaniesDtos);
        $selectedCompanyDto = null;
        if (isset($this->args[0])) {
            $selectedCompanyId = intval($this->args[0]);
            $selectedCompanyDto = $companyManager->selectByPK($selectedCompanyId);
        }
        $this->addParam("selectedCompanyDto", $selectedCompanyDto);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/upload_price.tpl";
    }

}

?>