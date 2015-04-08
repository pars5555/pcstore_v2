ngs.AdminNewsletterLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "newsletter";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_newsletter";
    },
    afterLoad: function () {
        this.initTinyMCE("textarea.msgBodyTinyMCEEditor");
        this.initButtons();
    },
    initButtons:function(){
        jQuery('#admin_load_newsletter_btn').click(function(){
            
        });
        jQuery('#admin_save_newsletter_btn').click(function(){
        });
        jQuery('#admin_manage_newsletter_btn').click(function(){
        });
    }
});
