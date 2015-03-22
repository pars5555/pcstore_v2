<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/DiscountPromoCodesMapper.class.php");

/**
 * OrdersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class DiscountPromoCodesManager extends AbstractManager {



    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
   
     * @return
     */
    function __construct() {
        $this->mapper = DiscountPromoCodesMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new DiscountPromoCodesManager();
        }
        return self::$instance;
    }

    public function getByPromoCode($promoCode) {
        $dtos = $this->selectByField('code', $promoCode);
        if (count($dtos) === 1) {
            return $dtos[0];
        }
        return null;
    }

}

?>