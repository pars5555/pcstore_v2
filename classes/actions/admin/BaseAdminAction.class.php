<?php

require_once (CLASSES_PATH . "/actions/BaseAction.class.php");

/**
 * @author Vahagn Sookiasian
 */
abstract class BaseAdminAction extends BaseAction {

    public function getRequestGroup() {
        return RequestGroups::$adminRequest;
    }

}

?>