ngs.BuildpcLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "buildpc";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "main_buildpc";
    },
    afterLoad: function () {
        this.buildPcComponentController();
        this.customScroll();
        this.buildPcComponentMenuController();
        ngs.PcConfiguratorManager.updateSelectedAndRequiredComponentsStatus();
        jQuery(".f_component[component_index=1]").addClass('active');
        this.scrollTopOnComponentSelect();
        this.pccDetailsToggle();
    },
    buildPcComponentMenuController: function () {
        jQuery("#mobileBtnComp").click(function () {
            jQuery("#itemSections").toggleClass("open");
        });
    },
    customScroll: function () {
        jQuery("#buildPcWrapper").mCustomScrollbar({
            theme: "light-3",
            scrollButtons: {
                enable: true
            }
        });
    },
    buildPcComponentController: function () {
        ngs.nestLoad('pcc_select_case', {});
        ngs.nestLoad('pcc_total_calculations', {});
        jQuery(".f_component").click(function () {
            jQuery(".f_component").removeClass("active");
            
            var data_side_panel = jQuery(this).closest(".f_side_panel").attr("data-side-panel");
            jQuery(".f_side_panel_btn[data-side-panel="+data_side_panel+"],.f_side_panel[data-side-panel="+data_side_panel+"]").removeClass("active");
            
            jQuery(this).addClass("active");
            var componentIndex = jQuery(this).attr('component_index');
            ngs.PcConfiguratorManager.onTabChanged(componentIndex);
        });
    },
    scrollTopOnComponentSelect: function () {
        var scrollTop;
        function getScrollTop() {
            scrollTop = jQuery(".f_pc_components").offset().top;
            if (jQuery(window).width() <= 590) {
                scrollTop = jQuery("#buildPcWrapper").offset().top;
            }
        }
        ;
        getScrollTop();
        jQuery(window).resize(function () {
            getScrollTop();
        });
        jQuery(".f_current_item_block").on("click tap", function () {
            jQuery("html,body").animate({scrollTop: scrollTop - 50}, 500);
        });
    },
    pccDetailsToggle : function(){
        jQuery(".f_pcc_component_toggle_btn").on("click tap",function(event){
            event.stopPropagation();
            jQuery(this).toggleClass("active");
            var parent = jQuery(this).closest(".f_current_item_block");
            parent.find(".f_pcc_select_wrapper,.component_info,.component_price").slideToggle(300);
        });
    }
});
