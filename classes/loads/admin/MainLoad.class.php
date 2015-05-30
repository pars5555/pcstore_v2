<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class MainLoad extends BaseGuestLoad {

    public function load() {
        
    }

    public function getDefaultLoads($args) {
        $loads = array();
        $page = 'home';
        if (isset($_REQUEST['page'])) {
            $page = $this->secure($_REQUEST['page']);
        }
        $dir = '';
        if (isset($_REQUEST['dir'])) {
            $dir = $this->secure($_REQUEST['dir']);
        }
        $pagePartsArray = explode('_', $page);

        function _ucfirst(&$item, $key) {
            $item = ucfirst($item);
        }

        array_walk($pagePartsArray, '_ucfirst');
        $loadName = implode('', $pagePartsArray) . "Load";
        $this->addParam('contentLoad', 'admin_' . $page);
        $loads["content"]["load"] = "loads/admin/" . (isset($dir) ? $dir . "/" : "") . $loadName;
        $loads["content"]["args"] = array("mainLoad" => &$this);
        $loads["content"]["loads"] = array();
        return $loads;
    }

    protected function isMain() {
        return true;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/main.tpl";
    }

}

?>