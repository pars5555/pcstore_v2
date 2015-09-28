<?php

ini_set('display_errors', false);

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
defined('__DIR__') or define('__DIR__', dirname(__FILE__));
$_SERVER["DOCUMENT_ROOT"] = rtrim(__DIR__, 'util/\\classes');
ini_set('memory_limit', '4G');

require_once($_SERVER["DOCUMENT_ROOT"] . "/conf/constants.php");
require_once(CLASSES_PATH . "/framework/Dispatcher.class.php");
require_once(CLASSES_PATH . "/loads/LoadMapper.class.php");
require_once(CLASSES_PATH . "/framework/DBMSFactory.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");

$_SERVER['environment'] = $argv[3];
DBMSFactory::init();

$companiesPriceListManager = CompaniesPriceListManager::getInstance();
$companyIds = $argv[1];
$priceIndex = 0;
if (isset($argv[2])) {
    $priceIndex = $argv[2];
}
$companyIdsArray = explode(',', $companyIds);
foreach ($companyIdsArray as $cid) {
    $companiesPriceListManager->cachePriceInTables($cid, $priceIndex);
}
?>