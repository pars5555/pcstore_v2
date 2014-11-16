ngs.RevertCompanyLastPriceAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "do_revert_company_last_price";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            window.location.href=window.location.href;
        } else if (data.status === "err") {
            ngs.DialogsManager.closeDialog(583, "<div>" + data.errText + "</div>");
        }
    }
});
