<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class SignupLoad extends BaseGuestLoad {

    public function load() {
        if ($this->getUserLevel() !== UserGroups::$GUEST)
        {
            $this->redirect();
        }
        $this->addParam('req', isset($_SESSION['signup_req']) ? $_SESSION['signup_req'] : array());
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/signup.tpl";
    }

}

?>