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
                $this->error(array('errMsg' => 'Branch address is empty!'));
            }
            if ($this->getUserLevel() !== UserGroups::$COMPANY) {
                $this->error(array('errMsg' => 'System Error: this action is for only companies!'));
            }
            $br_id = $companyBranchesManager->addBranch($this->getUserId(), $branch_address, strtolower($branch_region), $branch_zip);
        }
        if ($action == 'delete') {
            $branch_id = $this->secure($_REQUEST['branch_id']);
            $companyBranchesManager->deleteByPK($branch_id);
        }
        $this->redirect("branches/".$br_id);
    }

}

?>