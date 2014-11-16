<?php

require_once (FRAMEWORK_PATH . "/dal/dto/AbstractDto.class.php");

/**
 * CategoryHierarchyDto class is extended class from AbstractDto.
 *
 * @author	Vahagn Sookiasian
 */
class SmsGatewayDto extends AbstractDto {

    // Map of DB value to Field value
    protected $mapArray = array("id" => "id", "name" => "name", "international_code_prefix" => "internationalCodePrefix",
        "settings_metadata" => "settingsMetadata", "http_sms_url" => "httpSmsUrl");

    // constructs class instance
    public function __construct() {
        
    }

    // returns map array
    public function getMapArray() {
        return $this->mapArray;
    }

}

?>
