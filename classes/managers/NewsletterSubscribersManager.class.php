<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/NewsletterSubscribersMapper.class.php");

/**
 * UserSubUsersManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class NewsletterSubscribersManager extends AbstractManager {

    /**
     * @var app config
     */
    private $config;

    /**
     * @var passed arguemnts
     */
    private $args;

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
        $this->mapper = NewsletterSubscribersMapper::getInstance();
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

            self::$instance = new NewsletterSubscribersManager();
        }
        return self::$instance;
    }

    public function removeSubscriberEmail($email) {
        $this->deleteByField('email', trim($email));
    }

    public function addSubscriber($email) {
        $dto = $this->mapper->createDto();
        $dto->setEmail($email);
        return $this->mapper->insertDto($dto);
    }

    public function getAllSubscribers() {
        $dtos = $this->selectAll();
        $ret = array();
        foreach ($dtos as $dto) {
            $ret[] = $dto->getEmail();
        }
        return $ret;
    }

}

?>