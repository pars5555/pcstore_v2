<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/checkout/CheckoutManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class CheckoutLoad extends BaseUserCompanyLoad {

    public function load() {

        $regions_phrase_ids_array = explode(',', $this->getCmsVar('armenia_regions_phrase_ids'));
        $this->addParam('regions_phrase_ids_array', $regions_phrase_ids_array);
        $default_selected_region = 'yerevan';
        $this->addParam('default_selected_region', $default_selected_region);
        
        
        $payment_option_values = explode(',', $this->getCmsVar('payment_option_values'));
        $payment_options_display_names_ids = explode(',', $this->getCmsVar('payment_options_display_names_ids'));
        $this->addParam('payment_options_display_names_ids', $payment_options_display_names_ids);
        $this->addParam('payment_option_values', $payment_option_values);
    }

    public function getDefaultLoads($args) {
        $loads = array();
        $loadName = "CheckoutCalculationLoad";
        $loads["calculation"]["load"] = "loads/main/" . $loadName;
        $loads["calculation"]["args"] = array();
        $loads["calculation"]["loads"] = array();
        return $loads;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/checkout.tpl";
    }

}

?>