ngs.UploadPriceAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "do_upload_price";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.evalJSON();
        jQuery('#upload_company_price_button').css({'visibility': 'visible'});
        if (data.status === "ok") {
            jQuery('#price_upload_form').trigger('reset');
            alert('514'+ "513");
        } else if (data.status === "war") {
            this.showConfirmOrMergePriceDialog();
        } else if (data.status === "err") {

            alert('583:' + data.errText);
        }
    },
    showConfirmOrMergePriceDialog: function () {
        jQuery("<div>" + 616 + "</div>").dialog({
            resizable: false,
            title: 483,
            show: {effect: "slide", direction: "up", duration: 400},
            hide: {effect: "slide", direction: "up", duration: 400},
            modal: true,
            buttons: [
                {
                    text: 617,
                    click: function () {
                        jQuery('#merge_uploaded_price_into_last_price').prop('checked', true);
                        jQuery('#price_upload_form').submit();
                        jQuery(this).remove();
                    }
                },
                {
                    text: 321,
                    click: function () {
                        jQuery('<input type="hidden" name="new_price_confirmed" value="1"/>').appendTo('#price_upload_form');
                        jQuery('#price_upload_form').submit();
                        jQuery(this).remove();
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
    }
});
