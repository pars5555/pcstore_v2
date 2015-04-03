ngs.SendPriceEmailAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "do_send_price_email";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        jQuery("#main_loader").addClass("hidden");
        var MainLoad = new ngs.MainLoad();
        if (data.status === "ok") {
            var title_text = jQuery("#send_price_email_title_text").val();
            var send_text = jQuery("#send_price_email_send_text").val();
            var save_text = jQuery("#send_price_email_save_text").val();
            var done_btn = jQuery("#send_price_email_done_btn").val();
            if (this.params.save_only === 1) {
                MainLoad.initPopup(title_text, save_text, done_btn);
            } else {
                MainLoad.initPopup(title_text, send_text, done_btn);
            }
        } else if (data.status === "err") {
            var title_text = jQuery("#error_send_price_email_title_text").val();
            MainLoad.initPopup(title_text, data.message, done_btn);
        }
    }
});
