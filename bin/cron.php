<?php

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
defined('__DIR__') or define('__DIR__', dirname(__FILE__));

$_SERVER["DOCUMENT_ROOT"] = rtrim(__DIR__, 'bin');
$_SERVER['environment'] = 'production';
require_once ($_SERVER["DOCUMENT_ROOT"] . "/conf/constants.php");
require_once (CLASSES_PATH . "/framework/DBMSFactory.class.php");
require_once (CLASSES_PATH . "/managers/OnlineUsersManager.class.php");
require_once (CLASSES_PATH . "/managers/CbaRatesManager.class.php");
require_once (CLASSES_PATH . "/managers/ReceiveEmailManager.class.php");
DBMSFactory::init();
$onlineUsersManager = new OnlineUsersManager();
$onlineUsersManager->removeTimeOutedUsers(120); //2 minutes	

$requestHistoryManager = new RequestHistoryManager();
$requestHistoryManager->removeOldRowsByDays(90); // 90 days

$rates = getCbaRates();
if ($rates !== false) {
    $datetime = $rates[1];
    $cbaRatesManager = new CbaRatesManager();
    $selectByField = $cbaRatesManager->selectByField('cba_datetime', $datetime);
    if (empty($selectByField)) {
        foreach ($rates[0] as $rate) {
            $cbaRatesManager->addRow($datetime, $rate[0], $rate[1], $rate[2]);
        }
    }
}

$receiveEmailManager = ReceiveEmailManager::getInstance();
$receiveEmailManager->checkPriceEmailsAndAddAlertsToOnlineAdmins();

/**
 * 
 * @return array(datetime, array(array(iso, amount, rate),...)) or FALSE
 */
function getCbaRates() {
    $soapClient = new SoapClient("http://api.cba.am/exchangerates.asmx?wsdl");
    $ret = array();
    try {
        $info = $soapClient->ExchangeRatesLatest();
        if (!isset($info->ExchangeRatesLatestResult) || !isset($info->ExchangeRatesLatestResult->Rates) || !isset($info->ExchangeRatesLatestResult->Rates->ExchangeRate)) {
            return false;
        }
        foreach ($info->ExchangeRatesLatestResult->Rates->ExchangeRate as $dto) {
            $ret[] = array($dto->ISO, $dto->Amount, $dto->Rate);
        }
        $currentDate = $info->ExchangeRatesLatestResult->CurrentDate;
        $date = date_create_from_format('Y-m-d\TH:i:s', $currentDate);
        if (!$date) {
            return false;
        }
        $dateStr = $date->format('Y-m-d H:i:s');
        return array($ret, $dateStr);
    } catch (SoapFault $fault) {
        return false;
    }
    unset($soapClient);
}

?>
