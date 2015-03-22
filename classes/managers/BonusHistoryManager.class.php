<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/BonusHistoryMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class BonusHistoryManager extends AbstractManager {

   
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
     *
    
     * @return
     */
    function __construct() {
        $this->mapper = BonusHistoryMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
     *
   
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new BonusHistoryManager();
        }
        return self::$instance;
    }

    public function addRow($userId, $points, $description) {
        $dto = $this->mapper->createDto();
        $dto->setUserId($userId);
        $dto->setPoints($points);
        $dto->setDescription($description);
        $dto->setDatetime(date('Y-m-d H:i:s'));
        return $this->mapper->insertDto($dto);
    }

    public function getUserBonusesAfterGivenDatetime($userId, $datetime) {
        return $this->mapper->getUserBonusesAfterGivenDatetime($userId, $datetime);
    }

}

?>