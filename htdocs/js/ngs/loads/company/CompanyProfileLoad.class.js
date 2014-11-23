ngs.CompanyProfileLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
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
        return "company_profile";
    },
    afterLoad: function () {
        this.initLogoUpload();
    },
    initLogoUpload: function () {

        jQuery("#logo_picture").change(function () {
            jQuery('#logo_picture_form').submit();
        });
        jQuery('#upload_photo_button, #user_profile_img, #logo_img').click(function () {
            jQuery("#logo_picture").trigger('click');
            return false;
        });
    }
});
