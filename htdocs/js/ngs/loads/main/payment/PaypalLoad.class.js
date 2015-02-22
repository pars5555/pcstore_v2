ngs.PaypalLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_payment", ajaxLoader);
    },
    getUrl: function () {
        return "paypal";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "payment_details";
    },
    getName: function () {
        return "payment_paypal";
    },
    afterLoad: function () {
    }
});
