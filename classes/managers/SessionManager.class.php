<?php

require_once (CLASSES_PATH . "/framework/AbstractSessionManager.class.php");
require_once (CLASSES_PATH . "/security/RequestGroups.class.php");
require_once (CLASSES_PATH . "/framework/exceptions/RedirectException.class.php");
require_once (CLASSES_PATH . "/security/users/GuestUser.class.php");
require_once (CLASSES_PATH . "/security/users/AdminUser.class.php");
require_once (CLASSES_PATH . "/security/users/CustomerUser.class.php");
require_once (CLASSES_PATH . "/security/users/CompanyUser.class.php");
require_once (CLASSES_PATH . "/security/users/ServiceCompanyUser.class.php");
require_once (CLASSES_PATH . "/security/UserGroups.class.php");
require_once (CLASSES_PATH . "/security/users/GuestUser.class.php");
require_once (CLASSES_PATH . "/security/users/AuthenticateUser.class.php");

/**
 *
 * @author  Naghashyan Solutions, e-mail: info@naghashyan.com
 * @version 1.0
 * @package framework
 *
 */
class SessionManager extends AbstractSessionManager {

    private $user = null;
    private $config;

    public function __construct($config) {
        session_set_cookie_params(3600000);
        session_start();
    }

    public function getUser() {        
        if ($this->user != null) {
            return $this->user;
        }
        // for test
        $this->user = new GuestUser();
        try {
            if (isset($_COOKIE["ut"])) {
                if (isset($_COOKIE["uh"]) && isset($_COOKIE["ud"])) {
                    if ($_COOKIE["ut"] == UserGroups::$USER) {
                        $user = new CustomerUser($_COOKIE["ud"]);
                    } else if ($_COOKIE["ut"] == UserGroups::$ADMIN) {
                        $user = new AdminUser($_COOKIE["ud"]);
                    } else if ($_COOKIE["ut"] == UserGroups::$COMPANY) {
                        $user = new CompanyUser($_COOKIE["ud"]);
                    } else if ($_COOKIE["ut"] == UserGroups::$SERVICE_COMPANY) {
                        $user = new ServiceCompanyUser($_COOKIE["ud"]);
                    }
                }
            }
            if (isset($user) && $user->validate($_COOKIE["uh"])) {
                $this->user = $user;
            }

            if ($this->user && $this->user->getLevel() != UserGroups::$GUEST) {
                $hash = $_COOKIE["uh"];
                /* if (!$status) {
                  $hash = $this->updateUserHash($_COOKIE["ud"]);
                  $this->updateUserUniqueId($user);
                  } */
                $this->user->setUniqueId($hash, false);
            }
        } catch (InvalidUserException $ex) {
            
        }
        return $this->user;
    }

    public function validateRequest($request, $user) {
        if ($user->getLevel() == UserGroups::$ADMIN) {
            return true;
        }
        if ($request->getRequestGroup() == RequestGroups::$guestRequest) {
            return true;
        }

        if ($request->getRequestGroup() == RequestGroups::$userRequest && $user->getLevel() == UserGroups::$USER) {
            return true;
        }

        if ($request->getRequestGroup() == RequestGroups::$companyRequest && $user->getLevel() == UserGroups::$COMPANY) {
            return true;
        }

        if ($request->getRequestGroup() == RequestGroups::$serviceCompanyRequest && $user->getLevel() == UserGroups::$SERVICE_COMPANY) {
            return true;
        }

        if ($request->getRequestGroup() == RequestGroups::$companyAndServiceCompanyRequest &&
                ($user->getLevel() == UserGroups::$SERVICE_COMPANY || $user->getLevel() == UserGroups::$COMPANY)) {
            return true;
        }

        if ($request->getRequestGroup() == RequestGroups::$userCompanyRequest &&
                ($user->getLevel() == UserGroups::$SERVICE_COMPANY || $user->getLevel() == UserGroups::$COMPANY || $user->getLevel() == UserGroups::$USER)) {
            return true;
        }
        return false;
    }

    private function updateUserHash($uId) {
        $userManager = UserManager::getInstance($this->config, null);
        return $userManager->updateUserHash($uId);
    }

}

?>