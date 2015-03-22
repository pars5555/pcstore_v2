<?php

require_once (FRAMEWORK_PATH . "/AbstractManager.class.php");
require_once (CLASSES_PATH . "/dal/mappers/PaypalTransactionsMapper.class.php");

/**
 * PaypalTransactionsManager class is responsible for creating,
 *
 * @author Vahagn Sookiasian
 * @package managers
 * @version 1.0
 */
class PaypalTransactionsManager extends AbstractManager {

  
    /**
     * @var singleton instance of class
     */
    private static $instance = null;

    /**
     * Initializes DB mappers
     
     */
    function __construct() {
        $this->mapper = PaypalTransactionsMapper::getInstance();
    }

    /**
     * Returns an singleton instance of this class
    
     */
    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new PaypalTransactionsManager();
        }
        return self::$instance;
    }

    public function setOrderPaymentError($orderId, $message) {
        $dtos = $this->selectByField('order_id', $orderId);
        if (empty($dtos)) {
            $dto = $this->createDto();
            $dto->setOrderId($orderId);
            $dto->setPaymentReceived(0);
            $dto->setMessage($message);
            $this->insertDto($dto);
        } else {
            $dto = $dtos[0];
            $dto->setOrderId($orderId);
            $dto->setPaymentReceived(0);
            $dto->setMessage($message);
            $this->updateByPk($dto);
        }
    }

    public function setOrderCompleted($orderId) {
        $dtos = $this->selectByField('order_id', $orderId);
        if (empty($dtos)) {
            $dto = $this->createDto();
            $dto->setOrderId($orderId);
            $dto->setPaymentReceived(1);
            $dto->setMessage('');
            $this->insertDto($dto);
        } else {
            $dto = $dtos[0];
            $dto->setOrderId($orderId);
            $dto->setPaymentReceived(1);
            $dto->setMessage('');
            $this->updateByPk($dto);
        }
    }

}

?>