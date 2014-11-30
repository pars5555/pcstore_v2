<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");

/**
 * @author Vahagn Sookiasian
 * @site http://naghashyan.com
 * @mail vahagnsookaisyan@gmail.com
 * @year 2010-2012
 */
class SetCartItemCountAction extends GuestAction {

    public function service() {
        $customerCartManager = CustomerCartManager::getInstance();
        if (isset($_REQUEST['id']) && isset($_REQUEST['count'])) {
            $cartItemId = $this->secure($_REQUEST['id']);
            $cartItemCount = intval($this->secure($_REQUEST['count']));
            if ($cartItemCount > 0) {
                $customerCartManager->setCartElementCount($cartItemId, $cartItemCount);
            }
        }
        $this->redirect('cart');
        }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}

?>