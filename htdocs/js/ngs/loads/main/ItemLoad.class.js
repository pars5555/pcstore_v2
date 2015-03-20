ngs.ItemLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "item";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "main_item";
    },
    afterLoad: function () {
        this.changeMainPicture();
        this.zoomProductImage();
    },
    changeMainPicture: function () {
        jQuery("#product-other-images .f_poi_item").on("click", function () {
            var self = jQuery(this);
            jQuery(".f_product_img").fadeTo(200, 0, "swing", function () {
                jQuery(".f_product_img,#zoom-img .f_zoom_img").attr("style", self.attr("style"));
                jQuery(this).css("opacity", 0);
                self.addClass("active");
                self.siblings().removeClass("active");
                jQuery(this).fadeTo(200, 1, "swing");
            });
        });
    },
    zoomProductImage: function () {
        jQuery(".f_product_img").on("click", function () {
            jQuery("#zoom-img").addClass("active");

        });
        jQuery("#zoom-img").on("click", function () {
            jQuery(this).removeClass("active hide");
        });
    }
});
