<?php

require_once (CLASSES_PATH . "/actions/BaseAction.class.php");

/**
 * @author Vahagn Sookiasian
 */
abstract class BaseUserAction extends BaseAction {

    public function getRequestGroup() {
        return RequestGroups::$userRequest;
    }

}

?>