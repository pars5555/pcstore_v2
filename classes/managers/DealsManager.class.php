<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/DealsMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class DealsManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers

     * @return
     */
    function __construct() {
        $this->mapper = DealsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class

     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new DealsManager();
        }
        return self::$instance;
    }

    public function getTodayDeal() {
        return $this->mapper->getDateDailyDeal(date('Y-m-d'));
    }

    public function getAllEnableDeals() {
        $allEnableDeals = $this->mapper->getAllEnableDeals();
        $deals = array();
        foreach ($allEnableDeals as $deal) {
            $deals[$deal->getItemId()] = $deal;
        }
        return $deals;
    }

    public function getLightingDeals() {
        return $this->mapper->getDateTimeLightingDeals(date('Y-m-d H:i:s'));
    }

    public function getDealsByPromoCode($promoCode) {
        return $this->mapper->getDealsByPromoCode($promoCode);
    }

}

?>