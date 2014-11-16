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
        this.initPrintBtn();
    },
    initPrintBtn: function () {
        var thisInstance = this;
        jQuery('#pcc_print_button').click(function () {
            var selected_components = jQuery.param(ngs.PcConfiguratorManager.getSelectedComponentsParam());
            var iframe = "<div><iframe style='width:100%;height:100%;'  scrolling='no' id='pcc_print_iframe' src='//" + SITE_URL + "/print_pcc?" + selected_components + "'></iframe></div>";
            jQuery(iframe).dialog({
                resizable: true,
                modal: true,
                width: 800,
                height: 600,
                buttons: {
                    "Action": {
                        text: "Print",
                        click: function () {
                            thisInstance.printFrame("pcc_print_iframe");
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
