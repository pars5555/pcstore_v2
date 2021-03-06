ngs.AdminCategoriesLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "categories";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_categories";
    },
    afterLoad: function () {
        jQuery('#categoriesContainer').jstree({
            "core": {
                "multiple": false
            }
            /*,
            "checkbox": {
                "keep_selected_style": false
            },
            "plugins": ["wholerow", "checkbox"]*/
        });
        jQuery('#categoriesContainer').on('changed.jstree', function (e, data) {
            var categoryId = parseInt(data.selected[0]);
            ngs.load('admin_category_details', {'category_id': categoryId});
        });
    }
});
