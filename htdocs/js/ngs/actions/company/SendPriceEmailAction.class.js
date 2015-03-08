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
        if (data.status === "ok") {
            jQuery("#main_loader").addClass("hidden");
            var title_text = jQuery("#send_price_email_title_text").val();
            var send_text = jQuery("#send_price_email_send_text").val();
            var save_text = jQuery("#send_price_email_save_text").val();
            var MainLoad = new ngs.MainLoad();

            if (this.params.save_only === 1) {
                MainLoad.initPopup(title_text, save_text);
            } else {
                MainLoad.initPopup(title_text, send_text);
            }
        } else if (data.status === "err") {
            MainLoad.initPopup(title_text, data.message);
        }
    }
});
