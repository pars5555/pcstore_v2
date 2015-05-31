<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportPriceManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ImportLoad extends BaseAdminLoad {

    public function load() {
        $companyManager = CompanyManager::getInstance();
        $allCompaniesDtos = $companyManager->getAllCompanies(true, true);
        $this->addParam('allCompaniesDtos', $allCompaniesDtos);
        $selectedCompanyDto = null;
        if (isset($this->args[0])) {
            $selectedCompanyId = intval($this->args[0]);
            $selectedCompanyDto = $companyManager->selectByPK($selectedCompanyId);
            $this->addParam("selectedCompanyDto", $selectedCompanyDto);
        $this->loadLastPrices($selectedCompanyId);
        }
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import.tpl";
    }

    public function loadLastPrices($companyId) {
        ini_set('max_execution_time', '120');
        ini_set('memory_limit', "1G");
        $importPriceManager = ImportPriceManager::getInstance();
        $companiesPriceListManager = CompaniesPriceListManager::getInstance();
        $companyLastPrices = $companiesPriceListManager->getCompanyLastPrices($companyId);
        $selectPriceIndex = 0;
        if (isset($_REQUEST['price_index'])) {
            $selectPriceIndex = intval($_REQUEST['price_index']);
        }
        $companyPriceNames = array();
        foreach ($companyLastPrices as $priceIndex => $priceDto) {
            $companyPriceNames[$priceIndex] = 'Price' . ($priceIndex + 1);
        }
        $this->addParam('price_names', $companyPriceNames);
        $this->addParam('selected_price_index', $selectPriceIndex);

        $companyPriceSheetsNames = $importPriceManager->getCompanyPriceSheetsNamesFromCache($companyId, $selectPriceIndex);
        $this->addParam('price_sheets_names', $companyPriceSheetsNames);
        $selectSheetIndex = 0;
        if (isset($_REQUEST['sheet_index'])) {
            $selectSheetIndex = intval($_REQUEST['sheet_index']);
        }
        $this->addParam('selected_sheet_index', $selectSheetIndex);

        $selected_rows_index = array();
        if (isset($_REQUEST['selected_rows_index']) && strlen($_REQUEST['selected_rows_index']) > 0) {
            $selected_rows_index = explode(',', $_REQUEST['selected_rows_index']);
        }
        $this->addParam('selected_rows_index', $selected_rows_index);


        $values = $importPriceManager->loadCompanyPriceFromCache($companyId, $selectPriceIndex, $selectSheetIndex);
        if (!$values) {
            $this->addParam('priceNotFound', true);
            return false;
        }
        $this->addParam('priceNotFound', false);
        /* foreach ($values as $rowKey => $row) {
          foreach ($row as $cellKey => $cellValue) {
          echo '[' . $rowKey . '][' . $cellKey . ']=' . $cellValue . ', ';
          }
          echo '<br>';
          }exit; */

        $this->addParam('priceColumnOptions', ImportPriceManager::$COLUMNS);
        $this->addParam('allColumns', array_keys($importPriceManager->getColumnsNamesMap()));
        $this->addParam('valuesByRows', $values);
        $itemModelColumnName = $importPriceManager->getItemModelColumnName();
        if (isset($itemModelColumnName)) {
            $this->addParam('modelColumnName', $itemModelColumnName);
        }

        $itemNameColumnName = $importPriceManager->getItemNameColumnName();
        $this->addParam('itemNameColumnName', $itemNameColumnName);


        $dealerPriceColumnName = $importPriceManager->getDealerPriceColumnName();
        if (isset($dealerPriceColumnName)) {
            $this->addParam('dealerPriceColumnName', $dealerPriceColumnName);
        }
        $dealerPriceAmdColumnName = $importPriceManager->getDealerPriceAmdColumnName();
        if (isset($dealerPriceAmdColumnName)) {
            $this->addParam('dealerPriceAmdColumnName', $dealerPriceAmdColumnName);
        }
        $vatPriceColumnName = $importPriceManager->getVatPriceColumnName();
        if (isset($vatPriceColumnName)) {
            $this->addParam('vatPriceColumnName', $vatPriceColumnName);
        }
        $vatPriceAmdColumnName = $importPriceManager->getVatPriceAmdColumnName();
        if (isset($vatPriceAmdColumnName)) {
            $this->addParam('vatPriceAmdColumnName', $vatPriceAmdColumnName);
        }
    }

}

?>