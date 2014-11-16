<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/BonusHistoryManager.class.php");
require_once (CLASSES_PATH . "/managers/UserSubUsersManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerLocalEmailsManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerAlertsManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CustomerMessagesAfterLoginMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CustomerMessagesAfterLoginManager extends AbstractManager {

    /**
     * @var app config
     */
    private $config;

    /**
     * @var passed arguemnts
     */
    private $args;

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
        $this->mapper = CustomerMessagesAfterLoginMapper::getInstance();
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

            self::$instance = new CustomerMessagesAfterLoginManager();
        }
        return self::$instance;
    }

    public function addCustomerMessagesAfterLoginByPreviousPing($custDto, $userLevel, $previousPing) {

        if ($userLevel === UserGroups::$GUEST) {
            return false;
        }
        $custEmail = $custDto->getEmail();

        $companyDealersManager = CompanyDealersManager::getInstance();
        $userCompaniesIdsArray = array();
        if ($userLevel === UserGroups::$USER) {
            $userCompaniesIdsArray = $companyDealersManager->getUserCompaniesIdsArray($custDto->getId());
        }
        if ($userLevel === UserGroups::$COMPANY || $userLevel === UserGroups::$ADMIN || !empty($userCompaniesIdsArray)) {
            //new prices after last ping
            $companiesPriceListManager = CompaniesPriceListManager::getInstance();
            $allPricesAfterTime = $companiesPriceListManager->getAllPricesAfterTime($previousPing, $userCompaniesIdsArray);
            if (!empty($allPricesAfterTime)) {
                $pre = HTTP_PROTOCOL . HTTP_HOST;
                $massage = '';
                foreach ($allPricesAfterTime as $dto) {
                    $companyName = $dto->getCompanyName() . ' (`558`: ' . $dto->getUploadDateTime() . ')';
                    $companyId = $dto->getCompanyId();
                    $pricePath = HTTP_PROTOCOL . HTTP_HOST . '/price/last_price/' . $companyId;
                    $massage .= '<div><a href="' . $pricePath . '"><img src="' . $pre . '/images/small_logo/' . $companyId . '" style="vertical-align: middle;" /> ' .
                            $companyName . '</a></div>';
                }
                $this->addCustomerMessage($custEmail, '540', $massage, 1, 'attention');
            }
        }


        //new added dealers messages for (company only)
        if ($userLevel === UserGroups::$COMPANY || $userLevel === UserGroups::$ADMIN) {
            $dealersAfterGivenDatetime = $companyDealersManager->getAfterGivenDatetime(
                    $userLevel === UserGroups::$ADMIN ? 0 : intval($custDto->getId()), $previousPing);
            if (!empty($dealersAfterGivenDatetime)) {
                $this->addCustomerMessage($custEmail, '543', '`541` ' . count($dealersAfterGivenDatetime) . '`542`', 1, 'attention');
            }
        }

        //alert to admin if dollar rate doeasn't match to config rate
        if ($userLevel === UserGroups::$ADMIN) {
            $cbaRatesManager = CbaRatesManager::getInstance();
            $latestUSDExchange = $cbaRatesManager->getLatestUSDExchange();
            $us_dollar_exchange = floatval($this->getCmsVar('us_dollar_exchange'));
            $us_dollar_exchange_down = floatval($this->getCmsVar('us_dollar_exchange_down'));
            $pcstoreAverageUSDExchange = ($us_dollar_exchange + $us_dollar_exchange_down) / 2;
            $maxAllowedDollarDifferenceParcent = floatval($this->getCmsVar('admin_alert_if_cba_dollar_rate_is_more_than_percent'));
            if (abs($latestUSDExchange - $pcstoreAverageUSDExchange) / $latestUSDExchange > $maxAllowedDollarDifferenceParcent / 100) {
                $this->addCustomerMessage($custEmail, '483', 'Cba rate for USD Dollar ($) is: ' . $latestUSDExchange, 1, 'warning');
            }
        }

        //new added bonuses to user (users only)
        if ($userLevel === UserGroups::$USER) {
            $bonusHistoryManager = BonusHistoryManager::getInstance();
            $userBonusesAfterGivenDatetime = $bonusHistoryManager->getUserBonusesAfterGivenDatetime($custDto->getId(), $previousPing);
            if (!empty($userBonusesAfterGivenDatetime)) {
                $pointSum = 0;
                foreach ($userBonusesAfterGivenDatetime as $bDto) {
                    $pointSum += intval($bDto->getPoints());
                }
                $pointSum = intval($pointSum);
                if ($pointSum > 0) {
                    $phraseId = '544';
                } else {
                    $phraseId = '548';
                }
                $this->addCustomerMessage($custEmail, '545', '`' . $phraseId . '` ' . strval(intval(abs($pointSum))) . 'դր.`542`', 1, 'attention');
            }
        }


        //new added sub users (users only)
        if ($userLevel === UserGroups::$USER) {
            $userSubUsersManager = UserSubUsersManager::getInstance();
            $rowsAddedAfterGivenDatetime = $userSubUsersManager->getRowsAddedAfterGivenDatetime($custDto->getId(), $previousPing);
            if (!empty($rowsAddedAfterGivenDatetime)) {
                $this->addCustomerMessage($custEmail, '546', strval(count($rowsAddedAfterGivenDatetime)) . ' `547`', 1, 'attention');
            }
        }

        $customerLocalEmailsManager = CustomerLocalEmailsManager::getInstance();
        $unreadEmailsCount = $customerLocalEmailsManager->getCustomerInboxUnreadEmailsCountCustomerEmail($custEmail);
        if ($unreadEmailsCount > 0) {
            $customerAlertsManager = CustomerAlertsManager::getInstance();
            $customerAlertsManager->addUnreadEmailsCustomerAlert($custEmail, $unreadEmailsCount);
        }
    }

}

?>