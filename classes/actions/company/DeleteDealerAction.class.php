<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class DeleteDealerAction extends BaseCompanyAction {

    public function service() {
        $companyDealersManager = new CompanyDealersManager();
        $userId = $companyDealersManager->secure($_REQUEST["user_id"]);
        $companyId = $this->getUserId();
        $byCompanyIdAndUserId = $companyDealersManager->getByCompanyIdAndUserId($userId, $companyId);
        if (isset($byCompanyIdAndUserId)) {
            $_SESSION['success_message'] = $this->getPhrase(654);
            $companyDealersManager->removeUserFromCompany($userId, $companyId);
        }
        $this->redirect('dealers');
    }

}

?>