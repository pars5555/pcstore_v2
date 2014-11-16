<?php

require_once (CLASSES_PATH . "/managers/search/ItemSearchManager.class.php");

class ItemsCategoryMenuView {

    private $model;
    private $showRoot;
    private $config;

    function __construct(ItemCategoryModel $itemCategoryModel, $categories_count_array, $config, $showRoot = false) {
        $this->model = $itemCategoryModel;
        $this->config = $config;
        $this->showRoot = $showRoot;
        $this->categories_count_array = $categories_count_array;
       
    }

    public function display() {
        $ret = '<ul>';
        $rootNode = $this->model->getRootNode();
        if ($this->showRoot) {
            $ret .= $this->drawNodeTree($rootNode);
        } else {
            $nodeChildren = $this->model->getNodeChildren($rootNode);
            foreach ($nodeChildren as $chNode) {
                $ret .= $this->drawNodeTree($chNode);
            }
        }
        $ret .= '</ul>';
        echo $ret;
    }

    private function drawNodeTree(ItemCategoryNode $node) {
        $itemSearchManager = ItemSearchManager::getInstance();
        $url = HTTP_PROTOCOL . HTTP_HOST . '?' . $itemSearchManager->getUrlParams(array('cid' => $node->getId()));

        $categoryTotalItemsCount = array_key_exists($node->getId(), $this->categories_count_array) ? $this->categories_count_array[$node->getId()] : 0;
        if ($categoryTotalItemsCount ===0) return ;
        $ret = '<li><a href="' . $url . '">'.$node->getTitle().' <span class="cat_count">'.$categoryTotalItemsCount.'</span>' . '<div class="dropdown-toggle"></div></a>';

        $nodeChildren = $this->model->getNodeChildren($node);
        if (!empty($nodeChildren)) {
            $ret .= '<ul>';
            foreach ($nodeChildren as $childNode) {
                $ret .= $this->drawNodeTree($childNode);
            }
            $ret .= '</ul>';
        }
        $ret .= '</li>';
        return $ret;
    }

}

?>