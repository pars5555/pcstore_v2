<?php

require_once (CLASSES_PATH . "/actions/user/BaseUserAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyManager.class.php");
require_once (CLASSES_PATH . "/managers/CompanyDealersManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class RegisterCompanyDealerAction extends BaseUserAction {

    public function service() {
        $userManager = new UserManager();
        $companyManager = new CompanyManager();
        $companyDealersManager = new CompanyDealersManager();
        $access_key = $userManager->secure($_REQUEST["access_key"]);
        $company = $companyManager->getCompanyByAccessKey($access_key);
        if (isset($company)) {
            $userId = $this->getUserId();
            $companyId = $company->getId();

            if (!$companyDealersManager->getByCompanyIdAndUserId($userId, $companyId)) {
                $customer = $this->getCustomer();
                $customerEmail = $customer->getEmail();
                $customerCartManager = CustomerCartManager::getInstance();
                $items = $customerCartManager->getCustomerItemsByCompanyId($customerEmail, $companyId);
                $bundlesIds = $customerCartManager->getCustomerBundlesIdsByCompanyId($customerEmail, $companyId);
                $customerCartManager->deleteCompanyRelatedItemsFromCustomerCart($customerEmail, $companyId);
                $companyDealersManager->addUserToCompany($userId, $companyId);
                $message = $this->getPhrase(437) . ' ' . $company->getName() . "'! \n";
                if (!empty($items)) {
                    $message .= $this->getPhrase(436) . "'\n";
                }
                if (!empty($bundlesIds)) {
                    $message .= $this->getPhrase(435);
                }
                $jsonArr = array('status' => "ok", "message" => $message);
                echo json_encode($jsonArr);
                return true;
            } else {
                $jsonArr = array('status' => "err", "message" => "You already have '" . $company->getName() . "' company in your list!");
                echo json_encode($jsonArr);
                return false;
            }
        } else {
            $jsonArr = array('status' => "err", "message" => "Access key incorrect!");
            echo json_encode($jsonArr);
            return false;
        }
    }

}

?>