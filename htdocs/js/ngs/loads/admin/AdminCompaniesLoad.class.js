ngs.AdminCompaniesLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "companies";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_companies";
    },
    afterLoad: function () {
        jQuery("#logo_picture").change(function () {
            jQuery('#logo_picture_form').submit();
        });
        jQuery('#upload_photo_button, #user_profile_img').click(function () {
            jQuery("#logo_picture").trigger('click');
            return false;
        });
    }
});
