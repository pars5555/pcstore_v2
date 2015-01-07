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
        this.componentsBlocksController();
        this.initChangeItemCount();
    },
    initChangeItemCount: function () {
        jQuery('.cart_item_count').change(function () {
            var locationUrl = jQuery('option:selected', this).attr('location_url');
            window.location.href = locationUrl;
        });
    },
    componentsBlocksController: function () {
        jQuery(".f_bundle_btn").click(function () {
            jQuery(this).closest(".f_bundle_item").find(".f_bundle_wrapper").stop(true, false).slideToggle();
        });
    }
});
