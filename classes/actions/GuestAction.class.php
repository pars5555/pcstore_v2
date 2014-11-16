<?php

require_once (CLASSES_PATH . "/actions/BaseAction.class.php");

/**
 * General parent action for all AdminAction classes.
 *
 */
abstract class GuestAction extends BaseAction {

    public function __construct() {
        
    }

    public function onNoAccess() {
        $this->redirect('');
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

}

?>