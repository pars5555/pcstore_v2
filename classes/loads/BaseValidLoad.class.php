<?php

require_once (CLASSES_PATH . "/framework/AbstractLoad.class.php");
require_once (CLASSES_PATH . "/managers/LanguageManager.class.php");
require_once (CLASSES_PATH . "/managers/CmsSettingsManager.class.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendchatLoad
 *
 * @author Administrator
 */
abstract class BaseValidLoad extends AbstractLoad {

    public function initialize($sessionManager, $config, $loadMapper, $args) {
        parent::initialize($sessionManager, $config, $loadMapper, $args);
        $lm = LanguageManager::getInstance();
        $this->addParam("lm", $lm);
        $userLevel = $this->getUserLevel();
        $customer = $this->getCustomer();
        $this->addParam('DOCUMENT_ROOT', DOCUMENT_ROOT);
        $this->addParam('customer', $customer);
        $this->addParam('userLevel', $userLevel);
        $this->addParam('userId', $this->getUserId());
        $this->addParam('userGroupsUser', UserGroups::$USER);
        $this->addParam('userGroupsCompany', UserGroups::$COMPANY);
        $this->addParam('userGroupsServiceCompany', UserGroups::$SERVICE_COMPANY);
        $this->addParam('userGroupsGuest', UserGroups::$GUEST);
        $this->addParam('userGroupsAdmin', UserGroups::$ADMIN);
        if ($userLevel == UserGroups::$COMPANY) {
            $this->addParam("customer_ping_pong_timeout_seconds", $this->getCmsVar("company_ping_pong_timeout_seconds"));
        } elseif ($userLevel == UserGroups::$USER) {
            $this->addParam("customer_ping_pong_timeout_seconds", $this->getCmsVar("user_ping_pong_timeout_seconds"));
        } elseif ($userLevel == UserGroups::$ADMIN) {
            $this->addParam("customer_ping_pong_timeout_seconds", $this->getCmsVar("admin_ping_pong_timeout_seconds"));
        } else {
            $this->addParam("customer_ping_pong_timeout_seconds", $this->getCmsVar("guest_ping_pong_timeout_seconds"));
        }
        if (!$this->isMain()) {
            $this->initSucessMessages();
            $this->initErrorMessages();
        }

        $pageTitle = $this->getPageTitle();
        $pageDescription = $this->getPageDescription();
        $pageKeywords = $this->getPageKeywords();
        if (isset($this->args['mainLoad'])) {
            if (!empty($pageTitle)) {
                $this->args['mainLoad']->addParam('page_title',  ucfirst(DOMAIN) . ': ' . $pageTitle);
            }
            if (!empty($pageDescription)) {
                $this->args['mainLoad']->addParam('page_description', $pageDescription);
            }
            if (!empty($pageKeywords)) {
                $this->args['mainLoad']->addParam('page_keywords', $pageKeywords);
            }
        }
    }

    public function getDefaultLoads($args) {
        $loads = array();
        return $loads;
    }

    protected function initErrorMessages() {
        if (!empty($_SESSION['error_message'])) {
            $message = $this->secure($_SESSION['error_message']);
            $this->addParam('error_message', $message);
            unset($_SESSION['error_message']);
        }
    }

    protected function initSucessMessages() {
        if (!empty($_SESSION['success_message'])) {
            $message = $this->secure($_SESSION['success_message']);
            $this->addParam('success_message', $message);
            unset($_SESSION['success_message']);
        }
    }

    protected function getPageTitle() {
        return "";
    }

    protected function getPageDescription() {
        return "";
    }

    protected function getPageKeywords() {
        return "";
    }

    public function isValidLoad($namespace, $load) {
        return true;
    }

    public function generateLoadClassName($load_name) {
        $loadClassName = strtoupper($load_name[0]) . substr($load_name, 1);
        while (strpos($loadClassName, '_') !== false) {
            $_pos = strpos($loadClassName, '_');
            $letter = strtoupper($loadClassName[$_pos + 1]);
            $loadClassName = substr($loadClassName, 0, $_pos) . $letter . substr($loadClassName, $_pos + 2);
        }
        return $loadClassName . 'Load';
    }

    protected function isMain() {
        return false;
    }

}

?>