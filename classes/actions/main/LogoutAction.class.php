<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/OnlineUsersManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class LogoutAction extends GuestAction {

    public function service() {
        $customer = $this->getCustomer();
        if ($customer) {
            $onlineUsersManager = new OnlineUsersManager();
            $user = $this->getUser();
            $onlineUsersManager->removeOnlineUserByEmail($customer->getEmail());
            $this->sessionManager->removeUser($user, true);
        }
        $this->redirect();
    }

}

?>