ngs.PccSelectCaseLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main_pcc", ajaxLoader);
    },
    getUrl: function () {
        return "pcc_select_case";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "component_selection_container";
    },
    getName: function () {
        return "pcc_select_case";
    },
    afterLoad: function () {

        ngs.PcConfiguratorManager.onComponentAfterLoad();
        this.componentBlock();
    },
    componentBlock : function(){
        jQuery(".f_current_item_block").on("click",function(){
            jQuery("#pcc_loader").removeClass("hidden");            
        });
    }
});
