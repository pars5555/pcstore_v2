<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/InvalidEmailsMapper.class.php");

/**
 * UserSubUsersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class InvalidEmailsManager extends AbstractManager {

  
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
  
     */
    function __construct() {
        $this->mapper = InvalidEmailsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new InvalidEmailsManager();
        }
        return self::$instance;
    }

    public function removeInvalidEmailsFromList($emails) {
        $selectAll = $this->selectAll();
        $invalidEmailsArray = array();
        foreach ($selectAll as $dto) {
            $invalidEmailsArray [] = trim($dto->getEmail());
        }
        return array_diff($emails, $invalidEmailsArray);
    }

}

?>