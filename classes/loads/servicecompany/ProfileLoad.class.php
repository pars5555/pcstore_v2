<?php

require_once (CLASSES_PATH . "/loads/servicecompany/BaseServiceCompanyLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ProfileLoad extends BaseServiceCompanyLoad {

    public function load() {
        
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/servicecompany/profile.tpl";
    }

}

?>