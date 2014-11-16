ngs.FormatPriceEmailRecipientsAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "do_format_price_email_recipients";
    },
    getMethod: function () {
        return "POST";
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            jQuery('#dealer_emails_textarea').val(data.valid_email_addresses);
            var count = data.valid_email_addresses === '' ? 0 : data.valid_email_addresses.split(";").length;
            jQuery('#total_price_email_recipients_number').html(count);
        } else if (data.status === "err") {

        }
    }
});
