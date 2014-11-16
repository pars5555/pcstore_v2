<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class ChangeServiceCompanyBlockHasPriceAttributesAction extends BaseAdminAction {

    public function service() {

        $serviceCompanyManager = new ServiceCompanyManager();
        $serviceCompanyId = $this->secure($_REQUEST["company_id"]);
        if (isset($_REQUEST['has_price'])) {
            $has_price = intval($_REQUEST['has_price']);
            $serviceCompanyManager->updateTextField($serviceCompanyId, 'has_price', $has_price);
            $_SESSION['success_message'] = "Company is now " . ($has_price == 1 ? 'hidden' : 'visible');
        }
        if (isset($_REQUEST['blocked'])) {
            $blocked = intval($_REQUEST['blocked']);
            $serviceCompanyManager->updateTextField($serviceCompanyId, 'blocked', $blocked);
            $_SESSION['success_message'] = "Company is now " . ($blocked == 1 ? 'blocked' : 'unblocked');
        }
        $this->redirect('admin/scompanies/' . $serviceCompanyId);
    }

}

?>