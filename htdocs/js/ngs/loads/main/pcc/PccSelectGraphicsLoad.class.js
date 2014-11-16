ngs.PccSelectGraphicsLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_pcc", ajaxLoader);
    },
    getUrl: function () {
        return "pcc_select_graphics";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "component_selection_container";
    },
    getName: function () {
        return "pcc_select_graphics";
    },
    afterLoad: function () {
        ngs.PcConfiguratorManager.onComponentAfterLoad();
    }
});