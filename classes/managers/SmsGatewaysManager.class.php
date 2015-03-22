<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/SmsGatewaysMapper.class.php");

/**
 * CategoryHierarchyManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class SmsGatewaysManager extends AbstractManager {

 
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
  
     */
    function __construct() {
        $this->mapper = SmsGatewaysMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new SmsGatewaysManager();
        }
        return self::$instance;
    }

    public function getByName($name) {
        $dtos = $this->selectByField('name', $name);
        if (count($dtos) === 1) {
            return $dtos[0];
        }
        return null;
    }

}

?>