
<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CbaRatesMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CbaRatesManager extends AbstractManager {

 

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        $this->mapper = CbaRatesMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CbaRatesManager();
        }
        return self::$instance;
    }

    public function addRow($datetime, $iso, $amount, $rate) {
        $dto = $this->mapper->createDto();
        $dto->setCbaDatetime($datetime);
        $dto->setIso($iso);
        $dto->setAmount($amount);
        $dto->setRate($rate);
        $dto->setDatetime(date('Y-m-d H:i:s'));
        return $this->mapper->insertDto($dto);
    }

    public function getLatestUSDExchange() {
        $this->mapper->getLatestUSDExchange();
    }

}

?>