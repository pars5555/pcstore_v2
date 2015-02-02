ngs.ConfirmCellPhoneNumberCodeAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "do_confirm_cell_phone_number_code";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            jQuery("#cell_phone_number_confirm").addClass("hide");   
            jQuery("#confirm_code").val("");
            jQuery("#cell_phone_number_confirm .error").html("").slideUp(0);
            
            jQuery("#sms_confirm_code").val(this.params.confirm_code);            
            jQuery("#checkout_form").trigger('submit');            
        } else if (data.status === "err") {
            jQuery("#cell_phone_number_confirm .error").html(data.message).slideDown(300);
        }
    }
});
