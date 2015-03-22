<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CreditSuppliersMapper.class.php");

/**
 * OrdersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CreditSuppliersManager extends AbstractManager {

  

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        $this->mapper = CreditSuppliersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CreditSuppliersManager();
        }
        return self::$instance;
    }

    public function getAllCreditSuppliers() {
        return $this->mapper->getAllCreditSuppliers();
    }

    public function getSuppliersIdsArray($creditSuppliersDtos) {
        $ret = array();
        foreach ($creditSuppliersDtos as $csdto) {
            $ret[] = $csdto->getId();
        }
        return $ret;
    }

    public function getSuppliersDisplayNameIdsArray($creditSuppliersDtos) {
        $ret = array();
        foreach ($creditSuppliersDtos as $csdto) {
            $ret[] = $csdto->getDisplayNameId();
        }
        return $ret;
    }

    public function getCreditSuppliersInMapArrayById($creditSuppliersDtos) {
        $ret = array();
        foreach ($creditSuppliersDtos as $csdto) {
            $ret[$csdto->getId()] = $csdto;
        }
        return $ret;
    }

}

?>