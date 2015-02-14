<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/SentSmsManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ConfirmCellPhoneNumberCodeAction extends GuestAction {

    public function service() {
        $confirm_code = $this->secure($_REQUEST['confirm_code']);
        $customer = $this->getCustomer();
        $lastSmsValidateCode = $customer->getLastSmsValidationCode();
        if ($confirm_code === $lastSmsValidateCode) {
            $this->ok();
        }
        $this->error(array("message" => $this->getPhrase(223)));
    }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}

?>