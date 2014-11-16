<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/SentSmsManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class UpdateSmsSettingsAction extends BaseCompanyAction {

    public function service() {
        $companyManager = CompanyManager::getInstance();
        $phone = $this->secure($_REQUEST["phone"]);
        $workingDays = "";
        $workingDays .= isset($_REQUEST['monday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['tuseday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['wednesday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['thursday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['friday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['saturday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['sunday_checkbox']) ? '1' : '0';
        $smsFromTime = "09:00";
        $smsToDuration = 0;
        if (isset($_REQUEST['sms_time_control'])) {
            $smsFromTime = $this->secure($_REQUEST['sms_from_time']);
            $smsToDuration = $this->secure($_REQUEST['sms_to_duration_minutes']);
        }
        $validPhoneNumber = SentSmsManager::getValidArmenianNumber($phone);
        if (!isset($validPhoneNumber)) {
            $_SESSION['error_message'] = 'Invalid Armenian mobile number!';
            $this->redirect('smsconf');
        }

        $companyManager->updateSmsConfiguration($this->getUserId(), $phone, $workingDays, $smsFromTime, $smsToDuration);
        $_SESSION['success_message'] = $this->getPhrase(655);
        $this->redirect('smsconf');
    }

}

?>