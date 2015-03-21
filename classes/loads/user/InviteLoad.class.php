<?php

require_once (CLASSES_PATH . "/loads/user/BaseUserLoad.class.php");
require_once (CLASSES_PATH . "/managers/UserPendingSubUsersManager.class.php");
require_once (CLASSES_PATH . "/managers/UserSubUsersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class InviteLoad extends BaseUserLoad {

    public function load() {
        $userPendingSubUsersManager = UserPendingSubUsersManager::getInstance();
        $userId = $this->getUserId();
        $pending_users = $userPendingSubUsersManager->getByUserIdOrderByDate($userId);
        $this->addParam("pendingUsers", $pending_users);
        
        
        $userSubUsersManager = UserSubUsersManager::getInstance();
        $subUsersDtos = $userSubUsersManager->getUserSubUsers($userId);
        
        $this->addParam("subUsers", $subUsersDtos);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/user/invite.tpl";
    }

}

?>