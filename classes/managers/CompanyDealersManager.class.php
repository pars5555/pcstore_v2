<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CompanyDealersMapper.class.php");

/**
 * CompanyManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CompanyDealersManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
     *
     * @param object $config
     * @param object $args
     * @return
     */
    function __construct() {
        $this->mapper = CompanyDealersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
     *
     * @param object $config
     * @param object $args
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CompanyDealersManager();
        }
        return self::$instance;
    }

    public function getCompanyDealersCount($companyId, $includedHiddenDealers = false) {
        return $this->mapper->getCompanyDealersCount($companyId, $includedHiddenDealers);
    }

    public function getCompanyDealersJoindWithUsersFullInfo($company_id) {
        return $this->mapper->getCompanyDealersJoindWithUsersFullInfo($company_id);
    }

    public function getCompanyDealersUsersFullInfoHiddenIncluded($company_id) {
        return $this->mapper->getCompanyDealersUsersFullInfoHiddenIncluded($company_id);
    }

    public function removeUserFromCompany($userId, $companyId) {
        $dto = $this->getByCompanyIdAndUserId($userId, $companyId);
        if (isset($dto)) {
            $this->deleteByPK($dto->getId());
            return true;
        }
        return false;
    }

    public function addUserToCompany($userId, $companyId) {
        $dto = $this->getByCompanyIdAndUserId($userId, $companyId);
        if (!$dto) {
            $dto = $this->mapper->createDto();
            $dto->setUserId($userId);
            $dto->setCompanyId($companyId);
            $dto->setTimestamp(date('Y-m-d H:i:s'));
            $this->mapper->insertDto($dto);
            return true;
        }
        return false;
    }

    public function getByCompanyIdAndUserId($userId, $companyId) {

        return $this->mapper->getByCompanyIdAndUserId($userId, $companyId);
    }

    public function getUserCompaniesIdsArray($userId) {
        $userCompaniesIds = trim($this->mapper->getUserCompaniesIds($userId));
        if (!empty($userCompaniesIds)) {
            return explode(',', $userCompaniesIds);
        }
        return array();
    }

    public function getAllUsersCompaniesFull() {
        return $this->mapper->getAllUsersCompaniesFull();
    }

    public function getByCompanyId($companyId) {
        return $this->selectByField('company_id', $companyId);
    }

    public function getAfterGivenDatetime($companyId, $datetime) {
        return $this->mapper->getAfterGivenDatetime($companyId, $datetime);
    }

}

?>