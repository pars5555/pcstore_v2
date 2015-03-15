<?php

require_once (CLASSES_PATH . "/actions/BaseAction.class.php");

/**
 * @author Vahagn Sookiasian
 */
abstract class BaseServiceCompanyAction extends BaseAction {

    public function getRequestGroup() {
        return RequestGroups::$companyAndServiceCompanyRequest;
    }

}

?>