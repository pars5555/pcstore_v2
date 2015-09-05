<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportPriceManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ImportSheetLoad extends BaseAdminLoad {

    public function load() {
        ini_set('memory_limit', "2G");

        $company_id = $_REQUEST['company_id'];
        $price_index = $_REQUEST['price_index'];

        $companyManager = CompanyManager::getInstance();
        $companyDto = $companyManager->selectByPK($company_id);
        $this->addParam('companyDto', $companyDto);
        $this->addParam('company_id', $company_id);
        $this->addParam('price_index', $price_index);
        $companyPriceSheetsNamesFromCache = ImportPriceManager::getInstance()->getCompanyPriceSheetsNamesFromCache($company_id, $price_index);
        $this->addParam('sheets', $companyPriceSheetsNamesFromCache);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import/sheet.tpl";
    }

}

?>