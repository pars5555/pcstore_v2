<?php

require_once (CLASSES_PATH . "/loads/main/BaseUserCompanyLoad.class.php");
require_once (CLASSES_PATH . "/managers/OrdersManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");

class OrdersLoad extends BaseUserCompanyLoad {

    public function load() {
        $ordersManager = OrdersManager::getInstance();

        $customer = $this->getCustomer();
        $customerEmail = strtolower($customer->getEmail());
        $customerOrders = $ordersManager->getCustomerOrderJoinedWithDetails($customerEmail);

        $groupedOrders = $this->groupCustomerOrders($customerOrders);
        $groupOrdersByOrderIdAndBundleId = $this->groupOrdersByOrderIdAndBundleId($customerOrders);
        $pv = $this->getPriceVariety($groupedOrders);
        $this->addParam('groupOrdersByOrderIdAndBundleId', $groupOrdersByOrderIdAndBundleId);
        $this->addParam('priceVariety', $pv);
        if (isset($_REQUEST['order_id'])) {
            $order_id = $_REQUEST['order_id'];
            $mess1 = $this->getPhrase(301);
            $mess2 = $this->getPhrase(329) . $order_id;
            $mess3 = $this->getPhrase(360);
            $this->addParam('customerMessages', array($mess1, $mess2, $mess3));
        }
        if (isset($_SESSION['success_message'])) {
            $this->addParam('customerMessages', array($_SESSION['success_message']));
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            $this->addParam('customerErrorMessages', array($_SESSION['error_message']));
            unset($_SESSION['error_message']);
        }
        $this->addParam('itemManager', ItemManager::getInstance($this->config, $this->args));
        $this->addParam('userManager', UserManager::getInstance($this->config, $this->args));
        $this->addParam('orderManager', OrdersManager::getInstance($this->config, $this->args));
        $this->addParam("orderStatusesValues", $ordersManager->orderStatusesValues);
        $this->addParam("orderStatusesDisplayNames", $ordersManager->getOrderStatusesDisplayNamesPhrases());
        $stripePublishableKey = $this->getCmsVar('stripe_publishable_key');
        $this->addParam('stripe_publishable_key', $stripePublishableKey);
    }

    /**
     * Group orders in sub arrays and bundles in sub arrays
     */
    public function groupOrdersByOrderIdAndBundleId($customerOrders) {
        $groupedOrders = $this->groupCustomerOrders($customerOrders);
        $ret = array();
        foreach ($groupedOrders as $orderId => $orderItems) {
            $groupedOrderItems = array();
            $lasstOiBi = -1;
            foreach ($orderItems as $key => $item) {
                $oibi = $item->getOrderDetailsBundleId();
                if ($oibi == 0) {
                    $groupedOrderItems[] = $item;
                } else {
                    if ($oibi != $lasstOiBi) {
                        $groupedOrderItems[$oibi] = array($item);
                        $lasstOiBi = $oibi;
                    } else {
                        $groupedOrderItems[$oibi][] = $item;
                    }
                }
            }
            $ret[$orderId] = $groupedOrderItems;
        }
        return $ret;
    }

    /**
     * Returns 'amd' if $groupedOrders contains only AMD items for customer,
     * 				 'usd' if $groupedOrders contains only USD items for customer,
     *   	 		 'both' if $groupedOrders contains both AMD and USD items for customer.
     *   	 		 null if $groupedOrders is empty.
     */
    public function getPriceVariety($groupedOrders) {
        assert(is_array($groupedOrders));
        if (empty($groupedOrders)) {
            return null;
        }

        $ret = '';
        foreach ($groupedOrders as $key => $order) {
            $orderInfo = $order[0];
            if ($orderInfo->getOrderTotalAmd() > 0 && $ret === 'usd') {
                return 'both';
            }
            if ($orderInfo->getOrderTotalUsd() > 0 && $ret === 'amd') {
                return 'both';
            }
            if ($orderInfo->getOrderTotalAmd() > 0) {
                $ret = 'amd';
                if ($orderInfo->getOrderTotalUsd() > 0)
                    return 'both';
            }
            if ($orderInfo->getOrderTotalUsd() > 0)
                $ret = 'usd';
        }
        return $ret;
    }

    public function groupCustomerOrders($customerOrders) {
        $groupedOrders = array();
        $oid = null;
        foreach ($customerOrders as $key => $orderDto) {
            $orderId = $orderDto->getId();
            if ($oid != $orderId) {
                $groupedOrders[$orderId] = array($orderDto);
                $oid = $orderId;
            } else {
                $groupedOrders[$orderId][] = $orderDto;
            }
        }
        return $groupedOrders;
    }

    public function getTemplate() {
        return TEMPLATES_DIR . "/main/orders.tpl";
    }

}

?>