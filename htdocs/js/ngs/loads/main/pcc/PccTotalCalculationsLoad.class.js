ngs.PccTotalCalculationsLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_pcc", ajaxLoader);
    },
    getUrl: function () {
        return "pcc_total_calculations";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "pcc_total_calculation_container";
    },
    getName: function () {
        return "pcc_total_calculations";
    },
    afterLoad: function () {
        var MainLoad = new ngs.MainLoad();
        MainLoad.initLoginFunctionallity();

        this.initPrintBtn();
        this.initRemoveItem();
    },
    initRemoveItem: function () {
        jQuery('.pcc_total_calc_item_price_row .f_deleteSelectedComponentFromTotalBtn').click(function () {
            var componentTypeIndex = jQuery(this).attr('componentTypeIndex');
            var itemId = jQuery(this).attr('itemId');
            ngs.PcConfiguratorManager.onDeleteItem(componentTypeIndex, itemId);
            return false;
        });
    },
    initPrintBtn: function () {
        var thisInstance = this;
        jQuery('#pcc_print_button').click(function () {
            var selected_components = jQuery.param(ngs.PcConfiguratorManager.getSelectedComponentsParam());
            var iframe = "<div><iframe name='print' style='width:100%;height:100%;'  scrolling='no' id='pcc_print_iframe' src='//" + SITE_URL + "/print_pcc?" + selected_components + "'></iframe></div>";
            jQuery(iframe).dialog({
                resizable: true,
                modal: true,
                width: 800,
                height: 600,
                buttons: {
                    "Action": {
                        text: "Print",
                        click: function () {
                            var iframeElem = jQuery('#pcc_print_iframe')[0];
                            var iframeWindow = iframeElem.contentWindow ? iframeElem.contentWindow : iframeElem.contentDocument.defaultView;
                            iframeWindow.focus();
                            iframeWindow.print();
                        }
                    },
                    "Cancel": {
                        text: "Cancel",
                        click: function () {
                            jQuery(this).remove();
                        }
                    }
                },
                close: function () {
                    jQuery(this).remove();
                }
            });
        });
    }
});
