<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class LandingpageLoad extends BaseGuestLoad {

    public function load() {       
        $this->addParam('req', isset($_SESSION['contact_us_req']) ? $_SESSION['contact_us_req'] : array());
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/landingpage.tpl";
    }

}

?>