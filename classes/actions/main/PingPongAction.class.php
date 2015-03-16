<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/OnlineUsersManager.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerNotificationsManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class PingPongAction extends GuestAction {

    public function service() {
        $onlineUserManager = new OnlineUsersManager();
        $customer = $this->getCustomer();
        if ($this->getUserLevel() !== UserGroups::$GUEST) {
            //add to online users table
            $newAdded = $onlineUserManager->addOnlineUser($this->getUserLevel(), $customer) > 0;
            $customerNotificationsManager = CustomerNotificationsManager::getInstance();
            $customerNotifications = $customerNotificationsManager->getCustomerNotifications($this->getUserLevel(), $customer, date('Y-m-d H:i:s', time() - 86400 * 3));
        } else {
            //add guest in online users table
            $guest_online_table_id = $_COOKIE['guest_online_table_id'];

            if ($guest_online_table_id) {
                $onlineUser = $onlineUserManager->selectByPK($guest_online_table_id);
                if (isset($onlineUser)) {
                    $onlineUserManager->updateOnlineUserAttributes($onlineUser);
                } else {
                    $newId = $onlineUserManager->addOnlineUser($this->getUserLevel(), null);
                    if (isset($newId)) {
                        $this->setcookie('guest_online_table_id', $newId);
                    }
                }
            } else {
                $newId = $onlineUserManager->addOnlineUser($this->getUserLevel(), null);
                if (isset($newId)) {
                    $this->setcookie('guest_online_table_id', $newId);
                }
            }
        }
        $this->ok(array('notifications' => $customerNotifications));
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

    protected function logRequest() {
        return false;
    }

}

?>