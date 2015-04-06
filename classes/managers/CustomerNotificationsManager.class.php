<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyItemCheckListManager.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/dal/dto/CustomerNotificationDto.class.php");

/**
 * CustomerAlertListManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CustomerNotificationsManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        
    }

    /**
     * Returns an singleton instance of this class
     
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CustomerNotificationsManager();
        }
        return self::$instance;
    }

    public function getCustomerNotifications($userLevel, $customer, $datetime) {
        switch ($userLevel) {
            case UserGroups::$USER:
                $notifications = $this->getUserNotifications($customer->getId(), $datetime);
                break;
            case UserGroups::$COMPANY:
                $notifications = $this->getCompanyNotifications($customer->getId(), $datetime);
                break;
            case UserGroups::$SERVICE_COMPANY:
                $notifications = $this->getServiceCompanyNotifications($customer->getId(), $datetime);
                break;
            case UserGroups::$ADMIN:
                $notifications = $this->getAdminNotifications($datetime);
                break;
            default :
                return null;
        }
        return $this->sortNotificationsByDate($notifications);
    }

    private function sortNotificationsByDate($notifications) {
        $notificationsIdDateMapArray = array();
        $notificationsMappedById = array();
        foreach ($notifications as $notification) {
            $notificationsIdDateMapArray[$notification->getId()] = $notification->getDatetime();
            $notificationsMappedById[$notification->getId()] = $notification;
        }
        asort($notificationsIdDateMapArray);
        $ret = array();
        foreach ($notificationsIdDateMapArray as $notifId => $datetime) {
            $ret [] = $notificationsMappedById[$notifId];
        }
        return $ret;
    }

    private function getUserNotifications($userId, $datetime) {
        $companyDealersManager = CompanyDealersManager::getInstance();
        $userSubUsersManager = UserSubUsersManager::getInstance();
        $userCompaniesIdsArray = $companyDealersManager->getUserCompaniesIdsArray($userId);
        $notifications = $this->getNewPricesNotifications($datetime, $userCompaniesIdsArray);
        $rowsAddedAfterGivenDatetime = $userSubUsersManager->getRowsAddedAfterGivenDatetime($userId, $datetime);
        foreach ($rowsAddedAfterGivenDatetime as $usu) {
            $datetime = $usu->getTimestamp();
            $title = $this->getPhrase(543) . ' (' . $usu->getUserName() . ' ' . $usu->getUserLastName() . ' ' . $usu->getUserEmail() . ')';
            $pageToRedirect = 'uinvite';
            $notifications[] = new CustomerNotificationDto($datetime, $title, $pageToRedirect);
        }
        return $notifications;
    }

    private function getCompanyNotifications($companyId, $datetime) {
        $notifications = $this->getNewPricesNotifications($datetime);
        $companyDealersManager = CompanyDealersManager::getInstance();
        $dealersAfterGivenDatetime = $companyDealersManager->getAfterGivenDatetime($companyId, $datetime);
        foreach ($dealersAfterGivenDatetime as $cd) {
            $datetime = $cd->getTimestamp();
            $title = $this->getPhrase(543) . ' (' . $cd->getUserName() . ' ' . $cd->getUserLastName() . ' ' . $cd->getUserEmail() . ')';
            $pageToRedirect = 'dealers';
            $notifications[] = new CustomerNotificationDto($datetime, $title, $pageToRedirect);
        }
        return $notifications;
    }

    private function getServiceCompanyNotifications($serviceCompanyId, $datetime) {
        $notifications = $this->getNewPricesNotifications($datetime);
        $companyDealersManager = ServiceCompanyDealersManager::getInstance();
        $dealersAfterGivenDatetime = $companyDealersManager->getAfterGivenDatetime($serviceCompanyId, $datetime);
        foreach ($dealersAfterGivenDatetime as $cd) {
            $datetime = $cd->getTimestamp();
            $title = $this->getPhrase(543) . ' (' . $cd->getUserName() . ' ' . $cd->getUserLastName() . ' ' . $cd->getUserEmail() . ')';
            $pageToRedirect = 'scdealers';
            $notifications[] = new CustomerNotificationDto($datetime, $title, $pageToRedirect);
        }
        return $notifications;
    }

    private function getAdminNotifications($datetime) {
        $notifications = $this->getNewPricesNotifications($datetime);
        $serviceCompanyDealersManager = ServiceCompanyDealersManager::getInstance();
        $userSubUsersManager = UserSubUsersManager::getInstance();
        $companyDealersManager = CompanyDealersManager::getInstance();

        $companyDealers = $companyDealersManager->getAfterGivenDatetime(0, $datetime);
        foreach ($companyDealers as $cd) {
            $datetime = $cd->getTimestamp();
            $title = $this->getPhrase(543) . ' (' . $cd->getUserEmail() . '=>' . $cd->getCompanyName() . ')';
            $pageToRedirect = 'admin';
            $notifications[] = new CustomerNotificationDto($datetime, $title, $pageToRedirect);
        }

        $serviceCompanyDealers = $serviceCompanyDealersManager->getAfterGivenDatetime(0, $datetime);
        foreach ($serviceCompanyDealers as $cd) {
            $datetime = $cd->getTimestamp();
            $title = $this->getPhrase(543) . ' (' . $cd->getUserEmail() . '=>' . $cd->getCompanyName() . ')';
            $pageToRedirect = 'admin';
            $notifications[] = new CustomerNotificationDto($datetime, $title, $pageToRedirect);
        }


        $rowsAddedAfterGivenDatetime = $userSubUsersManager->getRowsAddedAfterGivenDatetime(0, $datetime);
        foreach ($rowsAddedAfterGivenDatetime as $usu) {
            $datetime = $usu->getTimestamp();
            $title = $this->getPhrase(546) . ' (' . $usu->getUserEmail() . ')';
            $pageToRedirect = 'admin';
            $notifications[] = new CustomerNotificationDto($datetime, $title, $pageToRedirect);
        }
        return $notifications;
    }

    private function getNewPricesNotifications($datetime, $companiesIds = null) {
        $companiesPriceListManager = CompaniesPriceListManager::getInstance();
        $last24HoursPrices = $companiesPriceListManager->getAllPricesAfterTime($datetime, $companiesIds);
        $customerNotificationsDtos = array();
        foreach ($last24HoursPrices as $cpl) {
            $datetime = $cpl->getUploadDateTime();
            $title = $this->getPhrase(482) . ' (' . $cpl->getCompanyName() . ')';
            $pageToRedirect = 'companies';
            $iconUrl = HTTP_PROTOCOL . HTTP_HOST . '/images/small_logo/' . $cpl->getCompanyId();
            $customerNotificationsDtos[] = new CustomerNotificationDto($datetime, $title, $pageToRedirect, $iconUrl);
        }
        return $customerNotificationsDtos;
    }

}

?>