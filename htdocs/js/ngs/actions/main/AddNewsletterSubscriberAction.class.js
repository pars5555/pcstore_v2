ngs.AddNewsletterSubscriberAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "do_add_newsletter_subscriber";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            jQuery('#newsletter_error_message').html('');
            jQuery('#newsletter_success_message').html(data.message);
        } else if (data.status === "err") {
            jQuery('#newsletter_success_message').html('');
            jQuery('#newsletter_error_message').html(data.message);
        }
    }
});
