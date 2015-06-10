<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/UninterestingEmailsManager.class.php");
require_once (CLASSES_PATH . "/managers/NewsletterSubscribersManager.class.php");
require_once (CLASSES_PATH . "/managers/MailgunEmailSenderManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SendNewsletterAction extends BaseAdminAction {

    public function service() {
        $email_body_html = $_REQUEST['email_body_html'];
        if (empty($email_body_html)) {
            $this->error(array('errText' => 'email body is empty!'));
        }

        $fromEmail = $this->getCmsVar('pcstore_news_email');
        $fromName = 'Pcstore.am Newsletter!';


        $includeUsers = 1;
        $subject = 'Newsletter from PcStore.am!!!';

        $mailgunEmailSenderManager = new MailgunEmailSenderManager($this->getCmsVar("mailgun_api_key"), $this->getCmsVar("mailgun_email_domain_pc"), $this->getCmsVar("mailgun_max_recipients_number_per_email"));
        if (!empty($_REQUEST['test'])) {
            $testEmail = $_REQUEST['test_email'];
            $mailGunResult = $mailgunEmailSenderManager->sendHtmlEmail($testEmail, $subject, $email_body_html, $fromEmail, $fromName);
            $this->ok(array('count' => 1, 'result' => $mailGunResult));
        }

        $uninterestingEmailsManager = UninterestingEmailsManager::getInstance();
        $newsletterSubscribersManager = NewsletterSubscribersManager::getInstance();
        $emailsArray = $newsletterSubscribersManager->getAllSubscribers();
        $filteredEmailsArray = $uninterestingEmailsManager->removeUninterestingEmailsFromList($emailsArray);

        if ($includeUsers == 1) {
            $userManager = UserManager::getInstance();
            $allUsers = $userManager->selectAll();
            foreach ($allUsers as $userDto) {
                if ($userDto->getAvtive() == 0) {
                    continue;
                }
                $userRealEmailAddress = strtolower($userManager->getRealEmailAddressByUserDto($userDto));
                if (filter_var($userRealEmailAddress, FILTER_VALIDATE_EMAIL)) {
                    $filteredEmailsArray[] = $userRealEmailAddress;
                }
            }
        }
        //for FB, Google and TWITTER users emails may be duplicated!!!! so used array_unique
        $recipients = array_unique($filteredEmailsArray);

        if (count($recipients) === 0) {
            $this->error(array('errText' => 'There is no any recipient!'));
        }
        ini_set('memory_limit', '4G');
        $mailGunResult = $mailgunEmailSenderManager->sendHtmlEmail($recipients, $subject, $email_body_html, $fromEmail, $fromName);
        $this->ok(array('count' => count($recipients), 'result' => $mailGunResult));
    }

}

?>