ngs.PccSelectCoolerLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_pcc", ajaxLoader);
    },
    getUrl: function () {
        return "pcc_select_cooler";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "component_selection_container";
    },
    getName: function () {
        return "pcc_select_cooler";
    },
    afterLoad: function () {
        ngs.PcConfiguratorManager.onComponentAfterLoad();
    }
});
