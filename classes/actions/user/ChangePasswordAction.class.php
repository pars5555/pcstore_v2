<?php

require_once (CLASSES_PATH . "/actions/user/BaseUserAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ChangePasswordAction extends BaseUserAction {

    public function service() {
        $userManager = UserManager::getInstance();
        $customer = $this->getCustomer();
        $password = $this->secure($_REQUEST["password"]);
        $newPassword = $this->secure($_REQUEST["new_password"]);
        $repeatNewPassword = $this->secure($_REQUEST["repeat_new_password"]);

        if ($customer->getPassword() !== $password) {
            $_SESSION['error_message'] = $this->getPhraseSpan(581);
            $this->redirect('uchangepass');
        }

        if (!$userManager->checkPassword($newPassword)) {
            $_SESSION['error_message'] = $this->getPhraseSpan(358);
            $this->redirect('uchangepass');
        }

        if ($newPassword !== $repeatNewPassword) {
            $_SESSION['error_message'] = $this->getPhraseSpan(409);
            $this->redirect('uchangepass');
        }
    }

    public function getRequestGroup() {
        return RequestGroups::$userRequest;
    }

}

?>