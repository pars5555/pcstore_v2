<?php

require_once (CLASSES_PATH . "/actions/company/BaseCompanyAction.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");
require_once (CLASSES_PATH . "/managers/RequestHistoryManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class RevertCompanyLastPriceAction extends BaseCompanyAction {

    public function service() {
        $userLevel = $this->getUserLevel();
        if ($userLevel === UserGroups::$ADMIN) {
            $companyId = $this->secure($_REQUEST["company_id"]);
        } else if ($userLevel === UserGroups::$COMPANY) {
            $companyId = $this->getUserId();
        }

        if ($this->getUserLevel() === UserGroups::$COMPANY) {
            $requestHistoryManager = RequestHistoryManager::getInstance();
            $customerGivenRequestRecentCountByHours = $requestHistoryManager->getCustomerGivenRequestRecentCountByHours($this->getCustomerLogin(), 24, get_class());
            if ($customerGivenRequestRecentCountByHours > intval($this->getCmsVar('company_revert_price_limit'))) {
                $jsonArr = array('status' => "err", "errText" => $this->getPhrase(557) . ' ' . intval($this->getCmsVar('company_revert_price_limit')));
                echo json_encode($jsonArr);
                return false;
            }
        }


        $companiesPriceListManager = CompaniesPriceListManager::getInstance();
        $ret = $companiesPriceListManager->removeCompanyLastPrice($companyId);


        if ($ret > 0) {
            $jsonArr = array('status' => "ok");
            echo json_encode($jsonArr);
            return true;
        } else {
            switch ($ret) {
                case -1:
                    $errMessage = "Price doesn't exist!";
                    break;

                default:
                    $errMessage = "You can not revert the price file! You have only 1 price file on pcstore.";
                    break;
            }

            $jsonArr = array('status' => "err", "errText" => "System Error: " . $errMessage);
            echo json_encode($jsonArr);
            return false;
        }
    }

}

?>