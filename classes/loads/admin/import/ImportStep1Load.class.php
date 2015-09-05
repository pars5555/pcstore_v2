<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportPriceManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ImportStep1Load extends BaseAdminLoad {

    public function load() {
        ini_set('memory_limit', "2G");

        $company_id = $_REQUEST['company_id'];
        $price_index = $_REQUEST['price_index'];
        $sheet_index = $_REQUEST['sheet_index'];

        $companyManager = CompanyManager::getInstance();
        $companyDto = $companyManager->selectByPK($company_id);
        $this->addParam('companyDto', $companyDto);
        $this->addParam('company_id', $company_id);
        $this->addParam('price_index', $price_index);
        $this->addParam('sheet_index', $sheet_index);
        $price_values = PriceValuesManager::getInstance()->getCompanyPriceSheetValues($company_id, $price_index, $sheet_index);
        $this->addParam('price_values', $price_values);
        
        $this->addParam('columns_label', ImportPriceManager::$COLUMNS);
        
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import/step1.tpl";
    }

}

?>