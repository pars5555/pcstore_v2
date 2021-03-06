ngs.LoginAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "do_login";
    },
    getMethod: function () {
        return "POST";
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            window.location.reload(true);
        } else if (data.status === "err") {
            jQuery('#mainLoginForm').find('.error').html(data.message);
        }
    }
});
