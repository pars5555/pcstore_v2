<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ChangeCompanyHiddenBlockAttributesAction extends BaseAdminAction {

    public function service() {

        $companyManager = new CompanyManager();
        $companyId = $this->secure($_REQUEST["company_id"]);
        if (isset($_REQUEST['hidden'])) {
            $hidden = intval($_REQUEST['hidden']);
            $companyManager->updateTextField($companyId, 'hidden', $hidden);
            $_SESSION['success_message'] = "Company is now " . ($hidden == 1 ? 'hidden' : 'visible');
        }
        if (isset($_REQUEST['blocked'])) {
            $blocked = intval($_REQUEST['blocked']);
            $companyManager->updateTextField($companyId, 'blocked', $blocked);
            $_SESSION['success_message'] = "Company is now " . ($blocked == 1 ? 'blocked' : 'unblocked');
        }
        if (isset($_REQUEST['passive'])) {
            $passive = intval($_REQUEST['passive']);
            $companyManager->updateTextField($companyId, 'passive', $passive);
            $_SESSION['success_message'] = "Company is now " . ($passive == 1 ? 'passive' : 'active');
        }

        $this->redirect('admin/companies/' . $companyId);
    }

}

?>