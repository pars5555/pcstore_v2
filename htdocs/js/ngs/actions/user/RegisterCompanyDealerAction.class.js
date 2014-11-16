ngs.RegisterCompanyDealerAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "user", ajaxLoader);
    },
    getUrl: function () {
        return "do_register_company_dealer";
    },
    getMethod: function () {
        return "POST";
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            if (data.message)
            {
                alert(data.message);                
            }
            window.location.reload(true);
        } else if (data.status === "err") {
            alert(data.message);
        }
    }
});
