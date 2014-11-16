ngs.AdminUploadPriceLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function() {
        return "upload_price";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "admin_upload_price";
    },
    afterLoad: function() {
    
        this.onSelectPriceFileButtonClicked();
        this.initUploadPrice();
       
        this.revertCompanyLastPriceHandler();
    },
   
    revertCompanyLastPriceHandler: function () {
        jQuery("#revert_company_last_uploaded_price").click(function () {
            var company_id = jQuery(this).attr('company_id');
            jQuery("<div>" + 491 + "</div>").dialog({
                resizable: false,
                title: 483,
                modal: true,
                buttons: [{
                        text: 489,
                        click: function () {
                            jQuery(this).remove();
                            ngs.action('revert_company_last_price', {'company_id': company_id});
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
