<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/UninterestingEmailsMapper.class.php");

/**
 * UserSubUsersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class UninterestingEmailsManager extends AbstractManager {

  
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
  
     */
    function __construct() {
        $this->mapper = UninterestingEmailsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new UninterestingEmailsManager();
        }
        return self::$instance;
    }

    public function removeUninterestingEmailsFromList($emails) {
        $selectAll = $this->selectAll();
        $uninterestingEmailsArray = array();
        foreach ($selectAll as $dto) {
            $uninterestingEmailsArray [] = trim($dto->getEmail());
        }
        return array_diff($emails, $uninterestingEmailsArray);
    }

}

?>