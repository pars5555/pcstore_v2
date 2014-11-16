<?php

require_once (CLASSES_PATH . "/actions/user/BaseUserAction.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class AddToCartAction extends BaseUserAction {

    public function service() {
        $customer = $this->getCustomer();
        $customerEmail = strtolower($customer->getEmail());
        $customerCartManager = CustomerCartManager::getInstance();

        $add_count = 1;
        if (isset($_REQUEST['add_count'])) {
            $add_count = intval($this->secure($_REQUEST['add_count']));
        }

        if (isset($_REQUEST['item_id'])) {
            $item_id = $this->secure($_REQUEST['item_id']);
        }

        $itemManager = ItemManager::getInstance();
        if (isset($item_id)) {
            $itemDto = $itemManager->selectByPK($item_id);
            if (!isset($itemDto)) {
                $_SESSION['error_message'] = "Item is no more available!";
                $this->redirect('cart');
            }
            $last_dealer_price = $itemDto->getDealerPrice();
        }
        $customerCartManager->addToCart($customerEmail, $item_id, 0, $last_dealer_price, $add_count);
        $this->redirect('cart');
    }

}

?>