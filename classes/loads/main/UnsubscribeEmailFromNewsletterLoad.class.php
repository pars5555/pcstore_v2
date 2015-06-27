<?php

require_once (CLASSES_PATH . "/loads/main/BaseGuestLoad.class.php");
require_once (CLASSES_PATH . "/managers/NewsletterSubscribersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class UnsubscribeEmailFromCompanyLoad extends BaseGuestLoad {

    public function load() {
        if (!isset($_REQUEST['email'])) {
            exit;
        }
        $newsletterSubscribersManager = NewsletterSubscribersManager::getInstance();
        $md_email = $this->secure($_REQUEST['email']);
        $newsletterSubscribersManager->removeSubscriberEmail($md_email);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/unsubscribe_email_from_newsletter.tpl";
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

    protected function logRequest() {
        return false;
    }

}

?>