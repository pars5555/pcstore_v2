ngs.AdminDeleteNewsletterAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_newsletter", ajaxLoader);
    },
    getUrl: function () {
        return "do_delete_newsletter";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === 'ok')
        {
            ngs.load("admin_manage_newsletters", {});
        } else
        {
            alert(data.message);

        }
    }
});
