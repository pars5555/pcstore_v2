ngs.AdminImportStep2Load = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_import", ajaxLoader);
    },
    getUrl: function () {
        return "import_step2";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_import_step2";
    },
    afterLoad: function () {
        this.initLinkSourceTargetButtons();
    },
    initLinkSourceTargetButtons: function() {
        var thisObject = this;
        jQuery('.ii_link_source_button').click(function() {
            thisObject.linkSourceStockItemId = jQuery(this).attr('pk_value');

        });
        jQuery('.ii_link_target_button').click(function() {
            if (thisObject.linkSourceStockItemId > 0) {
                var linkTargetPriceRowId = jQuery(this).attr('pk_value');
                var params = jQuery.extend(thisObject.params, {'action': 'step_1_link_stock_item_to_price_item',
                    'price_item_id': linkTargetPriceRowId,
                    'stock_item_id': thisObject.linkSourceStockItemId});
                ngs.action('import_steps_actions_group_action', params);
                thisObject.linkSourceStockItemId = 0;
            } else {
                ngs.DialogsManager.closeDialog(483, "<div>" + 'please select link source!' + "</div>");
            }
        });
    },
});
