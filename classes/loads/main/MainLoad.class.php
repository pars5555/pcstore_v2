<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/UserSubUsersManager.class.php");

class MainLoad extends BaseGuestLoad {

    public function load() {
        $this->addParam('req', $_REQUEST);
        $this->addParam('server_ip_address', SERVER_IP_ADDRESS);
        $this->checkInvitation();
        $this->initLanguage();
        $this->checkUserActivation();
        $this->getSignupActivationMessage();
    }

    public function checkUserActivation() {
        if (isset($_REQUEST["activation_code"])) {
            $user_activation_code = $this->secure($_REQUEST["activation_code"]);
            $userManager = UserManager::getInstance();
            $inactiveUser = $userManager->getUserByActivationCode($user_activation_code);
            if ($inactiveUser) {
                if ($inactiveUser->getActive() == 1) {
                    $this->addParam('user_activation', 'already_activated');
                } else {
                    $inactiveUser->setActive(1);
                    $userManager->updateByPK($inactiveUser);
                    $userSubUsersManager = UserSubUsersManager::getInstance();
                    $prentId = $userSubUsersManager->getUserParentId($inactiveUser->getId());
                    if ($prentId > 0) {
                        $invbonus = intval($this->getCmsVar("bonus_points_for_every_accepted_invitation"));
                        $userManager->addUserPoints($prentId, $invbonus, $invbonus . " bonus for invitation accept from user number: " . $inactiveUser->getId());
                    }
                    $this->addParam('user_activation', 'activated');
                }
            }
        }
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

    public function initLanguage() {
        $language = "en";
        if (isset($_COOKIE["ul"])) {
            $language = $_COOKIE["ul"];
        }
        $this->addParam("language", $language);
    }

    public function getSignupActivationMessage() {
        if (isset($_SESSION["signup_message"])) {
            $this->addParam("signup_message", 1);
            unset($_SESSION["signup_message"]);
        }
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
