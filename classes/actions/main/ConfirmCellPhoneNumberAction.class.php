<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/SentSmsManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ConfirmCellPhoneNumberAction extends GuestAction {

    public function service() {
        $phone_number = $_REQUEST['cell_phone_num'];
        $sentSmsManager = SentSmsManager::getInstance();
        $phone_number = SentSmsManager::getValidArmenianNumber($phone_number);
        $customer = $this->getCustomer();
        if ($phone_number == null) {
            $this->error(array("message" => "Invalid cell phone number!"));
        }
        $lastSmsValidationCode = substr(uniqid(rand(), true), 0, 6);
        if ($this->getUserLevel() == UserGroups::$USER) {
            $userManager = UserManager::getInstance();
            $userManager->setLastSmsValidationCode($customer->getId(), $lastSmsValidationCode);
        } elseif ($this->getUserLevel() == UserGroups::$COMPANY) {
            $companyManager = CompanyManager::getInstance();
            $companyManager->setLastSmsValidationCode($customer->getId(), $lastSmsValidationCode);
        }
        $sentSmsManager->sendSmsToArmenia($phone_number, $lastSmsValidationCode);
        $this->ok();
    }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}

?>