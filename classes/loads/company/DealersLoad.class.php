<?php

require_once (CLASSES_PATH . "/loads/company/BaseCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class DealersLoad extends BaseCompanyLoad {

    public function load() {
        
        $companyDealersManager = CompanyDealersManager::getInstance();
        $companyId = $this->getUserId();
        $dealers = $companyDealersManager->getCompanyDealersJoindWithUsersFullInfo($companyId);
        $this->addParam('dealers', $dealers);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/company/dealers.tpl";
    }

}

?>