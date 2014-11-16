<?php

require_once(CLASSES_PATH . "/framework/AbstractAction.class.php");
require_once(CLASSES_PATH . "/managers/AdminManager.class.php");

/**
 * @author Karen Manukyan
 */
class LoginAction extends AbstractAction {

    public function service() {
        $username = $this->secure($_REQUEST['username']);
        $password = $this->secure($_REQUEST['password']);

        $adminsManager = AdminManager::getInstance();
        $adminDto = $adminsManager->getAdminByEmailAndPassword($username, $password);
        if ($adminDto) {
            $adminUser = new AdminUser($adminDto->getId());
            $adminUser->setUniqueId($adminDto->getHash());
            $this->sessionManager->setUser($adminUser, true, true);
        $this->redirect('admin');
        } else {
            $_SESSION['error_message'] = 'Wrong Login/Password!';
        $this->redirect('admin/login');
        }
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

}

?>