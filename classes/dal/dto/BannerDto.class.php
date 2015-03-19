<?php

require_once (FRAMEWORK_PATH . "/dal/dto/AbstractDto.class.php");

/**
 * AdminDto class is extended class from AbstractDto.
 *
 * @author	Vahagn Sookiasian
 */
class BannerDto extends AbstractDto {

    // Map of DB value to Field value
    protected $mapArray = array(
        "id" => "id",
        "path" => "path",
        "active" => "active"
    );

    // constructs class instance
    public function __construct() {
        
    }

    // returns map array
    public function getMapArray() {
        return $this->mapArray;
    }

}

?>
