ngs.ConfirmCellPhoneNumberAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "do_confirm_cell_phone_number";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        if (data.status === "ok") {
            jQuery("#cell_phone_number").addClass("hide");
            jQuery("#cell_phone_number_confirm").removeClass("hide");            
        } else if (data.status === "err") {
            jQuery("#cell_phone_number .error").html(data.message).slideDown(300);
        }
    }
});
