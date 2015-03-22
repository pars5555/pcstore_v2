<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/EmailAccountsMapper.class.php");

/**
 * CategoryHierarchyManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class EmailAccountsManager extends AbstractManager {

 

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     * @return
     */
    function __construct() {
        $this->mapper = EmailAccountsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
  
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new EmailAccountsManager();
        }
        return self::$instance;
    }

    public function getEmailAccountsIds() {
        $ret = array();
        $allDtos = $this->mapper->selectAll();
        foreach ($allDtos as $dto) {
            $ret[] = $dto->getId();
        }
        return $ret;
    }

    public function getEmailAddressById($id) {
        $dto = $this->mapper->selectByPK($id);
        if (isset($dto)) {
            return $dto->getLogin();
        }
        return '';
    }

}

?>