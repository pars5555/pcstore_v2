<?php

require_once (CLASSES_PATH . "/actions/BaseAction.class.php");

/**
 * @author Vahagn Sookiasian
 */
abstract class BaseCompanyAction extends BaseAction {

    public function getRequestGroup() {
        return RequestGroups::$companyAndServiceCompanyRequest;
    }

}

?>