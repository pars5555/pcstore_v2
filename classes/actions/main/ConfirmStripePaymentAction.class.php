<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/UserManager.class.php");
require_once (CLASSES_PATH . "/managers/OrdersManager.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");
require_once (CLASSES_PATH . '/lib/stripe-php-1.17.1/lib/Stripe.php');

/**
 * @author Vahagn Sookiasian
 */
class ConfirmStripePaymentAction extends GuestAction {

    public function service() {
        $order_id = $_REQUEST['order_id'];
        $token = $_REQUEST['stripeToken'];
        $userManager = UserManager::getInstance($this->config, $this->args);
        $ordersManager = OrdersManager::getInstance($this->config, $this->args);
        $orderTotalUsdToPay = $ordersManager->getOrderTotalUsdToPay($order_id, true);

        Stripe::setApiKey($this->getCmsVar('stripe_secret_key'));

        $email = $userManager->getRealEmailAddressByUserDto($this->getCustomer());
        try {
            $charge = Stripe_Charge::create(array(
                        "card" => $token,
                        "description" => $email . ' (order #' . $order_id . ')',
                        'amount' => round($orderTotalUsdToPay * 100),
                        'currency' => 'usd'
            ));
        } catch (Exception $e) {
            $this->error(array('message' => $e->getMessage()));
        }
        $ordersManager->updateTextField($order_id, '3rd_party_payment_token', $token);
        $ordersManager->updateTextField($order_id, '3rd_party_payment_received', 1);
        $this->ok();
    }

    public function getRequestGroup() {
        return RequestGroups::$userCompanyRequest;
    }

}
?>


