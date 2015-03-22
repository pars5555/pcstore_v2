
<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");

/**
 * AdminManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class GalleryManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
  
     * @return
     */
    function __construct() {
        
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new GalleryManager();
        }
        return self::$instance;
    }

    //public function load
}

?>