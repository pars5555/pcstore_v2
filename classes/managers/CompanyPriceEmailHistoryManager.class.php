<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CompanyPriceEmailHistoryMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CompanyPriceEmailHistoryManager extends AbstractManager {

   
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        $this->mapper = CompanyPriceEmailHistoryMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CompanyPriceEmailHistoryManager();
        }
        return self::$instance;
    }

    public function addRow($companyId, $companyType, $fromEmail, $toEmails, $body, $subject, $attachments) {
        if (is_array($toEmails)) {
            $toEmails = implode(',', $toEmails);
        }
        if (is_array($attachments)) {
            $attachments = implode(',', $attachments);
        }
        $dto = $this->createDto();
        $dto->setCompanyId($companyId);
        $dto->setCompanyType($companyType);
        $dto->setFromEmail($fromEmail);
        $dto->setToEmails($toEmails);
        $dto->setBody($body);
        $dto->setSubject($subject);
        $dto->setAttachments($attachments);
        $dto->setDatetime(date('Y-m-d H:i:s'));
        return $this->insertDto($dto);
    }

    public function getCompanySentEmailsByHours($companyId, $companyType, $hours) {
        return $this->mapper->getCompanySentEmailsByHours($companyId, $companyType, $hours);
    }

}

?>