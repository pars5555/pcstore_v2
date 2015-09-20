<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportPriceManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportItemsTempManager.class.php");
require_once (CLASSES_PATH . "/managers/PriceTranslationsManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ImportStep2Load extends BaseAdminLoad {

    public function load() {
        ini_set('max_execution_time', '120');
        if (!isset($_REQUEST['company_id']) || !isset($_REQUEST['price_index']) || !isset($_REQUEST['sheet_index'])) {
            $this->redirect('admin/import');
        }
        $company_id = $_REQUEST['company_id'];
        $price_index = $_REQUEST['price_index'];
        $sheet_index = $_REQUEST['sheet_index'];
        $select_columns = $_REQUEST['select_values'];
        $select_columns = (array) json_decode($select_columns);
        $selected_row_ids = $_REQUEST['selected_row_ids'];
        $selected_row_ids_array = explode(',', $_REQUEST['selected_row_ids']);

        $companyManager = CompanyManager::getInstance();
        $companyDto = $companyManager->selectByPK($company_id);

        $this->addParam('companyDto', $companyDto);
        $this->addParam('company_id', $company_id);
        $this->addParam('price_index', $price_index);
        $this->addParam('sheet_index', $sheet_index);

        $this->calculateLoadParams($company_id, $select_columns, $selected_row_ids);
    }

    public function calculateLoadParams($company_id, $select_columns, $selected_rows_ids) {
        $itemManager = ItemManager::getInstance();
        $importItemsTempManager = ImportItemsTempManager::getInstance();
        $importPriceManager = ImportPriceManager::getInstance();
        if (!isset($_REQUEST['aceptable_simillarity_percent'])) {
            $acepableItemSimillarityPercent = 50;
        } else {
            $acepableItemSimillarityPercent = intval($_REQUEST['aceptable_simillarity_percent']);
        }
        $this->addParam('acepableItemSimillarityPercent', $acepableItemSimillarityPercent);
        $this->addParam('acepableItemSimillarityPercentOptions', array('20', '25', '30', '35', '40', '45', '50', '55', '60', '65', '70', '75', '80', '85', '90'));
        $customerLogin = $this->getCustomerLogin();
        // $used_columns_indexes_array = explode(',', $_REQUEST['used_columns_indexes']);
        //$this->addParam('used_columns_indexes_array', implode(',', $used_columns_indexes_array));
        if (!(isset($_REQUEST['dont_recalculate']) && $_REQUEST['dont_recalculate'] == 1)) {

            $values = $importPriceManager->loadCompanyPriceFromCacheByRowIds($selected_rows_ids);
            $importItemsTempManager->deleteCustomerRows($customerLogin);
            
            $brand_model_name_concat_method = "bmn";
            $priceTranslationsManager = PriceTranslationsManager::getInstance();
            foreach ($values as $index => $row) {
                
                $nameColumn = "";
                foreach ($select_columns as $colName => $index) {
                    $modelColumn = '';
                    if ($index == 1) {
                        $modelColumn = $row[$colName];
                    }
                    if ($index == 2) {
                        $nameColumn .= $priceTranslationsManager->translateItemDisplayNameNonEnglishWordsToEnglish($row[$colName]) . ' ';
                        $nameColumn = preg_replace('/[^(\x20-\x7F)]*/', '', $nameColumn);
                    }
                    $dealerPriceColumn = '';
                    if ($index == 3) {
                        $dealerPriceColumn = $row[$colName];
                    }
                    $dealerPriceAmdColumn = '';
                    if ($index == 4) {
                        $dealerPriceAmdColumn = $row[$colName];
                    }
                    $vatPriceColumn = '';
                    if ($index == 5) {
                        $vatPriceColumn = $row[$colName];
                    }
                    $vatPriceAmdColumn = '';
                    if ($index == 6) {
                        $vatPriceAmdColumn = $row[$colName];
                    }
                    $warrantyMonthColumn = '';
                    if ($index == 7) {
                        $warrantyMonthColumn = $row[$colName];
                    }
                    $warrantyYearColumn = '';
                    if ($index == 8) {
                        $warrantyYearColumn = $row[$colName];
                    }
                    $brandColumn = '';
                    if ($index == 9) {
                        $brandColumn = $row[$colName];
                    }
                }
                if ($brand_model_name_concat_method === 'bmn') {
                    $nameColumn = $brandColumn . ' ' . $modelColumn . ' ' . $nameColumn;
                } elseif ($brand_model_name_concat_method === 'bn') {
                    $nameColumn = $brandColumn . ' ' . $nameColumn;
                } elseif ($brand_model_name_concat_method === 'mn') {
                    $nameColumn = $modelColumn . ' ' . $nameColumn;
                }
                $importItemsTempManager->addRow($customerLogin, $modelColumn, $nameColumn, $dealerPriceColumn, $dealerPriceAmdColumn, $vatPriceColumn, $vatPriceAmdColumn, $warrantyMonthColumn, $warrantyYearColumn, $brandColumn);
            }
        }
        $priceRowsDtos = $importItemsTempManager->getUserCurrentRows($customerLogin);
        $columnNames = $importPriceManager->getColumnNamesMap(array_values($select_columns));
        $this->addParam('columnNames', $columnNames);


        $companyAllItems = $itemManager->getCompanyItems($company_id, true);
        $convertDtosArrayToArrayMapById = $this->convertDtosArrayToArrayMapById($companyAllItems);
        $this->addParam('stockItemsDtosMappedByIds', $convertDtosArrayToArrayMapById);

        //$t = microtime(true);
        if (!(isset($_REQUEST['dont_recalculate']) && $_REQUEST['dont_recalculate'] == 1)) {
            $stockAndPriceItemsMatchingMap = $this->getStockAndPriceItemsMatchingMap($priceRowsDtos, $companyAllItems, $acepableItemSimillarityPercent);
            $cycleCount = 0;
            while ($this->getStockAndPriceItemsMatchingMap($priceRowsDtos, $companyAllItems, $acepableItemSimillarityPercent, true, $stockAndPriceItemsMatchingMap)) {
                $cycleCount++;
            }
            foreach ($stockAndPriceItemsMatchingMap as $stockItemId => $priceItemIdAndSimilarPercentPairArray) {
                $rowId = $priceItemIdAndSimilarPercentPairArray[0];
                $importItemsTempManager->setMatchedItemId($rowId, $stockItemId);
                $shortSpec = $convertDtosArrayToArrayMapById[$stockItemId]->getShortDescription();
                $fullSpec = $convertDtosArrayToArrayMapById[$stockItemId]->getFullDescription();
                $importItemsTempManager->updateTextField($rowId, 'short_spec', $shortSpec);
                $importItemsTempManager->updateTextField($rowId, 'full_spec', $fullSpec);
            }
        }
        $priceRowsDtos = $importItemsTempManager->getUserCurrentRows($customerLogin);


        //getting metched stock items ids
        $matchedStockItemIdsArray = array();
        foreach ($priceRowsDtos as $priceRowDto) {
            $matchedItemId = $priceRowDto->getMatchedItemId();
            if (intval($matchedItemId) > 0) {
                $matchedStockItemIdsArray [] = intval($matchedItemId);
            }
        }

        //getting company items which are not matched to any item in price table
        $unmatchedCompanyStockItems = array();
        foreach ($companyAllItems as $stockItemDto) {
            $itemId = intval($stockItemDto->getId());
            if (!in_array($itemId, $matchedStockItemIdsArray)) {
                $unmatchedCompanyStockItems [$itemId] = $stockItemDto;
            }
        }
        $this->addParam('unmatchedCompanyItems', $unmatchedCompanyStockItems);

        $this->addParam('priceRowsDtos', $priceRowsDtos);

        $this->addParam('matched_price_items_count', count($stockAndPriceItemsMatchingMap));
        $this->addParam('unmatched_price_items_count', count($priceRowsDtos) - count($stockAndPriceItemsMatchingMap));
    }

    private function convertDtosArrayToArrayMapById($dtos) {
        $ret = array();
        foreach ($dtos as $dto) {
            $ret[intval($dto->getId())] = $dto;
        }
        return $ret;
    }

    private function isPriceItemAlreadyMatechedToStockItem($priceItemId, $matchItemsIdsMap) {
        $ret = false;
        foreach ($matchItemsIdsMap as $stId => $pair) {
            if ($pair[0] == $priceItemId) {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    private function getStockAndPriceItemsMatchingMap($priceItemsDtos, $stockItemsDtos, $acepableItemSimillarityPercent, $checkDuplication = false, &$matchItemsIdsMap = null) {
        if (!isset($matchItemsIdsMap)) {
            $matchItemsIdsMap = array();
        }
        $atLeastOneMatched = false;
        foreach ($priceItemsDtos as $priceItemDto) {

            if ($checkDuplication && $this->isPriceItemAlreadyMatechedToStockItem($priceItemDto->getId(), $matchItemsIdsMap)) {
                //checks if item already matched then skip this item
                continue;
            }
            $maxSimilarItemPercent = 0;
            foreach ($stockItemsDtos as $stockItemDto) {
                if ($checkDuplication && array_key_exists($stockItemDto->getId(), $matchItemsIdsMap)) {
                    continue;
                }
                $similarItemsPercent = ImportPriceManager::getSimilarItemsPercent($stockItemDto, $priceItemDto);
                if ($similarItemsPercent > $maxSimilarItemPercent) {
                    $maxSimilarItemPercent = $similarItemsPercent;
                    $maxSimilarStockItemDto = $stockItemDto;
                }
            }

            if ($maxSimilarItemPercent > $acepableItemSimillarityPercent) {
                if (!array_key_exists($maxSimilarStockItemDto->getId(), $matchItemsIdsMap)) {
                    $atLeastOneMatched = true;
                    $matchItemsIdsMap[$maxSimilarStockItemDto->getId()] = array($priceItemDto->getId(), $maxSimilarItemPercent);
                } else {
                    if ($maxSimilarItemPercent > $matchItemsIdsMap[$maxSimilarStockItemDto->getId()][1]) {
                        $atLeastOneMatched = true;
                        $matchItemsIdsMap[$maxSimilarStockItemDto->getId()] = array($priceItemDto->getId(), $maxSimilarItemPercent);
                    }
                }
            }
        }
        if ($checkDuplication) {
            return $atLeastOneMatched;
        }
        return $matchItemsIdsMap;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import/step2.tpl";
    }

}

?>