<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/ImportItemsTempManager.class.php");
require_once (CLASSES_PATH . "/managers/ImportPriceManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ImportStep4Load extends BaseAdminLoad {

    public function load() {
        $company_id = $_REQUEST['company_id'];
        $companyManager = CompanyManager::getInstance();
        $companyDto = $companyManager->selectByPK($company_id);
        $this->addParam('companyDto', $companyDto);
        $used_columns_indexes_array = array(2/* name */, 1/* model */, 9/* brand */, 3/* dealer price $ */, 4/* $dealer price amd */, 5/* vat $ */, 6/* vat amd */, 7/* warranty */); //explode(',', $_REQUEST['used_columns_indexes']);
        $importItemsTempManager = ImportItemsTempManager::getInstance();
        $categoryHierarchyManager = CategoryHierarchyManager::getInstance();
        $categoryManager = CategoryManager::getInstance();

        $customerLogin = $this->getCustomerLogin();
        $priceRowsDtos = $importItemsTempManager->getUserCurrentPriceChangedRows($customerLogin);
        $columnNames = ImportPriceManager::getColumnNamesMap($used_columns_indexes_array);

        $rootDto = $categoryManager->getRoot();
        $firstLevelCategoriesHierarchyDtos = $categoryHierarchyManager->getCategoryChildren($rootDto->getId());
        $firstLevelCategoriesNamesDtos = $categoryHierarchyManager->getCategoriesNamesByParentCategoryId($rootDto->getId());

        $firstLevelCategoriesIds = array();
        foreach ($firstLevelCategoriesHierarchyDtos as $key => $category) {
            $firstLevelCategoriesIds[] = $category->getChildId();
        }
        $firstLevelCategoriesNames = array();
        foreach ($firstLevelCategoriesNamesDtos as $key => $category) {
            $firstLevelCategoriesNames[] = $category->getDisplayName();
        }

        $itemManager = ItemManager::getInstance();
        $companyAllItems = $itemManager->getCompanyItems($company_id, true);
        $convertDtosArrayToArrayMapById = $this->convertDtosArrayToArrayMapById($companyAllItems);
        $this->addParam('stockItemsDtosMappedByIds', $convertDtosArrayToArrayMapById);

        $this->addParam('columnNames', $columnNames);
        $this->addParam('priceRowsDtos', $priceRowsDtos);
        $this->addParam('firstLevelCategoriesNames', $firstLevelCategoriesNames);
        $this->addParam('firstLevelCategoriesIds', $firstLevelCategoriesIds);
        list($changedRowIds, $changedFields) = $this->findChanges($priceRowsDtos, $convertDtosArrayToArrayMapById, $columnNames);
        $this->addParam('changedRowsIds', $changedRowIds);
        $this->addParam('changedFields', $changedFields);
    }

    private function findChanges($priceRowsDtos, $stockItemsDtosMappedByIds, $columnNames) {
        $changedRowsIds = array();
        $changedFields = array();

        foreach ($priceRowsDtos as $priceRowDto) {
            $correspondingStockItemId = $priceRowDto->getMatchedItemId();
            if ($correspondingStockItemId > 0) {
                $correspondingStockItemDto = $stockItemsDtosMappedByIds[$correspondingStockItemId];
                $rowChanged = false;
                foreach ($columnNames as $dtoFieldName => $columnTitle) {
                    if ($dtoFieldName == "warrantyMonths") {
                        $fieldName = "warranty";
                    } else {
                        $fieldName = $dtoFieldName;
                    }
                    if ( ((!empty($correspondingStockItemDto->$fieldName)) && !empty($priceRowDto->$fieldName))  &&
                            (strtolower(preg_replace('#\s+#', "", $correspondingStockItemDto->$fieldName)) != strtolower(preg_replace('#\s+#', "", $priceRowDto->$fieldName)))) {
                        $rowChanged = true;
                        $changedFields[$priceRowDto->getId()][$fieldName] = 1;
                    } else {
                        $changedFields[$priceRowDto->getId()][$fieldName] = 0;
                    }
                    if ($rowChanged) {
                        $changedRowsIds[] = $priceRowDto->getId();
                    }
                }
            }
        }
        return array($changedRowsIds, $changedFields);
    }

    private function convertDtosArrayToArrayMapById($dtos) {
        $ret = array();
        foreach ($dtos as $dto) {
            $ret[intval($dto->getId())] = $dto;
        }
        return $ret;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import/step4.tpl";
    }

}

?>