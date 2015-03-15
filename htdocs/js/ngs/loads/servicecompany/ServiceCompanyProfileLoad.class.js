ngs.ServiceCompanyProfileLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "servicecompany", ajaxLoader);
    },
    getUrl: function () {
        return "profile";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "servicecompany_profile";
    },
    afterLoad: function () {

        jQuery("#logo_picture").change(function () {
            jQuery('#logo_picture_form').submit();
        });
        jQuery('#upload_photo_button, #user_profile_img, #logo_img').click(function () {
            jQuery("#logo_picture").trigger('click');
            return false;
        });
    }
});
