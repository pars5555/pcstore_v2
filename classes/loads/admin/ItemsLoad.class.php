<?php

require_once (CLASSES_PATH . "/loads/admin/BaseAdminLoad.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class ItemsLoad extends BaseAdminLoad {

    public function load() {
        $itemManager = ItemManager::getInstance();
        $companyManager = CompanyManager::getInstance();
        $allCompaniesDtos = $companyManager->getAllCompanies(true, true);
        $this->addParam('allCompaniesDtos', $allCompaniesDtos);
        $selectedCompanyDto = null;
        if (isset($this->args[0])) {
            $selectedCompanyId = intval($this->args[0]);
            $selectedCompanyDto = $companyManager->selectByPK($selectedCompanyId);
            $itemsDtos = $itemManager->getCompanyItems($selectedCompanyId, true);
            $this->addParam('itemsDtos', $itemsDtos);
            $this->addParam('itemManager', $itemManager);
        }
        $this->addParam("selectedCompanyDto", $selectedCompanyDto);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/admin/items.tpl";
    }

}

?>