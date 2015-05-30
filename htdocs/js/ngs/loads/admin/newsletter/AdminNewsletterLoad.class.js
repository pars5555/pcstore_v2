ngs.AdminNewsletterLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_newsletter", ajaxLoader);
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
    initButtons: function () {
        jQuery('#admin_load_newsletter_btn').click(function () {
            jQuery('.pop_up_container').removeClass('hide');
            ngs.load('admin_open_newsletter', {});
        });
        jQuery('#admin_save_newsletter_btn').click(function () {
            jQuery('.pop_up_container').removeClass('hide');
            ngs.load('admin_save_newsletter', {});

        });
        jQuery('#admin_manage_newsletter_btn').click(function () {
            jQuery('.pop_up_container').removeClass('hide');
            ngs.load('admin_manage_newsletters', {});

        });
        jQuery('#admin_send_newsletter_btn').click(function () {
            tinyMCE.activeEditor.save();
            var bodyHTML = jQuery('#sc_newsletter_html').val();
            ngs.action('admin_send_newsletter', {
                'include_all_active_users': jQuery('#send_to_all_registered_users').is(':checked'),
                "email_body_html": bodyHTML,
                'test': 0
               
            });
        });
        jQuery('#admin_test_newsletter_btn').click(function () {
            tinyMCE.activeEditor.save();
            var bodyHTML = jQuery('#sc_newsletter_html').val();
            ngs.action('admin_send_newsletter', {
                "email_body_html": bodyHTML,
                'test': 1,
                'test_email': 'info@pcstore.am'
            });
        });

    }
});
