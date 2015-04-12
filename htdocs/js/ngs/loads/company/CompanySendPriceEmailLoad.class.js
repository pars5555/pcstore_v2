ngs.CompanySendPriceEmailLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "upload_price";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "company_upload_price";
    },
    afterLoad: function () {


        var thisInstance = this;
        jQuery('#save_price_email').click(function () {
            thisInstance.onSavePriceEmail();
        });
        jQuery('#send_price_email').click(function () {
            thisInstance.onSendPriceEmail();
            jQuery("#main_loader").removeClass("hidden");
        });
        this.addChangeHandlerToFormatRecipients();

        this.initCompanyFileAttachment();
        this.initTinyMCE("textarea.msgBodyTinyMCEEditor");
    },
    initCompanyFileAttachment: function () {
        jQuery('#company_attach_new_file_button').click(function () {
            jQuery('#company_attach_file_input').trigger('click');
            jQuery('#company_attach_file_input').change(function () {
                jQuery('#up_add_attachment_form').trigger('submit');
            });
        });
        jQuery('#company_email_attachments_container').on('click', '.f_up_delete_attachment', function () {
            var file_name = jQuery(this).attr('file_real_name');
            ngs.action('delete_attachment', {"file_name": file_name});
            jQuery(this).parent().remove();
        });
    },
    validateEmail: function (email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    },
    onSendPriceEmail: function ()
    {
        if (!this.validateEmail(jQuery('#sender_email').val()))
        {
            jQuery('#sender_email').css({'border': '1px solid red'});
            jQuery(window.self).scrollTop(0);
            return false;
        } else
        {
            jQuery('#sender_email').css({'border': 'auto'});
        }
        tinyMCE.activeEditor.save();
        var subject = jQuery('#price_email_subject').val();
        var body = document.getElementsByName('price_email_body')[0].value;
        var to = jQuery('#dealer_emails_textarea').val();
        var attache_last_price = jQuery('#attache_last_price').is(":checked") ? 1 : 0;
        var sender_email = jQuery('#sender_email').val();
        ngs.action("send_price_email", {"save_only": 0, "subject": subject, "body": body, "to": to, "from_email": sender_email, "attache_last_price": attache_last_price});
        return false;
    },
    onSavePriceEmail: function ()
    {
        tinyMCE.activeEditor.save();
        var subject = jQuery('#price_email_subject').val();
        var body = document.getElementsByName('price_email_body')[0].value;
        var to = jQuery('#dealer_emails_textarea').val();
        ngs.action("send_price_email", {"save_only": 1, "subject": subject, "body": body, "to": to, "from_email": jQuery('#sender_email').val()});
        return false;
    },
    addChangeHandlerToFormatRecipients: function ()
    {
        var thisInstance = this;
        jQuery('#dealer_emails_textarea').on('change cut paste keydown', function () {
            if (thisInstance.timer) {
                window.clearTimeout(thisInstance.timer);
            }
            thisInstance.timer = window.setTimeout(function () {
                ngs.action("format_price_email_recipients", {"to_emails": $('dealer_emails_textarea').value});
            }, 2000);
        });
        jQuery('#dealer_emails_textarea').on('blur', function () {
            if (thisInstance.timer) {
                window.clearTimeout(thisInstance.timer);
            }
            ngs.action("format_price_email_recipients", {"to_emails": $('dealer_emails_textarea').value});
        });
    }

});
