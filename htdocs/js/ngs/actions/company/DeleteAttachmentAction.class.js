ngs.DeleteAttachmentAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "do_delete_attachment";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.evalJSON();
        if (data.status === "ok") {
            
        } else if (data.status === "err") {
            alert(data.message);
        }
    }
});
