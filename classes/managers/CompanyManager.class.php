<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CompanyMapper.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/RequestHistoryManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyBranchesManager.class.php");

/**
 * CompanyManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CompanyManager extends AbstractManager {


    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers   
     * @return
     */
    function __construct() {
        $this->mapper = CompanyMapper::getInstance();


        $this->companyDealersManager = CompanyDealersManager::getInstance();
        $this->requestHistoryManager = RequestHistoryManager::getInstance();
        $this->companiesPriceListManager = CompaniesPriceListManager::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CompanyManager();
        }
        return self::$instance;
    }

    public function enableSound($id, $value) {
        $this->mapper->updateNumericField($id, 'sound_on', $value);
    }

    public function getCompanyAndBranches($id) {
        return $this->mapper->getCompanyAndBranches($id);
    }

    /**
     * 
     * @param type $accessKey crop to length=8 then continnue String size=8
     * @return type
     */
    public function getCompanyByAccessKey($accessKey) {
        $accessKey = preg_replace('/[^A-Z,0-9,_]/', "", $accessKey);
        return $this->mapper->getCompanyByAccessKey($accessKey);
    }

    public function getCompanyByEmailAndPassword($email, $password) {
        return $this->mapper->getCompany($email, $password);
    }

    public function getCompanyByEmail($email) {
        return $this->mapper->getCompanyByEmail($email);
    }

    public function getAllCompanies($includePassiveCompanies = true, $includeHiddenCompanies = false) {
        return $this->mapper->getAllCompanies($includePassiveCompanies, $includeHiddenCompanies);
    }

    public function getUserCompaniesJoindWithFullInfo($userId, $show_only_last_hours = 0, $searchText = "") {
        return $this->mapper->getUserCompaniesJoindWithFullInfo($userId, $show_only_last_hours, $searchText);
    }

    public function getAllCompaniesByPriceHours($show_only_last_hours = 0, $searchText = "", $includePassiveCompanies = true, $includeHiddenCompanies = false) {
        return $this->mapper->getAllCompaniesByPriceHours($show_only_last_hours, $searchText, $includePassiveCompanies, $includeHiddenCompanies);
    }

    public function updateCompanyRating($companyDto) {

        $deaersCount = $this->companyDealersManager->getCompanyDealersCount($companyDto->getId());
        $deaersCountRating = $deaersCount * 30 / 100;
        $deaersCountRating = min($deaersCountRating, 30);
        $companyLastWeekRequestsCount = $this->requestHistoryManager->getCustomerRecentRequestsCount($companyDto->getEmail(), 7);
        $companyLastWeekRequestsCountRating = $companyLastWeekRequestsCount / 5;
        $companyLastWeekRequestsCountRating = min($companyLastWeekRequestsCountRating, 25);
        $uploadedPriceCountByUploaderTypeIdAndDays = $this->companiesPriceListManager->getUploadedPriceCountByUploaderTypeIdAndDays('company', $companyDto->getId(), 30);
        $uploadedPriceCountByUploaderTypeIdAndDaysRating = $uploadedPriceCountByUploaderTypeIdAndDays * 4;
        $uploadedPriceCountByUploaderTypeIdAndDaysRating = min($uploadedPriceCountByUploaderTypeIdAndDays, 20);
        $priceCountByDays = $this->companiesPriceListManager->getPriceCountByDays($companyDto->getId(), 20);
        $priceCountByDaysRating = $priceCountByDays * 4;
        $priceCountByDaysRating = min($priceCountByDaysRating, 25);
        $total = $deaersCountRating + $companyLastWeekRequestsCountRating + $uploadedPriceCountByUploaderTypeIdAndDaysRating + $priceCountByDaysRating;
        return $this->updateRating($companyDto->getId(), $total);
    }

    public function changePassword($id, $password) {
        return $this->updateTextField($id, 'password', $password);
    }
   

    public function updateProfile($id, $name, $url, $accessKey) {
        $companyDto = $this->selectByPK($id);
        $companyDto->setName($name);
        $companyDto->setAccessKey($accessKey);
        $companyDto->setUrl($url);
        $this->mapper->updateByPK($companyDto);
    }

    public function updateSmsConfiguration($id, $phone, $weekDays, $smsFromTime, $smsToDuration) {
        $companyDto = $this->selectByPK($id);
        if (isset($companyDto)) {
            $companyDto->setSmsReceiveTimeStart($smsFromTime);
            $companyDto->setSmsToDurationMinutes($smsToDuration);
            $companyDto->setSmsReceiveWeekdays($weekDays);
            $companyDto->setPriceUploadSmsPhoneNumber($phone);
            $this->mapper->updateByPK($companyDto);
            return true;
        }
        return false;
    }

    public function getCompanyPriceInterestedForSmsCompanies($companyId) {
        return $this->mapper->getCompanyPriceInterestedForSmsCompanies($companyId);
    }

    public function getAllCompaniesEmails() {
        $dtos = $this->mapper->getAllCompaniesEmails();
        $ret = array();
        foreach ($dtos as $key => $dto) {
            $ret[] = $dto->getEmail();
        }
        return $ret;
    }

    public function updateCompanyHash($uId) {
        $hash = $this->generateHash($uId);
        $companyDto = $this->mapper->createDto();
        $companyDto->setId($uId);
        $companyDto->setHash($hash);
        $this->mapper->updateByPK($companyDto);
        return $hash;
    }

    public function getUserCompanies($userId, $includePassiveCompanies = true) {
        return $this->mapper->getUserCompanies($userId, $includePassiveCompanies);
    }

    public function generateHash($id) {
        return md5($id * time() * 19);
    }

    public function validate($id, $hash) {
        return $this->mapper->validate($id, $hash);
    }

    public function getCompaniesNamesArray($companiesDtos) {
        $ret = array();
        if (!$companiesDtos) {
            return $ret;
        }
        foreach ($companiesDtos as $key => $dto) {
            $ret[] = $dto->getName();
        }
        return $ret;
    }

    public function getCompaniesIdsArray($companiesDtos) {

        $ret = array();
        if (!$companiesDtos) {
            return $ret;
        }
        foreach ($companiesDtos as $key => $dto) {
            $ret[] = $dto->getId();
        }
        return $ret;
    }

    public function setLastSmsValidationCode($companyId, $code) {
        $dto = $this->mapper->selectByPK($companyId);
        $dto->setLastSmsValidationCode($code);
        return $this->mapper->updateByPK($dto);
    }

    public function updateRating($id, $rating) {
        return $this->mapper->updateNumericField($id, "rating", $rating);
    }

    public function setCompanyOffers($id, $offers) {
        return $this->mapper->updateTextField($id, "offers", $offers);
    }

    public function setInterestedCompaniesIdsForSms($id, $companiesIds) {
        return $this->mapper->updateTextField($id, "interested_companies_ids_for_sms", $companiesIds);
    }

    public function setLanguageCode($id, $lc) {
        $this->mapper->updateTextField($id, 'language_code', $lc);
    }

    public function setLastPingToNow($id) {
        $this->mapper->updateTextField($id, 'last_ping', date('Y-m-d H:i:s'));
    }

}

?>