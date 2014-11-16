<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/security/users/CustomerUser.class.php");
require_once (CLASSES_PATH . "/security/users/CompanyUser.class.php");
require_once (CLASSES_PATH . "/security/users/ServiceCompanyUser.class.php");
require_once (CLASSES_PATH . "/security/users/AdminUser.class.php");

/**
 * @author Vahagn Sookiasian
 */
class LoginAction extends GuestAction {

    public function service() {
        $userManager = UserManager::getInstance();
        $email = strtolower($userManager->secure($_REQUEST["email"]));
        $pass = $userManager->secure($_REQUEST["password"]);
        $custDto = $userManager->getCustomerByEmailAndPassword($email, $pass);
        $userType = $userManager->getCustomerType($email, $pass);
        if ($userType == UserGroups::$USER && $custDto->getActive() == 0) {
            $this->error(array("message" => sprintf($this->getPhrase(380), $custDto->getEmail())));
        }
        if (isset($custDto)) {
            if ($userType !== UserGroups::$ADMIN && $custDto->getBlocked() == 1) {
                $this->error(array("message" => $this->getPhrase(411) . ' ' . $this->getCmsVar("pcstore_support_phone_number")));
            }
            $user = null;
            if ($userType === UserGroups::$ADMIN) {
                $user = new AdminUser($custDto->getId());
            } else if ($userType === UserGroups::$USER) {
                $user = new CustomerUser($custDto->getId());
                $this->setcookie('ul', $custDto->getLanguageCode());
            } else if ($userType === UserGroups::$COMPANY) {
                $user = new CompanyUser($custDto->getId());
                $companyManager = CompanyManager::getInstance();
                $companyManager->updateCompanyRating($custDto);
                $this->setcookie('ul', $custDto->getLanguageCode());
            } else if ($userType === UserGroups::$SERVICE_COMPANY) {
                $user = new ServiceCompanyUser($custDto->getId());
                $companyManager = ServiceCompanyManager::getInstance();
                $this->setcookie('ul', $custDto->getLanguageCode());
            }

            $user->setUniqueId($custDto->getHash());
            $this->sessionManager->setUser($user, true, true);
            $this->ok();
        } else {
            $this->error(array("message" => $this->getPhrase(412)));
        }
    }

}

?>