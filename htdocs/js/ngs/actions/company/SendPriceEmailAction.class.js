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
            if (this.params.save_only == 1) {
                ngs.DialogsManager.closeDialog(514, "<div>" + 586 + "</div>");
            } else {
                ngs.DialogsManager.closeDialog(514, "<div>" +573 + "</div>");
            }
        } else if (data.status === "err") {
            ngs.DialogsManager.closeDialog(514, "<div>" + data.message + "</div>");
        }
    }
});
