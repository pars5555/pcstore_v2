<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/ReferersMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class ReferersManager extends AbstractManager {

  
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
   
     */
    function __construct() {
        $this->mapper = ReferersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new ReferersManager();
        }
        return self::$instance;
    }

    public function addRow($refererUrl, $requestUrl) {
        $dto = $this->mapper->createDto();
        $dto->setReferer($refererUrl);
        $dto->setRequestedUrl($requestUrl);
        $dto->setIp($_SERVER["REMOTE_ADDR"]);
        $dto->setDatetime(date('Y-m-d H:i:s'));
        $this->mapper->insertDto($dto);
    }

}

?>