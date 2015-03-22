<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class DbStructureManager {

   

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
   
     */
    function __construct() {


        $this->dbms = DBMSFactory::getDBMS();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new DbStructureManager();
        }
        return self::$instance;
    }

    public function getTablesNames() {
        $res = $this->dbms->query("SHOW TABLES");
        $tablesNamesArray = array();
        if ($res && $this->dbms->getResultCount($res) > 0) {
            $results = $this->dbms->getResultArray($res);
            foreach ($results as $result) {
                $tablesNamesArray[] = current($result);
            }
        }
        return $tablesNamesArray;
    }

    /**
     * @return array   ["Field"=> "" ,"Type"=> "", "Null"=> "YES/NO" ,"Key"=> "PRI/MUL" ,"Default"=> "NULL"/ANYVALUE ,"Extra"=> "auto_increment"] 
     */
    public function getTableColumns($tableName) {
        $res = $this->dbms->query("SHOW COLUMNS FROM `" . $tableName . "`");
        if ($res && $this->dbms->getResultCount($res) > 0) {
            return $this->dbms->getResultArray($res);
        }
        return null;
    }

}

?>