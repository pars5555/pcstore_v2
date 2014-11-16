<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SignupAction extends GuestAction {

    public function service() {
        $_SESSION['signup_req'] = $_REQUEST;
        $userManager = UserManager::getInstance();

        $email = strtolower($this->secure($_REQUEST["email"]));
        $firstName = $this->secure($_REQUEST["first_name"]);
        $lastName = $this->secure($_REQUEST["last_name"]);
        $phone = $this->secure($_REQUEST["phone"]);
        $password = $this->secure($_REQUEST["password"]);
        $repeatPass = $this->secure($_REQUEST["repeat_password"]);
        $invitation_code = null;
        if (isset($_SESSION["invc"])) {
            $invitation_code = $this->secure($_SESSION["invc"]);
        }
        if (empty($firstName)) {
            $_SESSION['error_message'] = $this->getPhraseSpan(356);
            $this->redirect('signup');
        }
        if (empty($lastName)) {
            $_SESSION['error_message'] = $this->getPhraseSpan(648);
            $this->redirect('signup');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = $this->getPhraseSpan(471);
            $this->redirect('signup');
        }

        $custDto = $userManager->getCustomerByEmail($email);
        if (isset($custDto)) {
            $_SESSION['error_message'] = $this->getPhraseSpan(359);
            $this->redirect('signup');
        }

        if (!$userManager->checkPassword($password)) {
            $_SESSION['error_message'] = $this->getPhraseSpan(358);
            $this->redirect('signup');
        }

        if ($password !== $repeatPass) {
            $_SESSION['error_message'] = $this->getPhraseSpan(409);
            $this->redirect('signup');
        }


        if (empty($phone)) {
            if (strpos($phone, ',') !== false) {
                $_SESSION['error_message'] = $this->getPhraseSpan(521);
                $this->redirect('signup');
            }
        }

        $userId = $userManager->createUser($email, $password, $firstName, $phone, $lastName);
        $userManager->setSubUser($invitation_code, $userId, $email);

        $userDto = $userManager->selectByPK($userId);
        //sending activation email using $userDto->getActivationCode();		
        $emailSenderManager = new EmailSenderManager('gmail');
        $subject = "PcStore Activation!";
        $activation_code = $userDto->getActivationCode();
        $template = "account_activation";
        $params = array("user_name" => $firstName, "activation_code" => $activation_code);
        $emailSenderManager->sendEmail('registration', $email, $subject, $template, $params);
        unset($_SESSION['signup_req']);
        $this->redirect('');
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

}

?>