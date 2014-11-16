ngs.CompanyUploadPriceLoad = Class.create(ngs.AbstractLoad, {
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

        this.onSelectPriceFileButtonClicked();
        this.initUploadPrice();
        var thisInstance = this;
        jQuery('#save_price_email').click(function () {
            thisInstance.onSavePriceEmail();
        });
        jQuery('#send_price_email').click(function () {
            thisInstance.onSendPriceEmail();
        });
        this.addChangeHandlerToFormatRecipients();
        this.revertCompanyLastPriceHandler();
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
    revertCompanyLastPriceHandler: function () {
        jQuery("#revert_company_last_uploaded_price").click(function () {
            jQuery("<div>" + 491 + "</div>").dialog({
                resizable: false,
                title: 483,
                modal: true,
                buttons: [{
                        text: 489,
                        click: function () {
                            var company_id = jQuery('#up_selected_company').val();
                            jQuery(this).remove();
                            ngs.action('revert_company_last_price_action', {'company_id': company_id});
                        }
                    },
                    {
                        text: 49,
                        click: function () {
                            jQuery(this).remove();
                        }
                    }
                ],
                close: function () {
                    jQuery(this).remove();
                }
            });
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
        ngs.action("send_price_email", {"save_only": 0, "subject": subject, "body": body, "to": to, "from_email": jQuery('#sender_email').val()});
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
    addRemoveCompanyPriceClickHandler: function (elements_array) {
        for (var i = 0; i < elements_array.length; i++) {
            var price_id = elements_array[i].id.substr(elements_array[i].id.indexOf("^") + 1);
            elements_array[i].onclick = this.onRemoveCompanyPrice.bind(this, price_id);
        }
    },
    onRemoveCompanyPrice: function (price_id) {
        var answer = confirm("Are you sure you want to remove the price?");
        if (answer) {
            ngs.action('remove_company_price_action', {"price_id": price_id});
        }
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
    },
    onSelectedCompanyChanged: function () {
        ngs.load('upload_price', {
            'selected_company': $('up_selected_company').value
        });
    },
    onSelectPriceFileButtonClicked: function () {
        jQuery('#select_price_file_button, #up_selected_file_name').click(function () {
            var inpFile = $("company_price_file_input");
            inpFile.click();
            inpFile.onchange = function () {
                $('up_selected_file_name').value = this.value;
                //$("company_price_file_input").submit();
            };

        });
    },
    initUploadPrice: function () {
        var thisInstance = this;
        jQuery('#upload_company_price_button').click(function () {
            if (thisInstance.validateUploadForm()) {
                jQuery(this).css({'visibility': 'hidden'});
                jQuery('#price_upload_form').trigger('submit');
            }
        });
    },
    validateUploadForm: function () {
        //todo validate
        return true;
    }
});
