ngs.AdminMainLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "main";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_main";
    },
    afterLoad: function () {
        this.overlay();
        ngs.nestLoad(jQuery('#contentLoad').val());
    },
    overlay: function () {
        jQuery(".overlay").click(function () {
            jQuery(this).parent().addClass("hide");
        });
    },
});
