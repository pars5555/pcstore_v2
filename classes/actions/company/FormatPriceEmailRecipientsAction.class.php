<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyExtendedProfileManager.class.php");
require_once (CLASSES_PATH . "/managers/EmailSenderManager.class.php");
require_once (CLASSES_PATH . "/managers/UninterestingEmailsManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class FormatPriceEmailRecipientsAction extends BaseCompanyAction {

    public function service() {

        $toEmails = strtolower(trim($_REQUEST['to_emails']));
        $valid_addresses = EmailSenderManager::getEmailsFromText($toEmails);
        $uninterestingEmailsManager = UninterestingEmailsManager::getInstance($this->config, $this->args);
        $valid_addresses = $uninterestingEmailsManager->removeUninterestingEmailsFromList($valid_addresses);
        $companyExtendedProfileManager = CompanyExtendedProfileManager::getInstance($this->config, $this->args);
        $dto = $companyExtendedProfileManager->getByCompanyId($this->getUserId());
        $dto->setDealerEmails(implode(';', $valid_addresses));
        $companyExtendedProfileManager->updateByPK($dto);
        $this->ok(array("valid_email_addresses" => implode(';', $valid_addresses)));
    }

}

?>