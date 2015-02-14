ngs.PcConfiguratorManager = {
    componentsIndex: null,
    selectedComponentsArray: null,
    init: function () {
        this.selectedComponentsArray = new Array();
        this.componentsIndex = {
            CASE: 1,
            CPU: 2,
            MB: 3,
            COOLER: 4,
            RAM: 5,
            HDD: 6,
            SSD: 7,
            OPT: 8,
            MONITOR: 9,
            VIDEO: 10,
            POWER: 11,
            KEY: 12,
            MOUSE: 13,
            SPEAKER: 14
        };
    },
    getSelectedItemsIds: function () {
        var selectedItemsIdsArray = new Array();
        jQuery('#component_selection_container .f_selectable_component').each(function () {
            if (jQuery(this).prop('checked'))
            {
                var item_id = jQuery(this).attr('item_id');
                var itemCount = parseInt(jQuery(this).attr('count'));
                if (itemCount === 0)
                {
                    itemCount = 1;
                }
                for (var i = 0; i < itemCount; i++) {
                    selectedItemsIdsArray.push(item_id);
                }
            }
        });
        if (selectedItemsIdsArray.length === 1)
        {
            return selectedItemsIdsArray[0];
        } else
        {
            return selectedItemsIdsArray;
        }

    },
    getBackendSelectedComponentsIdsArray: function () {
        var selected_components_ids_array = new Array();
        for (var i = 1; i <= 14; i++) {
            var el = jQuery('#selected_component_' + i).val();
            selected_components_ids_array[i] = el;
        }
        return selected_components_ids_array;
    },
    onComponentAfterLoad: function () {

        var componentIndex = parseInt(jQuery('#pcc_select_component_inner_container').attr('component_index'));

        var thisInstance = this;
        jQuery('#component_selection_container .pcc_selected_component_count').change(function (e) {
            var item_ids_array = thisInstance.getAllCurrentComponentSelectedItemsIdsArray();
            thisInstance.onComponentChanged(componentIndex, item_ids_array);
        });
        jQuery('#component_selection_container .f_selectable_component').click(function () {
            var itemsIds = thisInstance.getSelectedItemsIds();
            ngs.PcConfiguratorManager.onComponentChanged(componentIndex, itemsIds);
        });

        var selected_components_ids_array = this.getBackendSelectedComponentsIdsArray();
        for (var i = 1; i <= 14; i++) {
            this.selectedComponentsArray[i] = selected_components_ids_array[i];
        }
        var selected_item_id = this.selectedComponentsArray[componentIndex];
        if (selected_item_id instanceof Array) {
            selected_item_id = selected_item_id.join(',');
        }
        /* ngs.load('pcc_item_description', {
         "item_id": selected_item_id
         });*/
        var params = this.getSelectedComponentsParam(null, null);

        if (jQuery('#configurator_mode_edit_cart_row_id').length > 0) {
            params.cem = parseInt(jQuery('#configurator_mode_edit_cart_row_id').val());
        }
        if (jQuery('#pcc_footer_order_button').length > 0) {
            jQuery('#pcc_footer_order_button').css({'visibility': 'visible'});
        }
        if (jQuery('#pcc_print_button').length > 0) {
            jQuery('#pcc_print_button').css({'visibility': 'visible'});
        }
        var urlParams = jQuery.param(params);
        if (urlParams.trim() != '')
        {
            urlParams = '?' + urlParams;
        }
        ngs.UrlChangeEventObserver.setFakeURL('/buildpc' + urlParams);
        jQuery("#buildPcWrapper").mCustomScrollbar('scrollTo', 'top');

    },
    getAllCurrentComponentSelectedItemsIdsArray: function () {
        var selectedItemsIds = new Array();
        jQuery('input:checked.f_selectable_component').each(function () {
            var item_id = jQuery(this).attr('item_id');
            var itemCount = parseInt(jQuery("#selected_component_count_" + item_id).val());
            while (itemCount >= 1) {
                itemCount--;
                selectedItemsIds.push(item_id);
            }
        });
        return selectedItemsIds;
    },
    onTabChanged: function (componentIndex) {
        var params = this.getSelectedComponentsParam(null, null);
        var loadName = this.getComponentLoadName(componentIndex);
        ngs.load(loadName, params);
    },
    makeArray: function (howMany, value) {
        var output = new Array();
        while (howMany--) {
            output.push(value);
        }
        return output;
    },
    onDeleteItem: function (componentIndex, item_id) {
        var selectedComponentItemsIds = this.selectedComponentsArray[componentIndex];
        var selectedComponentItemsIdsArray = selectedComponentItemsIds.split(',');
        while (selectedComponentItemsIdsArray.indexOf(item_id) >= 0)
        {
            selectedComponentItemsIdsArray.splice(selectedComponentItemsIdsArray.indexOf(item_id), 1);
        }
        if (selectedComponentItemsIdsArray.length > 0) {
            this.selectedComponentsArray[componentIndex] = selectedComponentItemsIdsArray.join(',');
        } else
        {
            this.selectedComponentsArray[componentIndex] = "";

        }
        var params = this.getSelectedComponentsParam(componentIndex, item_id);
        if (jQuery(".f_component[component_index=" + componentIndex + "]").hasClass('active')) {
            var loadName = this.getComponentLoadName(componentIndex);
            ngs.load(loadName, params);
        }
        ngs.load('pcc_total_calculations', params);
        ngs.action('get_selected_and_require_components', params);
    },
    onComponentChanged: function (componentIndex, item_id) {
        if (item_id instanceof Array) {
            item_id = item_id.join(',');
        }
        this.selectedComponentsArray[componentIndex] = item_id;

        var params = this.getSelectedComponentsParam(componentIndex, item_id);
        // ngs.action('pcc_after_component_changed_action', params);
        if (jQuery('#configurator_mode_edit_cart_row_id').length > 0) {
            params.cem = parseInt(jQuery('#configurator_mode_edit_cart_row_id').val());
        }

        if (jQuery('#pcc_print_button').length > 0) {
            jQuery('#pcc_print_button').css({'visibility': 'hidden'});
        }
        if (jQuery(".f_component[component_index=" + componentIndex + "]").hasClass('active')) {
            var loadName = this.getComponentLoadName(componentIndex);
            ngs.load(loadName, params);
        }
        ngs.load('pcc_total_calculations', params);
        ngs.action('get_selected_and_require_components', params);
    },
    updateSelectedAndRequiredComponentsStatus: function () {
        var params = this.getSelectedComponentsParam(null, null);
        ngs.action('get_selected_and_require_components', params);
    },
    getComponentLoadName: function (componentIndex)
    {
        switch (parseInt(componentIndex)) {
            case this.componentsIndex.CASE:
                return 'pcc_select_case';
            case this.componentsIndex.CPU:
                return 'pcc_select_cpu';
            case this.componentsIndex.MB:
                return 'pcc_select_mb';
            case this.componentsIndex.COOLER:
                return 'pcc_select_cooler';
            case this.componentsIndex.RAM:
                return 'pcc_select_ram';
            case this.componentsIndex.HDD:
                return 'pcc_select_hdd';
            case this.componentsIndex.SSD:
                return 'pcc_select_ssd';
            case this.componentsIndex.OPT:
                return 'pcc_select_opt';
            case this.componentsIndex.MONITOR:
                return 'pcc_select_monitor';
            case this.componentsIndex.VIDEO:
                return 'pcc_select_graphics';
            case this.componentsIndex.POWER:
                return 'pcc_select_power';
            case this.componentsIndex.KEY:
                return 'pcc_select_keyboard';
            case this.componentsIndex.MOUSE:
                return 'pcc_select_mouse';
            case this.componentsIndex.SPEAKER:
                return 'pcc_select_speaker';
        }
        return null;
    },
    /**
     *Returns selected components ids, or if selected component is more that one then join the component ids and put in the corresponding component object key.
     * @param {Object} componentIndex last selected component index
     * @param {Object} item_id last selected item id
     */
    getSelectedComponentsParam: function (componentIndex, item_id) {
        var ret = {};
        if (this.selectedComponentsArray[this.componentsIndex.CASE].trim() !== '')
        {
            ret.case = this.selectedComponentsArray[this.componentsIndex.CASE];
        }
        if (this.selectedComponentsArray[this.componentsIndex.MB].trim() !== '')
        {
            ret.mb = this.selectedComponentsArray[this.componentsIndex.MB];
        }
        if (this.selectedComponentsArray[this.componentsIndex.RAM].trim() !== '')
        {
            ret.rams = this.selectedComponentsArray[this.componentsIndex.RAM];
        }
        if (this.selectedComponentsArray[this.componentsIndex.CPU].trim() !== '')
        {
            ret.cpu = this.selectedComponentsArray[this.componentsIndex.CPU];
        }
        if (this.selectedComponentsArray[this.componentsIndex.HDD].trim() !== '')
        {
            ret.hdds = this.selectedComponentsArray[this.componentsIndex.HDD];
        }
        if (this.selectedComponentsArray[this.componentsIndex.SSD].trim() !== '')
        {
            ret.ssds = this.selectedComponentsArray[this.componentsIndex.SSD];
        }
        if (this.selectedComponentsArray[this.componentsIndex.COOLER].trim() !== '')
        {
            ret.cooler = this.selectedComponentsArray[this.componentsIndex.COOLER];
        }
        if (this.selectedComponentsArray[this.componentsIndex.OPT].trim() !== '')
        {
            ret.opts = this.selectedComponentsArray[this.componentsIndex.OPT];
        }
        if (this.selectedComponentsArray[this.componentsIndex.MONITOR].trim() !== '')
        {
            ret.monitor = this.selectedComponentsArray[this.componentsIndex.MONITOR];
        }
        if (this.selectedComponentsArray[this.componentsIndex.VIDEO].trim() !== '')
        {
            ret.graphics = this.selectedComponentsArray[this.componentsIndex.VIDEO];
        }
        if (this.selectedComponentsArray[this.componentsIndex.POWER].trim() !== '')
        {
            ret.power = this.selectedComponentsArray[this.componentsIndex.POWER];
        }
        if (this.selectedComponentsArray[this.componentsIndex.KEY].trim() !== '')
        {
            ret.keyboard = this.selectedComponentsArray[this.componentsIndex.KEY];
        }
        if (this.selectedComponentsArray[this.componentsIndex.MOUSE].trim() !== '')
        {
            ret.mouse = this.selectedComponentsArray[this.componentsIndex.MOUSE];
        }
        if (this.selectedComponentsArray[this.componentsIndex.SPEAKER].trim() !== '')
        {
            ret.speaker = this.selectedComponentsArray[this.componentsIndex.SPEAKER];
        }
        if (componentIndex !== null)
        {
            ret.last_selected_component_type_index = componentIndex;
        }
        if (item_id !== null)
        {
            ret.last_selected_component_id = item_id;
        }
        return ret;
    },
    /**
     *Returns flat (one level) array of selected items ids, note that only
     */
    getSelectedComponentsIdsJoinWithComma: function () {
        var scids = this.selectedComponentsArray.join(',');
        var flat_ids = scids.split(',');
        var exclude_not_selected_components = new Array();
        for (var i = 0; i < flat_ids.length; i++) {
            if (parseInt(flat_ids[i]) > 0) {
                exclude_not_selected_components.push(flat_ids[i]);
            }
        }
        return exclude_not_selected_components.join(',');
    },
    getBackendComponentId: function (elementId) {

        var selected_component = $(elementId).value;
        if (selected_component.indexOf(',') == -1) {

            var selected_component_id = 0;
            if (selected_component.strip().length > 0 && parseInt(selected_component) > 0) {
                selected_component_id = parseInt(selected_component);
            }
            return selected_component_id;
        } else {

            var selected_components = $(elementId).value;
            selected_components = selected_components.split(',');

            var selected_components_ids = new Array();
            for (var i = 0; i < selected_components.length; i++) {
                var selected_component = selected_components[i];
                var selected_component_id = 0;
                if (selected_component.strip().length > 0 && parseInt(selected_component) > 0) {
                    selected_component_id = parseInt(selected_component);
                }
                if (selected_component_id > 0)
                    selected_components_ids.push(selected_component_id);
            }
            var selected_component_id = selected_components_ids.length > 1 ? selected_components_ids : selected_components_ids.length === 1 ? selected_components_ids[0] : 0;
            if (selected_component_id && selected_component_id instanceof Array) {
                selected_component_id = selected_component_id.join(',');
            }
            return selected_component_id;
        }
    }
};
