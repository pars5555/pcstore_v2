ngs.AdminAddRemoveItemPictureAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "do_add_remove_item_picture";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = {};
        if (typeof transport.responseText !== 'undefined') {
            data = transport.responseText.evalJSON();
        } else {
            data = transport.evalJSON();
        }
        if (data.status === "ok") {
            var item_id = data.item_id;
            ngs.load("admin_item_pictures_popup", {'item_id': item_id});
        } else if (data.status === "err") {
            jQuery('#admin_item_pictures_popup_error_message').html(data.message);
        }
    }
});
