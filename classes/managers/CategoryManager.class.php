<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/managers/CategoryHierarchyManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CategoryMapper.class.php");

/**
 * CategoryManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CategoryManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;
    private $allDtosCache;

    /**
     * Initializes DB mappers
     *
     * @param object $config
     * @param object $args
     * @return
     */
    function __construct() {
        $this->mapper = CategoryMapper::getInstance();
        $this->categoryHierarchyManager = CategoryHierarchyManager::getInstance();
        $this->initCache();
    }

    private function initCache() {
        $allDtosCache = $this->mapper->selectAll();
        foreach ($allDtosCache as $dto) {
            $this->allDtosCache[intval($dto->getId())] = $dto;
        }
    }

    /**
     * Returns an singleton instance of this class
     *
     * @param object $config
     * @param object $args
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CategoryManager();
        }
        return self::$instance;
    }

    public function getRoot() {
        return $this->getCategoryById('0');
    }

    public function getCategoryById($id) {
        return $this->allDtosCache[intval($id)];
    }

    public function getCategoryFullPath($id) {
        $ret = array();
        $categoryParentId = $this->categoryHierarchyManager->getCategoryParentId($id);
        while ($categoryParentId > 0) {
            $ret [] = $this->allDtosCache[intval($categoryParentId)];
            $id = $categoryParentId;
            $categoryParentId = $this->categoryHierarchyManager->getCategoryParentId($id);
        }
        return array_reverse($ret);
    }

    public function getChildren($id) {
        $categoryChildrenIdsArray = $this->categoryHierarchyManager->getCategoryChildrenIdsArray($id);
        $ret = array();
        foreach ($categoryChildrenIdsArray as $childId) {
            $ret[] = $this->allDtosCache[intval($childId)];
        }
        return $ret;
    }

    public function deleteByPK($id) {
        unset($this->allDtosCache[intval($id)]);
        return $this->mapper->deleteByPK($id);
    }

    /**
     * Returns inserted category id
     */
    public function addCategory($categoryTitle, $categoryIsLastClickable, $categoryIsStatic) {
        $categoryDto = $this->mapper->createDto();
        $categoryDto->setDisplayName($categoryTitle);
        $categoryDto->setLastClickable($categoryIsLastClickable);
        $categoryDto->setIsStatic($categoryIsStatic);
        $ret = $this->mapper->insertDto($categoryDto);
        $this->allDtosCache[intval($ret)] = $categoryDto;
        return $ret;
    }

    public function updateCategoryAttributes($id, $display_name, $last_clickable) {
        $categoryDto = $this->mapper->selectByPK($id);
        $categoryDto->setDisplayName($display_name);
        $categoryDto->setLastClickable($last_clickable);
        $ret = $this->mapper->updateByPK($categoryDto);
        $this->allDtosCache[intval($id)] = $categoryDto;
        return $ret;
    }

    public function getCategoriesByIds($cat_ids, $order_by_ids = false) {
        return $this->mapper->getCategoriesByIds($cat_ids, $order_by_ids);
    }

    public function getLastClickableCategoryFromCatIds($cat_ids_array) {
        return $this->mapper->getLastClickableCategoryFromCatIds($cat_ids_array);
    }

}

?>