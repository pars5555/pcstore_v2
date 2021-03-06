<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/EmailServersMapper.class.php");

/**
 * CategoryHierarchyManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class EmailServersManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
   
     * @return
     */
    function __construct() {
        $this->mapper = EmailServersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
   
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new EmailServersManager();
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