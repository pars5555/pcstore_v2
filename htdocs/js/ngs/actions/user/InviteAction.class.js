ngs.InviteAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "user", ajaxLoader);
    },
    getUrl: function () {
        return "do_invite";
    },
    getMethod: function () {
        return "POST";
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {

        } else if (data.status === "err") {

        }
    }
});
