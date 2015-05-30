ngs.AdminSendNewsletterAction = Class.create(ngs.AbstractAction, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_newsletter", ajaxLoader);
    },
    getUrl: function() {
        return "do_send_newsletter";
    },
    getMethod: function() {
        return "POST";
    },
    beforeAction: function() {
    },
    afterAction: function(transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            alert("Successfully sent to " + data.count + " emails!");
        } else if (data.status === "err") {
            alert(data.message);
        }
    }
});
