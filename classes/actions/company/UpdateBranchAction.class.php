<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class UpdateBranchAction extends BaseCompanyAction {

    public function service() {
        $companyBranchesManager = new CompanyBranchesManager();
        $branchId = $this->secure($_REQUEST["branch_id"]);
        $phone1 = $this->secure($_REQUEST["phone1"]);
        $phone2 = $this->secure($_REQUEST["phone2"]);
        $phone3 = $this->secure($_REQUEST["phone3"]);
        $phones = array();
        if (!empty($phone1)) {
            $phones [] = $phone1;
        }
        if (!empty($phone2)) {
            $phones [] = $phone2;
        }
        if (!empty($phone3)) {
            $phones [] = $phone3;
        }

        $address = $this->secure($_REQUEST["address"]);
        $region = $this->secure($_REQUEST["region"]);
        $lng = $this->secure($_REQUEST["lng"]);
        $lat = $this->secure($_REQUEST["lat"]);
        $zip = $this->secure($_REQUEST["zip"]);
        $startWorkingHour = $this->secure($_REQUEST["startWorkingHour"]);
        $startWorkingMinute = $this->secure($_REQUEST["startWorkingMinute"]);
        $endWorkingHour = $this->secure($_REQUEST["endWorkingHour"]);
        $endWorkingMinute = $this->secure($_REQUEST["endWorkingMinute"]);
        $workingHours = $startWorkingHour . ':' . $startWorkingMinute . '-' . $endWorkingHour . ':' . $endWorkingMinute;
        $workingDays = "";
        $workingDays .= isset($_REQUEST['monday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['tuseday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['wednesday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['thursday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['friday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['saturday_checkbox']) ? '1' : '0';
        $workingDays .= isset($_REQUEST['sunday_checkbox']) ? '1' : '0';
        $validFields = $this->validateUserProfileFields($branchId, $address, $region, $phone1, $phone2, $phone3);

        if ($validFields === true) {
            $companyBranchesManager->setBranchFields($branchId, implode(',', $phones), $address, $region, $workingDays, $workingHours, $zip, $lng, $lat);
            $_SESSION['success_message'] = $this->getPhrase(655);
            $this->redirect('branches' . '/' . $branchId);
        } else {
            $_SESSION['error_message'] = $validFields;
            $this->redirect('branches' . '/' . $branchId);
        }
    }

    public function validateUserProfileFields($branchId, $address, $region, $phone1, $phone2, $phone3) {
        $companyBranchesManager = CompanyBranchesManager::getInstance();
        $branchDto = $companyBranchesManager->selectByPK($branchId);
        if (!isset($branchDto) || $branchDto->getCompanyId() != $this->getUserId()) {
            return "Branch desn't exists!";
        }
        if (empty($address)) {
            return "Please input address!";
        }
        if (strpos(',', $phone1) !== false || strpos(',', $phone2) !== false || strpos(',', $phone3) !== false) {
            return $this->getPhrase(410);
        }
        return true;
    }

}

?>