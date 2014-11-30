<?php
require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/ServiceCompanyManager.class.php");

/**
 * @author Vahagn Sookiasian
 * @site http://naghashyan.com
 * @mail vahagnsookaisyan@gmail.com
 * @year 2010-2012
 */
class SetCustomerCartIncludedVatAction extends GuestAction {

    public function service() {
        $include_vat = intval($_REQUEST['include_vat']);

        switch ($this->getUserLevel()) {
            case UserGroups::$USER:
                $userManager = UserManager::getInstance();
                $userManager->updateNumericField($this->getUserId(), 'cart_included_vat', $include_vat);
                break;
            case UserGroups::$COMPANY:
                $companyManager = CompanyManager::getInstance();
                $companyManager->updateNumericField($this->getUserId(), 'cart_included_vat', $include_vat);
                break;
            case UserGroups::$SERVICE_COMPANY:
                $seriveCompanyManager = ServiceCompanyManager::getInstance();
                $seriveCompanyManager->updateNumericField($this->getUserId(), 'cart_included_vat', $include_vat);
                break;
        }

        $this->redirect('cart');
    }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}

?>