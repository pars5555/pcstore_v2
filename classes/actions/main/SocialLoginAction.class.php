<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/security/users/CustomerUser.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SocialLoginAction extends GuestAction {

    public function service() {
        if (isset($_REQUEST['login_type'])) {
            $userManager = UserManager::getInstance();
            $json_profile = $_REQUEST['json_profile'];
            $social_user_id = $this->secure($_REQUEST['social_user_id']);
            $first_name = $this->secure($_REQUEST['first_name']);
            $last_name = $this->secure($_REQUEST['last_name']);

            $custDto = $userManager->getUserByEmail($social_user_id);
            if (!isset($custDto)) {
                $userId = $userManager->createUser($social_user_id, uniqid(), $first_name, '', $last_name, $this->secure($_REQUEST['login_type']));
                $userManager->setActive($userId);
                $userManager->setUserSocialProfile($userId, $json_profile);
                $custDto = $userManager->getUserByEmail($social_user_id);

                //bonus to inviter
                $invitation_code = null;
                $inviterId = 0;
                if (isset($_SESSION["invc"])) {
                    $invitation_code = $this->secure($_SESSION["invc"]);
                    $inviterId = $userManager->setSubUser($invitation_code, $userId);
                }
                if ($inviterId > 0) {
                    $invbonus = intval($this->getCmsVar("bonus_points_for_every_accepted_invitation"));
                    $userManager->addUserPoints($inviterId, $invbonus, "$invbonus bonus for invitation accept from user number: $userId");
                }
            }
            $user = new CustomerUser($custDto->getId());
            $this->setcookie('ul', $custDto->getLanguageCode());
            $user->setUniqueId($custDto->getHash());
            $this->sessionManager->setUser($user, true, true);
            $this->ok();
        }
    }

}

?>