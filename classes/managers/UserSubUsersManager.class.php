<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/UserSubUsersMapper.class.php");

/**
 * UserSubUsersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class UserSubUsersManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
   
     * @return
     */
    function __construct() {
        $this->mapper = UserSubUsersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
     
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new UserSubUsersManager();
        }
        return self::$instance;
    }

    public function getUserSubUsers($userId) {
        return $this->mapper->getUserSubUsers($userId);
    }

    public function removeSubUserFromUser($subUserId, $userId) {
        $dto = $this->getByUserIdAndSubUserId($userId, $subUserId);
        if ($dto) {
            $this->mapper->deleteByPK($dto->getId());
            return true;
        }
        return false;
    }

    public function addSubUserToUser($subUserId, $userId) {
        $dto = $this->getByUserIdAndSubUserId($userId, $subUserId);
        if (!$dto) {
            $dto = $this->mapper->createDto();
            $dto->setUserId($userId);
            $dto->setSubUserId($subUserId);
            $dto->setTimestamp(date('Y-m-d H:i:s'));
            $this->mapper->insertDto($dto);
            return true;
        }
        return false;
    }

    public function getByUserIdAndSubUserId($userId, $subUserId) {

        return $this->mapper->getByUserIdAndSubUserId($userId, $subUserId);
    }

    public function getUserParentId($subUserId) {
        $dto = $this->mapper->getUserParentId($subUserId);
        if ($dto) {
            return $dto->getUserId();
        } else {
            return 0;
        }
    }

    public function getRowsAddedAfterGivenDatetime($userId, $datetime) {
        return $this->mapper->getRowsAddedAfterGivenDatetime($userId, $datetime);
    }

}

?>