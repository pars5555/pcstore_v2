ngs.CartLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "cart";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "main_cart";
    },
    afterLoad: function () {
        this.componentsSliderInit();
        this.componentsBlocksController();
    },
    componentsBlocksController: function () {
        jQuery(".f_bundle_btn").click(function () {
            console.log(jQuery(this).siblings(".f_bundle_wrapper"))
            jQuery(this).siblings(".f_bundle_wrapper").stop(true, false).slideToggle();
        });
    },
    componentsSliderInit: function () {
        jQuery(".f_current_bundle_slider").owlCarousel({
            itemsCustom: [
                [0, 2],
                [450, 4],
                [600, 4],
                [700, 4],
                [1000, 4],
                [1200, 4],
                [1400, 4],
                [1600, 4]
            ],
            navigation: true,
            navigationText: false,
            rewindNav: false
        });
    }
});
