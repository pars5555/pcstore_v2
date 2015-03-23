<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");

class MainLoad extends BaseGuestLoad {

    public function load() {
        $this->addParam('req', $_REQUEST);
        $this->checkInvitation();
    }

    public function getDefaultLoads($args) {
        $loads = array();
        $page = 'home';
        if (isset($_REQUEST['page'])) {
            $page = $this->secure($_REQUEST['page']);
        }
        $dir = 'main';
        if (isset($_REQUEST['dir'])) {
            $dir = $this->secure($_REQUEST['dir']);
        }
        $pagePartsArray = explode('_', $page);

        function _ucfirst(&$item, $key) {
            $item = ucfirst($item);
        }

        array_walk($pagePartsArray, '_ucfirst');
        $loadName = implode('', $pagePartsArray) . "Load";
        $this->addParam('contentLoad', $dir . '_' . $page);
        $loads["content"]["load"] = "loads/" . $dir . "/" . $loadName;
        $loads["content"]["args"] = array("mainLoad" => &$this);
        $loads["content"]["loads"] = array();
        return $loads;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/main.tpl";
    }

    public function isMain() {
        return true;
    }

    private function checkInvitation() {
        if ($this->getUserLevel() === UserGroups::$GUEST && !isset($_SESSION['invc'])) {
            if (isset($_GET["invc"])) {
                $_SESSION['invc'] = $this->secure($_GET["invc"]);
                $this->redirect('signup');
            }
        }
    }

    protected function logRequest() {
        return false;
    }

}

?>
