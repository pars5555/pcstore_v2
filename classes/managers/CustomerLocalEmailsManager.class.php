<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CustomerLocalEmailsMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CustomerLocalEmailsManager extends AbstractManager {

   
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
  
     * @return
     */
    function __construct() {
        $this->mapper = CustomerLocalEmailsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CustomerLocalEmailsManager();
        }
        return self::$instance;
    }

    public function getCustomerSentEmailsByCustomerEmail($customerEmail) {
        return $this->mapper->getCustomerSentEmailsByCustomerEmail($customerEmail);
    }

    public function getCustomerTrashEmailsByCustomerEmail($customerEmail) {
        return $this->mapper->getCustomerTrashEmailsByCustomerEmail($customerEmail);
    }

    public function getCustomerInboxEmailsByCustomerEmail($customerEmail) {
        return $this->mapper->getCustomerInboxEmailsByCustomerEmail($customerEmail);
    }

    public function getCustomerInboxUnreadEmailsCountCustomerEmail($customerEmail) {
        return $this->mapper->getCustomerInboxUnreadEmailsCountCustomerEmail($customerEmail);
    }

    public function trashEmails($customerEmail, $ids_array) {
        return $this->mapper->trashEmails($customerEmail, $ids_array);
    }

    public function deleteEmails($customerEmail, $ids_array) {
        return $this->mapper->deleteEmails($customerEmail, $ids_array);
    }

    public function restoreEmails($customerEmail, $ids_array) {
        return $this->mapper->restoreEmails($customerEmail, $ids_array);
    }

    public function setReadStatus($id, $readStatus) {
        return $this->mapper->updateNumericField($id, 'read_status', $readStatus);
    }

    public function sendEmail($customerLoginEmail, $to_login_emails_array, $subject, $body) {
        $sentDto = $this->mapper->createDto();
        $sentDto->setCustomerEmail($customerLoginEmail);
        $sentDto->setFromEmail($customerLoginEmail);
        $sentDto->setToEmails(implode(',', $to_login_emails_array));
        $sentDto->setSubject($subject);
        $sentDto->setBody($body);
        $sentDto->setFolder('sent');
        $sentDto->setReadStatus(1);
        $sentDto->setDatetime(date('Y-m-d H:i:s'));
        $this->mapper->insertDto($sentDto);

        foreach ($to_login_emails_array as $toLoginEmail) {
            $dto = $this->mapper->createDto();
            $dto->setCustomerEmail($toLoginEmail);
            $dto->setFromEmail($customerLoginEmail);
            $dto->setToEmails($toLoginEmail);
            $dto->setSubject($subject);
            $dto->setBody($body);
            $dto->setFolder('inbox');
            $dto->setDatetime(date('Y-m-d H:i:s'));
            $this->mapper->insertDto($dto);
        }
        return true;
    }

}

?>