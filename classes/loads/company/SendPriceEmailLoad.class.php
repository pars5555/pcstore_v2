<?php

require_once (CLASSES_PATH . "/loads/company/BaseCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyExtendedProfileManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailServersManager.class.php");

/**
 *
 * @author Vahagn Sookiasian
 *
 */
class SendPriceEmailLoad extends BaseCompanyLoad {

    public function load() {    
        $companyId = $this->getUserId();
        $selectedCompanyId = $companyId;
        $companyExtendedProfileManager = CompanyExtendedProfileManager::getInstance();
        $dto = $companyExtendedProfileManager->getByCompanyId($companyId);
        if (!isset($dto)) {
            $companyExtendedProfileManager->createDefaultExCompanyProfile($companyId);
        }
        $dto = $companyExtendedProfileManager->getByCompanyId($companyId);
        $this->addParam("companyExProfileDto", $dto);
        $dealerEmails = trim($dto->getDealerEmails());
        $this->addParam("total_price_email_recipients_count", empty($dealerEmails) ? 0 : count(explode(';', $dealerEmails)));
        array_map('unlink', glob(HTDOCS_TMP_DIR_ATTACHMENTS . "/companies/" . $companyId . "/*"));
        
        $this->addParam("selectedCompanyId", $selectedCompanyId);
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/company/send_price_email.tpl";
    }

}

?>