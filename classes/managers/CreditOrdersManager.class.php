<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CreditOrdersMapper.class.php");

/**
 * OrdersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CreditOrdersManager extends AbstractManager {


    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        $this->mapper = CreditOrdersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CreditOrdersManager();
        }
        return self::$instance;
    }

    public function addCreditOrder($orderId, $deposit, $credit_supplier_id, $credit_months, $annualInterestPercent, $creditMonthlyPayment) {
        $this->mapper->insertValues(array('order_id', 'deposit', 'credit_supplier_id', 'credit_months', 'annual_interest_percent', 'monthly_payment'), array($orderId, $deposit, $credit_supplier_id, $credit_months, $annualInterestPercent, $creditMonthlyPayment));
    }

}

?>