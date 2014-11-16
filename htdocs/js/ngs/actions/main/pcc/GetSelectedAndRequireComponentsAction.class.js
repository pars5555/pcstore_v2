ngs.GetSelectedAndRequireComponentsAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_pcc", ajaxLoader);
    },
    getUrl: function () {
        return "do_get_selected_and_require_components";
    },
    getMethod: function () {
        return "POST";
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        this.updateComponentSelectedAndRequiredStatus(data.selected_components_ids, data.required_components_ids);
        if (data.required_components_ids.length > 0) {
            if (jQuery('#configurator_mode_edit_cart_row_id').length > 0) {
                this.scroolToRequiredComponent(data.required_components_ids);
            }
        }
    },
    scroolToRequiredComponent: function (required_components_ids) {
        var firstRequiredComponentIndex = parseInt(required_components_ids[0]);
        jQuery(".f_component[component_index=" + firstRequiredComponentIndex + "]").trigger('click');
    },
    updateComponentSelectedAndRequiredStatus: function (selected_components_ids, required_components_ids) {
        var cs = ngs.PcConfiguratorManager.componentsIndex;
        jQuery(".f_component").removeClass('pcc_selected_component');
        jQuery(".f_component").removeClass('pcc_required_component');
        for (var prop in cs) {
            if (cs.hasOwnProperty(prop)) {
                if (jQuery.inArray(cs[prop], selected_components_ids) >= 0) {
                    jQuery(".f_component[component_index=" + cs[prop] + "]").addClass('pcc_selected_component');
                }
                if (jQuery.inArray(cs[prop], required_components_ids) >= 0) {
                    jQuery(".f_component[component_index=" + cs[prop] + "]").addClass('pcc_required_component');

                }
            }
        }






    }
});
