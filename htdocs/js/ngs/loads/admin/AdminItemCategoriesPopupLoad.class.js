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
        this.initJTree();
        this.initSaveButton();
        jQuery("#adminItemCategoriesPopup").addClass("active");
        ngs.MainLoad.prototype.mainLoader(false);
    },
    initJTree: function () {
        jQuery('#itemCategoriesContainer').jstree({
            "core": {
                "multiple": true
            },
            "checkbox": {
                "keep_selected_style": false,
                "three_state": false
            },
            "plugins": ["checkbox"]

        });

        //initial selection
        var itemCategoriesIdsArray = jQuery('#admin_item_categories').val().split(',');
        jQuery.each(itemCategoriesIdsArray, function (index, catId) {
            jQuery('#itemCategoriesContainer').jstree('select_node', catId + "_" + "categoryNode");
        });

        //select parents when select child
        jQuery('#itemCategoriesContainer').on('changed.jstree', function (e, data) {
            jQuery.each(data.node.parents, function (parentIndex, parent) {
                jQuery('#itemCategoriesContainer').jstree('select_node', parent);
            });
        });
    },
    initSaveButton: function () {
        jQuery('#admin_item_categories_save_button').click(function () {
            var selection = jQuery('#itemCategoriesContainer').jstree("get_selected");
            var categories_ids_array = new Array();
            jQuery.each(selection, function (index, nodeId) {
                var catId = parseInt(nodeId);
                categories_ids_array.push(catId);
            });
            var item_id = jQuery('#admin_item_categories_popup_item_id').val();
            ngs.action('admin_save_item_categories', {'item_id': item_id, 'categories_ids': categories_ids_array.join(',')});

        });
    }
});
