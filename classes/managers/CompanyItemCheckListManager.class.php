<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CompanyItemCheckListMapper.class.php");

/**
 * CustomerAlertListManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CompanyItemCheckListManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        $this->mapper = CompanyItemCheckListMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CompanyItemCheckListManager();
        }
        return self::$instance;
    }

    public function setResponseSentToCustomerFieldValue($id, $value) {
        return $this->mapper->updateTextField($id, 'response_sent_to_customer_uid', $value);
    }

    public function setSentToCompanyFieldValue($id, $value) {
        return $this->mapper->updateTextField($id, 'sent_to_company_uid', $value);
    }

    public function getCompanyQuestionsFromCustomers($companyId, $winUid) {
        return $this->mapper->getCompanyQuestionsFromCustomers($companyId, $winUid);
    }

    public function getCustomerSentQuestionsResponses($customerEmail, $winUid) {
        return $this->mapper->getCustomerSentQuestionsResponses($customerEmail, $winUid);
    }

    public function getSentCompanyItemCheckDtos($companyId, $itemId) {
        return $this->mapper->getSentCompanyItemCheckDtos($companyId, $itemId);
    }

    public function setCompanyItemAvailability($companyId, $itemId, $itemAvailability) {
        $this->mapper->setCompanyItemAvailability($companyId, $itemId, $itemAvailability);
    }

    public function setCompanyRespondedAlertsAlreadySentToCustomer($customerEmail) {
        return $this->mapper->setCompanyRespondedAlertsAlreadySentToCustomer($customerEmail);
    }

    public function isItemCheckingStartedByAnotherUser($itemId) {
        $dtos = $this->mapper->isItemCheckingStartedByAnotherUser($itemId);
        return !empty($dtos);
    }

    public function isDuplicateItemChecking($itemId, $fromEmail) {
        $dtos = $this->mapper->isDuplicateItemChecking($itemId, $fromEmail);
        return !empty($dtos);
    }

    public function removeOldRowsBySeconds($timoutSeconds) {
        return $this->mapper->removeOldRowsBySeconds($timoutSeconds);
    }

    public function addCompanyItemCheckList($companyId, $itemId, $fromEmail, $fromName, $fromCustomerType, $keepAnonymous) {
        $isDuplicateItemChecking = $this->isDuplicateItemChecking($itemId, $fromEmail);
        if ($isDuplicateItemChecking) {
            return false;
        }
        $isItemCheckingStartedByAnotherUser = $this->isItemCheckingStartedByAnotherUser($itemId);
        $dto = $this->mapper->createDto();
        $dto->setCompanyId($companyId);
        $dto->setItemId($itemId);
        $dto->setFromEmail($fromEmail);
        $dto->setFromName($fromName);
        $dto->setFromCustomerType($fromCustomerType);
        $dto->setkeepAnonymous($keepAnonymous);
        $dto->setSentToCompany($isItemCheckingStartedByAnotherUser ? 1 : 0);
        $dto->setTimestamp(date('Y-m-d H:i:s'));
        return $this->mapper->insertDto($dto);
    }

}

?>