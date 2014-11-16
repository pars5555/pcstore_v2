ngs.CompanySmsconfLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "smsconf";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "company_smsconf";
    },
    afterLoad: function () {
        this.initTimeControl();

    },
    initTimeControl: function () {
        jQuery('#sms_time_control').change(function () {
            jQuery('#smsTimeControlContainer').css({'display': jQuery(this).is(":checked") ? 'block' : 'none'});
        });
    }
});
