<?php
require_once (CLASSES_PATH . '/lib/mailgun-php-master/vendor/autoload.php');

use Mailgun\Mailgun;

/**
 * UserManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class MailgunEmailSenderManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;
    private $mailgun;
    private $domain;
    private $maxRecipientsPerEmail;

    /**
     * Initializes DB mappers

     * @return
     */
    function __construct($apiKey, $domain, $maxRecipientsPerEmail = 500) {
        $this->mailgun = new Mailgun($apiKey);
        $this->domain = $domain;
        $this->maxRecipientsPerEmail = intval($maxRecipientsPerEmail);
        if ($this->maxRecipientsPerEmail <= 10) {
            $this->maxRecipientsPerEmail = 500;
        }
    }

    /**
     * Returns an singleton instance of this class
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new EmailSenderManager();
        }
        return self::$instance;
    }

    public function sendHtmlEmail($to, $subject, $bodyHtml, $fromEmail, $fromName, $attachedFiles = null) {
        if (empty($to)) {
            return "Empty Recipients list!";
        }
        if (!is_array($to)) {
            $to = array($to);
        }
        if (ENVIRONMENT !== 'production' && count($to)>3) {
            return true;
        }
        
        
        $toArrays = array_chunk($to, $this->maxRecipientsPerEmail);
        $ret = array();
        foreach ($toArrays as $toAddressesArray) {
            $params = $this->getEmailParams($toAddressesArray, $subject, $bodyHtml, $fromEmail, $fromName, $attachedFiles);
            try {
                $res = $this->mailgun->sendMessage($this->domain, $params[0], $params[1]);
                $ret[] = $res->http_response_code == 200;
            } catch (Exception $ex) {
                $ret[] = $ex->getMessage();
            }
            $ret[] = 'Unknown Error!';
        }
        return $ret;
    }

    private function getEmailParams($to, $subject, $bodyHtml, $fromEmail, $fromName, $attachedFiles = null) {
        $result[0] = array(
            'from' => $fromName . " <" . $fromEmail . ">",
            'to' => $fromEmail,
            'bcc' => implode(',', $to),
            'subject' => $subject,
            'html' => $bodyHtml,
            'text' => strip_tags($bodyHtml)
        );

        $result[1] = array();
        $result[1]['attachment'] = array();
        if (!empty($attachedFiles)) {
            foreach ($attachedFiles as $fileDisplayName => $file) {
                $result[1]['attachment'][] = array('filePath' => $file, 'remoteName' => $fileDisplayName);
            }
        }


        /*

          $paramsTo = array();
          foreach ($to as $emailAddress) {
          $paramsTo[] = array(
          'email' => $emailAddress,
          'name' => null,
          'type' => 'to'
          );
          }
          $params = array(
          'html' => $bodyHtml,
          'text' => strip_tags($bodyHtml),
          'subject' => $subject,
          'from_email' => $fromEmail,
          'from_name' => $fromName,
          'headers' => array('Reply-To' => $fromEmail,
          'Content-type' => 'text/html; charset=utf-8'),
          'preserve_recipients' => false,
          'to' => $paramsTo
          );

          if (!empty($attachedFiles)) {
          $params ['attachments'] = array();
          foreach ($attachedFiles as $fileDisplayName => $file) {
          $params ['attachments'] [] = array(
          'type' => $this->getMimeType($file),
          'name' => $fileDisplayName,
          'content' => base64_encode(file_get_contents($file))
          );
          }
          } */
        return $result;
    }

    private function getMimeType($filename) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mime;
    }

}

?>