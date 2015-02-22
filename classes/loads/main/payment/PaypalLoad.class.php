<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class PaypalLoad extends BaseUserCompanyLoad {

    public function load() {
        
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/payment/paypal.tpl";
    }

}

?>