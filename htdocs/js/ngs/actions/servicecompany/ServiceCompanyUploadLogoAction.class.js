ngs.ServiceCompanyUploadLogoAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "do_upload_logo";
    },
    getMethod: function () {
        return "POST";
    },
    afterAction: function (transport) {
        var data = transport.evalJSON();
        if (data.status === "ok") {
            jQuery('#logo_img').attr('src', '/img/tmp/service_company_' + data.company_id + '_logo_120_75.png');
            jQuery('#change_company_logo').val(1);
        } else if (data.status === "err") {
            alert(data.message);
        }
    }
});
