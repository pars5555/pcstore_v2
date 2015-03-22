<?php

require_once (CLASSES_PATH . "/actions/admin/BaseAdminAction.class.php");
require_once (CLASSES_PATH . "/managers/AdminManager.class.php");
require_once (CLASSES_PATH . "/managers/CompaniesPriceListManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class RemoveCompanyPriceAction extends BaseAdminAction {

    public function service() {
        $companiesPriceListManager = CompaniesPriceListManager::getInstance();
        $userLevel = $this->getUserLevel();
        $price_id = $this->secure($_REQUEST["price_id"]);
        $priceCompanyId = $companiesPriceListManager->removeCompanyPrice($price_id);
        if ($realCompanyId > 0) {
            $this->redirect('admin/uploadprice/' . $priceCompanyId);
        } else {
            $this->redirect('admin/uploadprice');
        }
    }

}

?>