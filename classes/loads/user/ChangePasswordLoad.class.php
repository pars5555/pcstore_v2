<?php

require_once (CLASSES_PATH . "/loads/user/BaseUserLoad.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ChangePasswordLoad extends BaseUserLoad {

    public function load() {
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/user/change_password.tpl";
    }

}

?>