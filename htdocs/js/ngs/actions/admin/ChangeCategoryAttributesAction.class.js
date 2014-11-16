ngs.ChangeCategoryAttributesAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "do_change_category_attributes";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status == "ok") {
            window.location.reload();
        } else if (data.status == "err") {
            ngs.DialogsManager.closeDialog(583, "<div>" + data.message + "</div>");
            ngs.load('admin_category_details', {'category_id': this.params.category_id});
        }
    }
});
