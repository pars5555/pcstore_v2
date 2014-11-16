<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ContactUsAction extends GuestAction {

    public function service() {
        $_SESSION['contact_us_req'] = $_REQUEST;
        $emailSenderManager = new EmailSenderManager('gmail');
        $email = strtolower($this->secure($_REQUEST['email']));
        $msg = $this->secure($_REQUEST['msg']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = $this->getPhrase(471);
            $this->redirect('contactus');
        }
        $name = strtolower($this->secure($_REQUEST['name']));
        if (empty($name)) {
            $_SESSION['error_message'] = $this->getPhrase(648);
            $this->redirect('contactus');
        }
        $pcstore_contact_us_email = $this->getCmsVar('pcstore_contact_us_email');
        $subject = "Message To PcStore from " . $email;
        $templateId = "contact_us";
        $params = array("msg" => $msg);
        if ($this->getUserLevel() !== UserGroups::$GUEST) {
            $fromName = $this->getCustomer()->getName() . ' (' . $this->getUserLevelString() . '-' . $this->getUserId() . ')';
        } else {
            $fromName = $email;
        }
        $emailSenderManager->sendEmail('contactus', $pcstore_contact_us_email, $subject, $templateId, $params, $email, $fromName);
        $_SESSION['success_message'] = $this->getPhrase(438);
        unset($_SESSION['contact_us_req']);
        $this->redirect('contactus');
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

}

?>