ngs.ItemLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function() {
        return "item";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "main_item";
    },
    afterLoad: function() {
        this.changeMainPicture();
        this.zoomProductImage();
    },
    changeMainPicture : function(){
        jQuery("#product-other-images .f_poi_item").on("click",function(){
            jQuery(".f_product_img,#zoom-img .f_zoom_img").attr("style",jQuery(this).attr("style"));
            jQuery(this).addClass("active");
            jQuery(this).siblings().removeClass("active");
        });
    },
    zoomProductImage : function(){
        jQuery(".f_product_img").on("click",function(){
            jQuery("#zoom-img").addClass("active");
            
        });
        jQuery("#zoom-img").on("click",function(){
            jQuery(this).removeClass("active hide");
        });
    }
});
