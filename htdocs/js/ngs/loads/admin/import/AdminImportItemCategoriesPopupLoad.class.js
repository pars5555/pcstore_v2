ngs.AdminImportItemCategoriesPopupLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_import", ajaxLoader);
    },
    getUrl: function () {
        return "import_item_categories_popup";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "adminImportItemCategoriesPopupBody";
    },
    getName: function () {
        return "admin_import_item_categories_popup";
    },
    afterLoad: function () {
        this.initJTree();
        this.initSaveButton();
        jQuery('#adminImportItemCategoriesPopup').addClass('active');
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
        var itemCategoriesIdsArray = this.params.categories_ids.split(',');
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
            jQuery('#' + this.params.result_hidden_element_id).val(categories_ids_array.join(','));
            jQuery('#' + this.params.result_hidden_element_id).trigger('change');
            jQuery(".main_pop_up").removeClass("active hide");

        }.bind(this));
    }
});
