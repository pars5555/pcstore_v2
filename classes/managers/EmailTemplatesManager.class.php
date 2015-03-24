<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");

/**
 * CategoryHierarchyManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class EmailTemplatesManager extends AbstractManager {

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

     * @return
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new EmailTemplatesManager();
        }
        return self::$instance;
    }

    public function getTemplate($templateName) {
        return file_get_contents(DATA_EMAIL_TEMPLATES_DIR . "/" . $templateName . ".tpl");
    }

}

?>