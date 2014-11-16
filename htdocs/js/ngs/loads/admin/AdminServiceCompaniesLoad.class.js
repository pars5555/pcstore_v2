ngs.AdminServiceCompaniesLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "service_companies";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_service_companies";
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
