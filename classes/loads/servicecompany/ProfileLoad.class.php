<?php

require_once (CLASSES_PATH . "/loads/servicecompany/BaseServiceCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ProfileLoad extends BaseServiceCompanyLoad {

    public function load() {

        $userId = $this->getUserId();
        $customer = $this->getCustomer();
        $userPhonesArray = $customer->getUserPhonesArray($userId);
        $this->addParam("phones", $userPhonesArray);
        if (file_exists(DATA_IMAGE_DIR . '/service_company_logo/service_company_' . $userId . '_logo_120_75.png')) {
            $this->addParam('hasLogo', 1);
        }
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/servicecompany/profile.tpl";
    }

}

?>