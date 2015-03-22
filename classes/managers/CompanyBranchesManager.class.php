<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CompanyBranchesMapper.class.php");

/**
 * CompanyManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CompanyBranchesManager extends AbstractManager {

    

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        $this->mapper = CompanyBranchesMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CompanyBranchesManager();
        }
        return self::$instance;
    }

    public function setBranchFields($company_branch_id, $phones, $address, $region, $working_days, $working_hours, $zip, $lng, $lat) {
        $dto = $this->mapper->selectByPK($company_branch_id);
        if (isset($dto)) {
            $dto->setPhones($phones);
            $dto->setStreet($address);
            $dto->setRegion($region);
            $dto->setWorkingDays($working_days);
            $dto->setWorkingHours($working_hours);
            $dto->setZip($zip);
            $dto->setLng($lng);
            $dto->setLat($lat);
            $this->mapper->updateByPK($dto);
            return true;
        }
        return false;
    }

    public function addBranch($companyId, $street, $region, $zip) {
        $dto = $this->mapper->createDto();
        $dto->setCompanyId($companyId);
        $dto->setStreet($street);
        $dto->setRegion($region);
        $dto->setZip($zip);
        return $this->mapper->insertDto($dto);
    }

    public function getCompaniesBranches($companiesIdsArray) {
        if (is_array($companiesIdsArray)) {
            $companiesIdsArray = implode(',', $companiesIdsArray);
        }
        return $this->mapper->getCompaniesBranches($companiesIdsArray);
    }

}

?>