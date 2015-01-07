ngs.OrdersLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "orders";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "main_orders";
    },
    afterLoad: function () {
        this.initStripe();
        this.OrderMoreInfoSlide();
    },
    initStripe: function () {
        var thisObject = this;
        var handler = StripeCheckout.configure({
            key: jQuery('#stripe_publishable_key').val(),
            //image: SITE_PATH+'/img/logo_pcstore.png',
            token: function (token) {
                ngs.action('confirm_stripe_payment', {'stripeToken': token.id, 'order_id': thisObject.order_id_be_be_paied_by_stripe});
            }
        });

        jQuery('.credit_card_paynow_btn').click(function (e) {
            var orderId = jQuery(this).attr('order_id');
            thisObject.order_id_be_be_paied_by_stripe = orderId;
            var totalAmount = jQuery(this).attr('total_amount');
            var user_email = jQuery(this).attr('user_email');

            handler.open({
                name: 'Pcstore',
                description: 'Order Number ' + orderId,
                amount: Math.round(totalAmount * 100),
                email: user_email
            });
            e.preventDefault();
        });
    },
    OrderMoreInfoSlide : function(){
        jQuery(".f_order_slide_btn").click(function(){
           jQuery(this).siblings(".f_order_more_info").slideToggle(300);
        });
    }
});
