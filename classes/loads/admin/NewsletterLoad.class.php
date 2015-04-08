<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class newsletterLoad extends BaseAdminLoad {

    public function load() {
        $this->initErrorMessages();
        $this->initSucessMessages();
      
    }


    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/newsletter.tpl";
    }

}

?>