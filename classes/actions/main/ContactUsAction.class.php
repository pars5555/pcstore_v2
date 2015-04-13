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
        $subject = "Message To PcStore from " . $name . " (" . $email . ")";
        $templateId = "contact_us";
        $params = array("msg" => $msg);
        if ($this->getUserLevel() !== UserGroups::$GUEST) {
            $fromName = $this->getCustomer()->getName() . ' (' . $this->getUserLevelString() . '-' . $this->getUserId() . ')';
        } else {
            $fromName = $email;
        }
        if (!empty($_FILES)) {
            $attachment = $this->getAttachment();
            $emailSenderManager->sendEmailWithAttachments('contactus', $pcstore_contact_us_email, $subject, $templateId, $params, $attachment, $email, $fromName);
        } else {
            $emailSenderManager->sendEmail('contactus', $pcstore_contact_us_email, $subject, $templateId, $params, $email, $fromName);
        }
        $_SESSION['success_message'] = $this->getPhrase(438);
        unset($_SESSION['contact_us_req']);
        $this->redirect('contactus');
    }

    private function getAttachment() {
        ini_set('upload_max_filesize', '7M');
        $name = $_FILES['attachment']['name'];
        $tmp_name = $_FILES['attachment']['tmp_name'];
        if (!is_dir(DATA_TEMP_DIR)) {
            mkdir(DATA_TEMP_DIR, 0777);
        }
        $file = DATA_TEMP_DIR . '/' . $name;
        move_uploaded_file($tmp_name, DATA_TEMP_DIR . '/' . $name);
        return array($name => $file);
    }

    public function getRequestGroup() {
        return RequestGroups::$guestRequest;
    }

}

?>