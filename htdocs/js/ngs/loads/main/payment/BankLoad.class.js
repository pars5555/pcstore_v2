ngs.BankLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_payment", ajaxLoader);
    },
    getUrl: function () {
        return "bank";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "payment_details";
    },
    getName: function () {
        return "payment_bank";
    },
    afterLoad: function () {
    }
});
