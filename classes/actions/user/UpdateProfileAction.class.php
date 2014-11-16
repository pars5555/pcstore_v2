<?php

require_once (CLASSES_PATH . "/actions/user/BaseUserAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class UpdateProfileAction extends BaseUserAction {

    private $userManager;

    public function service() {
        $this->userManager = new UserManager();
        $name = $this->secure($_REQUEST["first_name"]);
        $lname = $this->secure($_REQUEST["last_name"]);
        $phone1 = $this->secure($_REQUEST["phone1"]);
        $phone2 = $this->secure($_REQUEST["phone2"]);
        $phone3 = $this->secure($_REQUEST["phone3"]);
        $address = $this->secure($_REQUEST["address"]);
        $region = $this->secure($_REQUEST["region"]);
        $validFields = $this->validateUserProfileFields($name, $lname, $change_pass, $new_pass, $repeat_new_pass, $phone1, $phone2, $phone3, $address);
        if ($validFields === true) {
            $userId = $this->getUserId();
            $this->userManager->updateUserProfileFieldsById($userId, $name, $lname, $change_pass, $new_pass, $phone1, $phone2, $phone3, $address, $region);
            $_SESSION['success_message'] = "You have successfully updated you profile!";
            $this->redirect('uprofile');
        } else {
            $_SESSION['error_message'] = $validFields;
            $this->redirect('uprofile');
        }
    }

    public function validateUserProfileFields($name, $lname, $change_pass, $new_pass, $repeat_new_pass, $phone1, $phone2, $phone3, $address) {

        if (empty($name)) {
            return $this->getPhrase(356);
        }
        if (!empty($phone1) && (!strpos(',', $phone1) === false)) {
            return 'Phone number can not contain comma charecter';
        }
        if (!empty($phone2) && (!strpos(',', $phone2) === false)) {
            return 'Phone number can not contain comma charecter';
        }
        if (!empty($phone3) && (!strpos(',', $phone3) === false)) {
            return 'Phone number can not contain comma charecter';
        }
        return true;
    }

    public function getRequestGroup() {
        return RequestGroups::$userRequest;
    }

}

?>