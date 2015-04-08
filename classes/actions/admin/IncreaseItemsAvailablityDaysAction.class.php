<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/AdminManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class IncreaseItemsAvailablityDaysAction extends BaseAdminAction {

    public function service() {

        $company_id = $this->secure($_REQUEST["company_id"]);

        $itemManager = ItemManager::getInstance();
        //first set all to 1 week availability
        $itemManager->increaseCompanyExpireItemsByGivenDays($company_id, 4);
        // then set by category
        $itemManager->increaseCompanyExpireItemsByGivenDays($company_id, 2, array(CategoriesConstants::HDD_HARD_DRIVE, CategoriesConstants::CPU_PROCESSOR));
        $this->sendStockUpdatedEmailToCompany($company_id);
        $this->redirect("admin/items/" . $company_id);
        
    }

    private function sendStockUpdatedEmailToCompany($company_id) {
        $emailSenderManager = new EmailSenderManager('gmail');
        $companyManager = CompanyManager::getInstance();
        $company = $companyManager->selectByPK($company_id);
        if (isset($company) && $company->getReceiveEmailOnStockUpdate() == 1) {
            $company_email = $company->getEmail();
            $subject = $this->getPhrase(531, 'en');
            $templateId = 'company_stock_updated';
            $params = array("support_phone" => $this->getCmsVar('pcstore_support_phone_number'));
            $emailSenderManager->sendEmail('info', $company_email, $subject, $templateId, $params);
        }
    }

}

?>