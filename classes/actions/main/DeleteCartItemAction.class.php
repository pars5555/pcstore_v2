<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");

/**
 * @author Vahagn Sookiasian
 * @site http://naghashyan.com
 * @mail vahagnsookaisyan@gmail.com
 * @year 2010-2012
 */
class DeleteCartItemAction extends GuestAction {

    public function service() {
        $id = $this->secure($_REQUEST['id']);
        $customerCartManager = CustomerCartManager::getInstance();
        $customerCartManager->deleteCartElement($id);
        $this->redirect('cart');
    }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}

?>