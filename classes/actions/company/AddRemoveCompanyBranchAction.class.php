<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompanyBranchesManager.class.php");

/**
 * @author Vahagn Sookiasyan
 */
class AddRemoveCompanyBranchAction extends BaseCompanyAction {

    public function service() {
        $action = $_REQUEST['action'];
        $companyBranchesManager = CompanyBranchesManager::getInstance();

        if ($action == 'add') {
            $branch_address = $this->secure($_REQUEST['branch_address']);
            $branch_region = $this->secure($_REQUEST['branch_region']);
            $branch_zip = $this->secure($_REQUEST['branch_zip']);
            if (empty($branch_address)) {
                $_SESSION['error_message'] = $this->getPhrase(677);
                $this->redirect("branches");
            }
            $br_id = $companyBranchesManager->addBranch($this->getUserId(), $branch_address, strtolower($branch_region), $branch_zip);
            $this->redirect("branches/" . $br_id);
        }
        if ($action == 'delete') {
            $branch_id = $this->secure($_REQUEST['branch_id']);
            $companyBranchesManager->deleteByPK($branch_id);
        }
        $this->redirect("branches");
    }

}

?>