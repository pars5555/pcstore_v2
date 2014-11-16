ngs.AdminSettingsLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function() {
        return "settings";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "admin_settings";
    },
    afterLoad: function() {
    }
});
