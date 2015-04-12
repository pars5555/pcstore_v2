ngs.AdminSaveItemCategoriesAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "do_save_item_categories";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            jQuery("#adminItemCategoriesPopup .f_modal_content").removeClass("active");
            jQuery("#adminItemCategoriesPopup").addClass("hide");
        } else if (data.status === "err") {
        }
    }
});
