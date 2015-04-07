<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class MainLoad extends BaseGuestLoad {

    public function load() {
        $this->checkUserActivation();
    }

    public function getDefaultLoads($args) {
        $loads = array();
        $page = 'home';
        if (isset($_REQUEST['page'])) {
            $page = $this->secure($_REQUEST['page']);
        }

        $pagePartsArray = explode('_', $page);

        function _ucfirst(&$item, $key) {
            $item = ucfirst($item);
        }

        array_walk($pagePartsArray, '_ucfirst');
        $loadName = implode('', $pagePartsArray) . "Load";
        $this->addParam('contentLoad', 'admin_' . $page);
        $loads["content"]["load"] = "loads/admin/" . $loadName;
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

}

?>