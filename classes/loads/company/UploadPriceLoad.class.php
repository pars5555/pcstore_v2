<?php

require_once (CLASSES_PATH . "/loads/company/BaseCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyExtendedProfileManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailServersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class UploadPriceLoad extends BaseCompanyLoad {

    public function load() {
        $companiesPriceListManager = CompaniesPriceListManager::getInstance();
        $companyId = $this->getUserId();
        $selectedCompanyId = $companyId;
        $companyPrices = $companiesPriceListManager->getCompanyHistoryPricesOrderByDate($selectedCompanyId, 0, 50);
        $this->addParam("company_prices", $companyPrices);
        $this->addParam("selectedCompanyId", $selectedCompanyId);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/company/upload_price.tpl";
    }

}

?>