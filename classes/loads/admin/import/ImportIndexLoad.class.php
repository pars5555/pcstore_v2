<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportPriceManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ImportIndexLoad extends BaseAdminLoad {

    public function load() {
        $this->initSucessMessages();
        $companyManager = CompanyManager::getInstance();
        $allCompaniesDtos = $companyManager->getAllCompanies(true, true);
        $this->addParam('allCompaniesDtos', $allCompaniesDtos);
        $selectedCompanyDto = null;
        if (isset($this->args[0])) {
            $selectedCompanyId = intval($this->args[0]);
            $selectedCompanyDto = $companyManager->selectByPK($selectedCompanyId);
            $this->addParam("selectedCompanyDto", $selectedCompanyDto);
            $this->loadCompanyPricesList($selectedCompanyId);
        }
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import/index.tpl";
    }

    private function loadCompanyPricesList($companyId) {
        $companiesPriceListManager = CompaniesPriceListManager::getInstance();
        $companyLastPrices = $companiesPriceListManager->getCompanyLastPrices($companyId);
        $companyPriceNames = array();
        foreach ($companyLastPrices as $priceIndex => $priceDto) {
            $companyPriceNames[$priceIndex] = 'Price' . ($priceIndex + 1);
        }
        $this->addParam('price_names', $companyPriceNames);
    }

}

?>