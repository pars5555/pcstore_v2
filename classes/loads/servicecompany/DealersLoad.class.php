<?php

require_once (CLASSES_PATH . "/loads/servicecompany/BaseServiceCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyDealersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class DealersLoad extends BaseServiceCompanyLoad {

    public function load() {
        
        $serviceCompanyDealersManager = ServiceCompanyDealersManager::getInstance();
        $companyId = $this->getUserId();
        $dealers = $serviceCompanyDealersManager->getCompanyDealersJoindWithUsersFullInfo($companyId);
        $this->addParam('dealers', $dealers);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/company/dealers.tpl";
    }

}

?>