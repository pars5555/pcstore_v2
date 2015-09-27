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
class ImportStep3Load extends BaseAdminLoad {

    public function load() {
        //new items import level
        $importItemsTempManager = ImportItemsTempManager::getInstance();
        $categoryHierarchyManager = CategoryHierarchyManager::getInstance();
        $categoryManager = CategoryManager::getInstance();
        $companyManager = CompanyManager::getInstance();
        $company_id = $_REQUEST['company_id'];
        $companyDto = $companyManager->selectByPK($company_id);
        $this->addParam('companyDto', $companyDto);
        $used_columns_indexes_array = array(2/* name */, 1/* model */, 9/* brand */, 3/* dealer price $ */, 4/* $dealer price amd */, 5/* vat $ */, 6/* vat amd */, 7/* warranty */); //explode(',', $_REQUEST['used_columns_indexes']);

        $customerLogin = $this->getCustomerLogin();
        $priceRowsDtos = $importItemsTempManager->getUserCurrentPriceNewRows($customerLogin);
        foreach ($priceRowsDtos as $dto) {
            $itemModel = $dto->getModel();
            if (empty($itemModel)) {
                $model = $importItemsTempManager->findModelFromItemTitle($dto->getDisplayName());
                if (!empty($model)) {
                    $dto->setSupposedModel($model);
                }
            } else {
                $dto->setSupposedModel($itemModel);
            }
        }


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

        $this->addParam('columnNames', $columnNames);
        $this->addParam('priceRowsDtos', $priceRowsDtos);
        $this->addParam('firstLevelCategoriesNames', $firstLevelCategoriesNames);
        $this->addParam('firstLevelCategoriesIds', $firstLevelCategoriesIds);

        if (isset($_REQUEST['new_items_row_ids'])) {
            $this->addParam('new_items_row_ids', explode(',', $_REQUEST['new_items_row_ids']));
        }
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/import/step3.tpl";
    }

}

?>