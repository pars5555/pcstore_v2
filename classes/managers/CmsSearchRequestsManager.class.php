<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/CmsSearchRequestsMapper.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class CmsSearchRequestsManager extends AbstractManager {

 
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers    
     * @return
     */
    function __construct() {
        $this->mapper = CmsSearchRequestsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
  
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new CmsSearchRequestsManager();
        }
        return self::$instance;
    }

    public function emptyTable() {
        return $this->mapper->emptyTable();
    }

    public function addRow($searchText, $datetime, $win_uid) {
        $dto = $this->mapper->createDto();
        $dto->setSearchText($searchText);
        $dto->setDatetime($datetime);
        $dto->setWinUid($win_uid);
        return $this->mapper->insertDto($dto);
    }

    public function getSearchStatisticsByDays($daysNumber) {
        return $this->mapper->getSearchStatisticsByDays($daysNumber);
    }

    public function removeOldRowsByDays($days) {
        $this->mapper->removeOldRowsByDays($days);
    }

}

?>