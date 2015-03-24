<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/UserPendingSubUsersManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class InviteAction extends GuestAction {

    public function service() {

        $userManager = UserManager::getInstance();
        $userPendingSubUsersManager = new UserPendingSubUsersManager();
        $emailSenderManager = new EmailSenderManager('gmail');
        $userId = $this->getUserId();
        $user = $userManager->selectByPK($userId);
        $subUsersRegistrationCode = $user->getSubUsersRegistrationCode();
        if (empty($subUsersRegistrationCode)) {
            $subUsersRegistrationCode = uniqid();
            $userManager->setSubUsersRegistrationCode($userId, $subUsersRegistrationCode);
        }

        if (isset($_REQUEST["email"])) {
            $pendingUserEmail = $this->secure($_REQUEST["email"]);
            if (filter_var($pendingUserEmail, FILTER_VALIDATE_EMAIL)) {
                if ($userManager->getCustomerByEmail($pendingUserEmail)) {
                    $_SESSION['error_message'] = $this->getPhraseSpan(359);
                    $this->redirect("uinvite");
                }
                $byUserIdAndPendingSubUserEmail = $userPendingSubUsersManager->getByUserIdAndPendingSubUserEmail($userId, $pendingUserEmail);
                if (!isset($byUserIdAndPendingSubUserEmail)) {
                    $userPendingSubUsersManager->addPendingSubUserEmailToUser($pendingUserEmail, $userId);
                    $from = $userManager->getRealEmailAddress($userId);
                    $username = $user->getName();
                    $subject = $username . " invites you to join PcStore!";
                    $template = "user_to_user_invitation";
                    $params = array("user_name" => $username, "invitation_code" => $subUsersRegistrationCode);
                    $fromName = $user->getName() . ' ' . $user->getLastName();
                    $emailSenderManager->sendEmail('news', $pendingUserEmail, $subject, $template, $params, $from, $fromName);
                    $_SESSION['success_message'] = $this->getPhraseSpan(603);
                    $this->redirect("uinvite");
                } else {
                    $_SESSION['error_message'] = $this->getPhraseSpan(605);
                    $this->redirect("uinvite");
                }
            } else {
                $_SESSION['error_message'] = $this->getPhraseSpan(471);
                $this->redirect("uinvite");
            }
        } elseif (isset($_REQUEST["invitation_id"])) {
            $invitationId = intval($_REQUEST["invitation_id"]);
            $from = $userManager->getRealEmailAddress($userId);
            $username = $user->getName();
            $subject = $username . " invites you to join PcStore!";
            $template = "user_to_user_invitation";
            $params = array("user_name" => $username, "invitation_code" => $subUsersRegistrationCode);
            $fromName = $user->getName() . ' ' . $user->getLastName();
            $dto = $userPendingSubUsersManager->selectByPK($invitationId);
            $pendingSubUserEmail = $dto->getPendingSubUserEmail();
            $emailSenderManager->sendEmail('news', $pendingSubUserEmail, $subject, $template, $params, $from, $fromName);
            $dto->setLastSent(date('Y-m-d H:i:s'));
            $userPendingSubUsersManager->updateByPk($dto);
            $_SESSION['success_message'] = $this->getPhraseSpan(603);
            $this->redirect("uinvite");
        }
    }

    public function getRequestGroup() {
        return RequestGroups::$userRequest;
    }

}

?>