ngs.PccSelectCpuLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_pcc", ajaxLoader);
        this.componentKey = 'cpu';
    },
    getUrl: function () {
        return "pcc_select_cpu";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "component_selection_container";
    },
    getName: function () {
        return "pcc_select_cpu";
    },
    afterLoad: function () {
        ngs.PcConfiguratorManager.onComponentAfterLoad();

    }
});
