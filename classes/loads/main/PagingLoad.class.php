<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/search/ItemSearchManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PagingLoad extends BaseGuestLoad {

    public function load() {
        $current_page_number = 1;
        if (isset($this->args["current_page_number"])) {
            $current_page_number = $this->args["current_page_number"];
        }
        $total_items_count = 0;
        if (isset($this->args["total_items_count"])) {
            $total_items_count = $this->args["total_items_count"];
        }
        $item_search_limit_rows = $this->getCmsVar("item_search_limit_rows");
        $item_search_max_showing_pages_count = $this->getCmsVar('item_search_max_showing_pages_count');
        $this->initPaging($current_page_number, $total_items_count, $item_search_limit_rows, $item_search_max_showing_pages_count);
        $itemSearchManager = ItemSearchManager::getInstance();
        $this->addParam('itemSearchManager', $itemSearchManager);
    }

    public function initPaging($page, $itemsCount, $limit, $pagesShowed) {
        //	  1 ,       301 ,     20,       20

        $pageCount = ceil($itemsCount / $limit);

        $centredPage = ceil($pagesShowed / 2);
        $pStart = 0;
        if (($page - $centredPage) > 0) {
            $pStart = $page - $centredPage;
        }
        if (($page + $centredPage) >= $pageCount) {
            $pEnd = $pageCount;
            if (($pStart - ($page + $centredPage - $pageCount)) > 0) {
                $pStart = $pStart - ($page + $centredPage - $pageCount);
            }
        } else {
            $pEnd = $pStart + $pagesShowed;
            if ($pageCount < $pagesShowed) {
                $pEnd = $pageCount;
            }
        }

        $this->addParam("pageCount", $pageCount);
        $this->addParam("page", $page);
        $this->addParam("pStart", $pStart);
        $this->addParam("pEnd", $pEnd);

        return true;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/paging.tpl";
    }

    protected function logRequest() {
        return false;
    }

}

?>