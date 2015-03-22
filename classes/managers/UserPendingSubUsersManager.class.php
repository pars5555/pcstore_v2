<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/UserPendingSubUsersMapper.class.php");

/**
 * UserPendingSubUsersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class UserPendingSubUsersManager extends AbstractManager {


    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
    
     */
    function __construct() {
        $this->mapper = UserPendingSubUsersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new UserPendingSubUsersManager();
        }
        return self::$instance;
    }

    public function getByUserIdOrderByDate($userId) {
        return $this->mapper->getByUserIdOrderByDate($userId);
    }

    public function getByUserIdAndPendingSubUserEmail($userId, $pendingUserEmail) {
        return $this->mapper->getByUserIdAndPendingSubUserEmail($userId, $pendingUserEmail);
    }

    public function removePendingSubUserFromUser($userId, $pendingUserEmail) {
        $dto = $this->getByUserIdAndPendingSubUserEmail($userId, $pendingUserEmail);
        if ($dto) {
            $this->mapper->deleteByPK($dto->getId());
            return true;
        }
        return false;
    }

    public function addPendingSubUserEmailToUser($pendingUserEmail, $userId) {
        $dto = $this->getByUserIdAndPendingSubUserEmail($userId, $pendingUserEmail);
        if (!$dto) {
            $dto = $this->mapper->createDto();
            $dto->setUserId($userId);
            $dto->setPendingSubUserEmail($pendingUserEmail);
            $dto->setLastSent(date('Y-m-d H:i:s'));
            $dto->setTimestamp(date('Y-m-d H:i:s'));
            $this->mapper->insertDto($dto);
            return true;
        }
        return false;
    }

}

?>