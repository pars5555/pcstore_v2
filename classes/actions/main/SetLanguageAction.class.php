<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SetLanguageAction extends GuestAction {

    public function service() {
        $lc = $_REQUEST['lang'];
        if ($lc === 'am' || $lc === 'en' || $lc === 'ru') {
            $this->setcookie('ul', $lc);
            $_COOKIE['ul'] = $lc;
            if ($this->getUserLevel() == UserGroups::$USER) {
                $userManager = UserManager::getInstance();
                $userManager->setLanguageCode($this->getUserId(), $lc);
            } elseif ($this->getUserLevel() == UserGroups::$COMPANY) {
                $companyManager = CompanyManager::getInstance();
                $companyManager->setLanguageCode($this->getUserId(), $lc);
            }
        }
        $this->ok();
    }

}

?>