ngs.BuildpcLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function() {
        return "buildpc";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "main_buildpc";
    },
    afterLoad: function() {
        this.buildPcComponentController();
        this.customScroll();
        this.buildPcComponentMenuController();
        ngs.PcConfiguratorManager.updateSelectedAndRequiredComponentsStatus();
        jQuery(".f_component[component_index=1]").addClass('active');
    },
    buildPcComponentMenuController:function(){
        jQuery("#mobileBtnComp").click(function(){
            jQuery("#itemSections").toggleClass("open");
        });
    },
    customScroll: function() {
        jQuery("#buildPcWrapper").mCustomScrollbar({
            theme:"light-3",
            scrollButtons:{
              enable:true
            }
        });
    },
    buildPcComponentController: function() {
        ngs.nestLoad('pcc_select_case', {});
        ngs.nestLoad('pcc_total_calculations', {});
        jQuery(".f_component").click(function() {
            jQuery(".f_component").removeClass("active");
            jQuery(this).addClass("active");
            var componentIndex = jQuery(this).attr('component_index');
            ngs.PcConfiguratorManager.onTabChanged(componentIndex);
            jQuery("#pcc_loader").removeClass("hidden");
        });
    }
});
