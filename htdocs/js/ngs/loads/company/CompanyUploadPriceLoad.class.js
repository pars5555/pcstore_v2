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

        this.revertCompanyLastPriceHandler();

    },
    revertCompanyLastPriceHandler: function () {
        jQuery("#revert_company_last_uploaded_price").click(function () {

            var title = jQuery(".f_revert_popup_title").val();
            var text = jQuery(".f_revert_popup_text").val();
            var yes = jQuery(".f_revert_popup_yes").val();
            var cancel = jQuery(".f_revert_popup_cancel").val();

            function confirm_click() {
                ngs.action('revert_company_last_price', {});
            }

            ngs.MainLoad.prototype.initPopup(title, text, yes, cancel, confirm_click);

        });
    },
    onRemoveCompanyPrice: function (price_id) {
        var answer = confirm("Are you sure you want to remove the price?");
        if (answer) {
            ngs.action('remove_company_price_action', {"price_id": price_id});
        }
    },
    onSelectPriceFileButtonClicked: function () {
        jQuery('#select_price_file_button, #up_selected_file_name').click(function () {
            var inpFile = $("company_price_file_input");
            inpFile.click();
            inpFile.onchange = function () {
                jQuery('#up_selected_file_name').val(this.value);
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
