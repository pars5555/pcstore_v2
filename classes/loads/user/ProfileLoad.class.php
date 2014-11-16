<?php

require_once (CLASSES_PATH . "/loads/user/BaseUserLoad.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ProfileLoad extends BaseUserLoad {

    public function load() {
        $userManager = UserManager::getInstance();
        $userId = $this->getUserId();
        $customer = $this->getCustomer();
        $userPhonesArray = $userManager->getUserPhonesArray($userId);
        $this->addParam("phones", $userPhonesArray);
        $regions_phrase_ids_array = explode(',', $this->getCmsVar('armenia_regions_phrase_ids'));
        $this->addParam('regions_phrase_ids_array', $regions_phrase_ids_array);
        $region = $customer->getRegion();
        $this->addParam('region_selected', $region);
        $this->addParam('userManager', $userManager);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/user/profile.tpl";
    }

}

?>