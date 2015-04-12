ngs.AdminItemCategoriesPopupLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "item_categories_popup";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "adminItemCategoriesPopupBody";
    },
    getName: function () {
        return "admin_item_categories_popup";
    },
    afterLoad: function () {
        jQuery('#itemCategoriesContainer').jstree({
            "core": {
                "multiple": true
            },
            "checkbox": {
                "keep_selected_style": false
            },
            "plugins": ["wholerow", "checkbox"]
        });
    }
});
