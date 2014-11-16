<?php

require_once (CLASSES_PATH . "/loads/company/BaseCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ProfileLoad extends BaseCompanyLoad {

    public function load() {
        
        $companyManager = CompanyManager::getInstance();
        $userId = $this->getUserId();
        $customer = $this->getCustomer();
        $userPhonesArray = $customer->getUserPhonesArray($userId);
        $this->addParam("phones", $userPhonesArray);
        $regions_phrase_ids_array = explode(',', $this->getCmsVar('armenia_regions_phrase_ids'));
        $this->addParam('regions_phrase_ids_array', $regions_phrase_ids_array);
        $region = $customer->getRegion();
        $this->addParam('region_selected', $region);
        $this->addParam('userManager', $companyManager);
        if (file_exists(DATA_IMAGE_DIR . '/company_logo/company_' . $userId . '_logo_120_75.png')) {
            $this->addParam('hasLogo', 1);
        }
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/company/profile.tpl";
    }

}

?>