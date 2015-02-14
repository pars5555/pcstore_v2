<?php

require_once (CLASSES_PATH . "/managers/search/ItemSearchManager.class.php");

class CategoryPropertyView {

    private $selectedCategoriesId;
    private $groupCategoryId;
    private $categoryManager;
    private $categoryHierarchyManager;

    function __construct($categoryManager, $categoryHierarchyManager, $categories_count_array, $groupCategoryId, $selectedCategoriesId) {
        $this->selectedCategoriesId = $selectedCategoriesId;
        $this->groupCategoryId = $groupCategoryId;
        $this->categoryHierarchyManager = $categoryHierarchyManager;
        $this->categoryManager = $categoryManager;
        $this->categories_count_array = $categories_count_array;
    }

    function display() {
        $itemSearchManager = ItemSearchManager::getInstance();
        echo '<div class="product_title">' . $this->categoryManager->getCategoryById($this->groupCategoryId)->getDisplayName() . '</div>';
        $childrenHierarchyDtos = $this->categoryHierarchyManager->getCategoryChildren($this->groupCategoryId);
        foreach ($childrenHierarchyDtos as $key => $childrenHierarchyDto) {
            $categoryTotalItemsCount = array_key_exists($childrenHierarchyDto->getChildId(), $this->categories_count_array) ? $this->categories_count_array[$childrenHierarchyDto->getChildId()] : 0;
            $checked = isset($this->selectedCategoriesId) && in_array($childrenHierarchyDto->getChildId(), $this->selectedCategoriesId);
            $propertiesIds = $this->selectedCategoriesId;
            if ($categoryTotalItemsCount === 0 && !$checked) {
                continue;
            }
            echo '<div class="product_checkbox">';

            if ($checked) {
                $key = array_search($childrenHierarchyDto->getChildId(), $propertiesIds);
                unset($propertiesIds[$key]);
            } else {
                $propertiesIds[] = $childrenHierarchyDto->getChildId();
            }
            $url = HTTP_PROTOCOL . HTTP_HOST . '?' . $itemSearchManager->getUrlParams(array('scpids' => implode(',', $propertiesIds)));
            $propertyCountTextToBeAppend = $checked ? '' : ' (' . $categoryTotalItemsCount . ')';
            $displayName = $this->categoryManager->getCategoryById($childrenHierarchyDto->getChildId())->getDisplayName();
            echo '<a href="' . $url . '">';
            echo '<input category_id="' . $childrenHierarchyDto->getChildId() . '" id = "category_property_' . $childrenHierarchyDto->getChildId() . '" class="category_property" type="checkbox" ' . ($checked ? 'checked' : '') . '/>';
            echo  '<span>'. $displayName . $propertyCountTextToBeAppend . '</span>';
            echo '</a>';
            echo '</div>';
        }
    }

}

?>