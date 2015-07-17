<?php

require_once (CLASSES_PATH . "/actions/GuestAction.class.php");
require_once (CLASSES_PATH . "/managers/ItemManager.class.php");
require_once (CLASSES_PATH . "/managers/CustomerCartManager.class.php");

/**
 * @author Vahagn Sookiasian
 */
class SetPromoCodeAction extends GuestAction {

    public function service() {
        $promo_code = $this->secure($_POST['promo_code']);
        if (empty($_COOKIE['promo_codes'])) {
            $_COOKIE['promo_codes'] = $promo_code;
        } else {
            $_COOKIE['promo_codes'] = $_COOKIE['promo_codes'] . ',' . $promo_code;
        }
        setcookie('promo_codes', $_COOKIE['promo_codes'], time()+60*60*24, '/',"." );
        $this->redirect('cart');
    }

}

?>