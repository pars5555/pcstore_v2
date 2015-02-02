ngs.CheckoutCalculationLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "checkout_calculation";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "checkout_confirm";
    },
    getName: function () {
        return "main_checkout_calculation";
    },
    afterLoad: function () {
        jQuery("#checkout_confirm .checkout_confirm_btn").click(function (event) {
            var phoneNumber = jQuery("#shipCellTel").val();
            jQuery("#confirm_phone_number").val(phoneNumber);
            jQuery("#cell_phone_number").removeClass("hide");
        });
    }


});
