<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryManager.class.php");
require_once (CLASSES_PATH . "/managers/CmsSearchRequestsManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CreditManager.class.php");
require_once (CLASSES_PATH . "/managers/CreditSuppliersManager.class.php");
require_once (CLASSES_PATH . "/util/categories_view/FilterItemsTreeView.php");
require_once (CLASSES_PATH . "/util/categories_view/FilterItemsTreeViewModel.php");
require_once (CLASSES_PATH . "/util/categories_view/ItemCategoryModel.php");
require_once (CLASSES_PATH . "/util/categories_view/ItemsCategoryMenuView.php");
require_once (CLASSES_PATH . "/util/categories_view/CategoryPropertyView.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class HomeLoad extends BaseGuestLoad {

    private $totalItemsRowsCount = 0;
    private $pageNumber = 1;

    public function load() {
        $this->addParam('req', $_REQUEST);

        //init managers
        $itemManager = ItemManager::getInstance();
        $categoryManager = CategoryManager::getInstance();
        $categoryHierarchyManager = CategoryHierarchyManager::getInstance();



        $this->pageNumber = 1;
        if (isset($_REQUEST["pg"])) {
            $this->pageNumber = $this->secure($_REQUEST["pg"]);
        }
        $userLevel = $this->getUserLevel();
        $selectedCompanyId = $this->initCompaniesSelectionList();

        $selectedCategoryId = 0;
        if (!empty($_REQUEST["cid"])) {
            $selectedCategoryId = $this->secure($_REQUEST["cid"]);
        }
        $selected_category_property_ids = null;
        if (isset($_REQUEST["scpids"])) {
            $selected_category_property_ids = $this->secure($_REQUEST["scpids"]);
        }
        $groupedProperties = null;
        if (!empty($selected_category_property_ids)) {
            $this->addParam('selected_category_property_ids', $selected_category_property_ids);
            $selected_category_property_ids = explode(',', $selected_category_property_ids);
            $groupedProperties = $this->groupCategoryProperties($selected_category_property_ids);
        } else {
            $selected_category_property_ids = array();
            $groupedProperties = array();
        }
        $item_search_limit_rows = intval($this->getCmsVar("item_search_limit_rows"));
        $userId = $this->getUserId();
        $price_range_min = '';
        if (isset($_REQUEST["mip"])) {
            $price_range_min = $this->secure($_REQUEST["mip"]);
        }
        $price_range_max = '';
        if (isset($_REQUEST["map"])) {
            $price_range_max = $this->secure($_REQUEST["map"]);
        }

        if (!empty($price_range_min) && strlen($price_range_min) > 0) {
            $price_range_min = floatval($this->secure($_REQUEST["mip"])) / floatval($this->getCmsVar('us_dollar_exchange'));
        }
        if (!empty($price_range_max) && strlen($price_range_max) > 0) {
            $price_range_max = floatval($this->secure($_REQUEST["map"])) / floatval($this->getCmsVar('us_dollar_exchange'));
        }
        $orderByFieldName = $this->initSortBySelectionList();
        switch ($orderByFieldName) {
            case 'htl':
                $orderByFieldName = 'customer_item_price';
                $sortPosition = 'DESC';
                break;
            case 'lth':
                $orderByFieldName = 'customer_item_price';
                $sortPosition = 'ASC';
                break;
            case 'rel':
                $orderByFieldName = null;
                $sortPosition = 'ASC';
                break;
        }

        $search_text = isset($_REQUEST["st"]) ? $this->secure($_REQUEST["st"]) : '';
        $this->addParam("search_text", $search_text);

        $show_only_vat_items = 0;
        if (isset($_REQUEST['shv'])) {
            $show_only_vat_items = $this->secure($_REQUEST['shv']);
            $this->addParam('show_only_vat_items', 1);
        }



        searchStared:
        $offset = $item_search_limit_rows * ($this->pageNumber - 1);
        $foundItems = $itemManager->searchItemsByTitle($userId, $userLevel, $search_text, $selectedCompanyId, $price_range_min, $price_range_max, $selectedCategoryId, $groupedProperties, $show_only_vat_items, $offset, $item_search_limit_rows, $orderByFieldName, $sortPosition);
        $itemsDtosOnlyCategories = $itemManager->searchItemsByTitleRowsCount($userId, $search_text, $selectedCompanyId, $price_range_min, $price_range_max, $selectedCategoryId, null, $show_only_vat_items);

        $this->totalItemsRowsCount = 0;
        $this->categories_count_array = array();
        $selectedCategoryGroupedSubProperties = array();
        $selectedCategorySubTreeIds = array();
        $propertyViewIsVisible = false;
        $selectedCategoryDto = $categoryManager->getCategoryById($selectedCategoryId);
        if ($selectedCategoryDto->getLastClickable() == 1) {
            $selectedCategoryGroupedSubProperties = $categoryHierarchyManager->getCategoryGroupedSubProperties($selectedCategoryId);
            $selectedCategorySubTreeIds = $categoryHierarchyManager->getCategorySubTreeIds($selectedCategoryId);
            $propertyViewIsVisible = true;
        }
        foreach ($itemsDtosOnlyCategories as $itemDto) {
            $categoriesIds = trim($itemDto->getCategoriesIds(), ',');
            $categoriesIdsArray = explode(',', $categoriesIds);
            $ItemIsVisible = true;
            foreach ($groupedProperties as $propertiesGroupStaticCategoryId => $propIdsArray) {
                if (!(empty($propIdsArray) || count(array_intersect($categoriesIdsArray, $propIdsArray)) > 0)) {
                    $ItemIsVisible = false;
                    break;
                }
            }

            if ($ItemIsVisible) {
                $this->totalItemsRowsCount++;
            }

            //here calculating categories count which is valid for only category menu items not properties
            if (!$propertyViewIsVisible) {
                foreach ($categoriesIdsArray as $catId) {
                    if (!in_array($catId, $selectedCategorySubTreeIds)) {
                        if (!array_key_exists($catId, $this->categories_count_array)) {
                            $this->categories_count_array[$catId] = 1;
                        } else {
                            $this->categories_count_array[$catId] +=1;
                        }
                    }
                }
            } else {

                //here calculating future selecting properties count
                foreach ($selectedCategoryGroupedSubProperties as $propertyGroupCategoryId => $propertiesIds) {
                    $isItemVisibleForCurrentlySelectedOtherPropertyGroup = true;
                    foreach ($groupedProperties as $propertiesGroupStaticCategoryId => $propIdsArray) {
                        if ($propertiesGroupStaticCategoryId == $propertyGroupCategoryId) {
                            continue;
                        }
                        if (!(empty($propIdsArray) || count(array_intersect($categoriesIdsArray, $propIdsArray)) > 0)) {
                            $isItemVisibleForCurrentlySelectedOtherPropertyGroup = false;
                            break;
                        }
                    }



                    foreach ($propertiesIds as $proertyId) {
                        if (in_array($proertyId, $selected_category_property_ids)) {
                            //this is for optimization
                            continue;
                        }
                        if ($isItemVisibleForCurrentlySelectedOtherPropertyGroup && in_array($proertyId, $categoriesIdsArray)) {
                            if (!array_key_exists($proertyId, $this->categories_count_array)) {
                                $this->categories_count_array[$proertyId] = 1;
                            } else {
                                $this->categories_count_array[$proertyId] +=1;
                            }
                        }
                    }
                }
            }
        }

        //if page number exceed last page number then go to last page
        if (count($foundItems) === 0 && $this->totalItemsRowsCount > 0) {
            $lastPageNumber = ceil($this->totalItemsRowsCount / $item_search_limit_rows);
            $this->pageNumber = $lastPageNumber;
            goto searchStared;
        }

        $this->addParam("foundItems", $foundItems);
        $this->addParam("itemManager", $itemManager);
        $this->addParam("totalItemsRowsCount", $this->totalItemsRowsCount);



        //categories 
        if ($selectedCategoryDto->getLastClickable() == '0') {
            $itemCategoryModel = new ItemCategoryModel(!empty($selectedCategoryId) ? $selectedCategoryId : 0);
            $itemsCategoryMenuView = new ItemsCategoryMenuView($itemCategoryModel, $this->categories_count_array, false);
            $this->addParam('itemsCategoryMenuView', $itemsCategoryMenuView);
        }

        //selected category properties
        $propertiesViews = array();
        if (isset($selectedCategoryId) && $categoryManager->getCategoryById($selectedCategoryId)->getLastClickable() == '1') {
            $propertiesHierarchyDtos = $categoryHierarchyManager->getCategoryChildren($selectedCategoryId);
            foreach ($propertiesHierarchyDtos as $propertyHierarchyDto) {
                $propertyView = new CategoryPropertyView($categoryManager, $categoryHierarchyManager, $this->categories_count_array, $propertyHierarchyDto->getChildId(), $selected_category_property_ids);
                $propertiesViews[] = $propertyView;
            }
        }
        $this->addParam("properties_views", $propertiesViews);
        $this->addParam('category_id', $selectedCategoryId);
        $this->addParam('category_dto', $selectedCategoryDto);
        if ($selectedCategoryId > 0) {
            $categoryFullPath = $categoryManager->getCategoryFullPath($selectedCategoryId);
            if (count($categoryFullPath) >= 1) {
                $this->addParam('category_path', $categoryFullPath);
            }
        }
        $this->addParam('itemSearchManager', ItemSearchManager::getInstance());

        //var_dump(microtime(true)-$mt);exit;
    }

    private function putCategoriesHierarchiesInMapChildParent($allCategoriesHierarchies) {
        $ret = array();
        foreach ($allCategoriesHierarchies as $key => $dto) {
            $ret[$dto->getChildId()] = $dto->getCategoryId();
        }
        return $ret;
    }

    private function groupCategoryProperties($selected_category_property_ids) {
        $ret = array();
        $categoryHierarchyManager = CategoryHierarchyManager::getInstance();
        $allCategoryHierarchiesDtos = $categoryHierarchyManager->selectAll();
        $mappedChildParentCategories = $this->putCategoriesHierarchiesInMapChildParent($allCategoryHierarchiesDtos);
        foreach ($selected_category_property_ids as $key => $value) {
            $propParentCatId = $mappedChildParentCategories[$value];
            $ret[$propParentCatId][] = $value;
        }
        return $ret;
    }

    private function initSortBySelectionList() {

        $sort_by_values = array('rel', 'lth', 'htl');
        $sort_by_display_names = array($this->getPhrase(155), $this->getPhrase(649), $this->getPhrase(650));
        $selected_sort_by_value = $sort_by_values[0];
        if (isset($_REQUEST["s"]) && !empty($_REQUEST["s"])) {
            $selected_sort_by_value = $this->secure($_REQUEST["s"]);
        }
        $this->addParam("sort_by_values", $sort_by_values);
        $this->addParam("sort_by_display_names", $sort_by_display_names);
        $this->addParam("selected_sort_by_value", $selected_sort_by_value);
        return $selected_sort_by_value;
    }

    public function initCompaniesSelectionList() {

        $userLevel = $this->getUserLevel();

        $companyManager = CompanyManager::getInstance();
        $companiesNames = array();
        $companiesIds = array();
        if ($userLevel === UserGroups::$COMPANY || $userLevel === UserGroups::$SERVICE_COMPANY || $userLevel === UserGroups::$ADMIN) {
            $allCompanies = $companyManager->getAllCompanies($userLevel === UserGroups::$ADMIN || false, $userLevel === UserGroups::$ADMIN);
            $companiesIds = $companyManager->getCompaniesIdsArray($allCompanies);
            $companiesNames = $companyManager->getCompaniesNamesArray($allCompanies);
        } elseif ($userLevel === UserGroups::$USER) {
            $userId = $this->getUserId();
            $companiesDtos = $companyManager->getUserCompanies($userId, false);
            $companiesIds = $companyManager->getCompaniesIdsArray($companiesDtos);
            $companiesNames = $companyManager->getCompaniesNamesArray($companiesDtos);
        }
        $selectedCompanyId = 0;
        array_splice($companiesIds, 0, 0, 0);
        array_splice($companiesNames, 0, 0, $this->getPhrase(153));
        $this->addParam("companiesIds", $companiesIds);
        $this->addParam("companiesNames", $companiesNames);
        if (isset($_REQUEST["sci"])) {
            $selectedCompanyId = $this->secure($_REQUEST["sci"]);
        }
        $this->addParam("selectedCompanyId", $selectedCompanyId);
        return $selectedCompanyId;
    }

    public function getDefaultLoads($args) {
        $loads = array();
        $loadName = "PagingLoad";
        $loads["paging"]["load"] = "loads/main/" . $loadName;
        $loads["paging"]["args"] = array("mainLoad" => &$this, "current_page_number" => $this->pageNumber, "total_items_count" => $this->totalItemsRowsCount);
        $loads["paging"]["loads"] = array();
        return $loads;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/home.tpl";
    }

}

?>