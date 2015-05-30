ngs.AdminOpenNewsletterAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_newsletter", ajaxLoader);
    },
    getUrl: function () {
        return "do_open_newsletter";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === 'ok')
        {
            var html = data.html;
            tinyMCE.activeEditor.setContent(html, {format: 'raw'});
            var newsletter_title = data.newsletter_title;
            jQuery('#nl_newsletter_title').html(newsletter_title);
        } else
        {
            alert(data.message);
        }
    }
});
