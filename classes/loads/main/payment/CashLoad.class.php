<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CashLoad extends BaseUserCompanyLoad {

    public function load() {
        $ship_params = json_decode($_REQUEST["ship_params"]);
        $do_shipping = $_REQUEST["do_shipping"];
        $this->addParam("do_shipping", $do_shipping);
        if ($do_shipping == 1) {
            $this->addParam("recipientName", $ship_params->recipientName);
            $this->addParam("shipAddr", $ship_params->shipAddr);
            $this->addParam("shippingRegion", $ship_params->shippingRegion);
            $this->addParam("shipCellTel", $ship_params->shipCellTel);
            $this->addParam("shipTel", $ship_params->shipTel);
        }
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/payment/cash.tpl";
    }

}

?>