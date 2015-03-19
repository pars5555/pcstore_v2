<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/BannersMapper.class.php");

/**
 * CategoryManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class BannersManager extends AbstractManager {

    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
     *
     * @param object $config
     * @param object $args
     * @return
     */
    function __construct() {
        $this->mapper = BannersMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
     *
     * @param object $config
     * @param object $args
     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new BannersManager();
        }
        return self::$instance;
    }

    public function addBanner($path) {
        $bannerDto = $this->createDto();
        $bannerDto ->setPath($path);
        return $this->insertDto($bannerDto);
    }

}

?>