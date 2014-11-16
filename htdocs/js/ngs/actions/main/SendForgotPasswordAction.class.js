ngs.SendForgotPasswordAction = Class.create(ngs.AbstractAction, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "do_send_forgot_password";
    },
    getMethod: function () {
        return "POST";
    },
    beforeAction: function () {
    },
    afterAction: function (transport) {
        var data = transport.responseText.evalJSON();
        jQuery('#forgotPasswordForm').find('input, button').removeAttr('disabled');
        if (data.status === "ok") {
            jQuery('#forgotPasswordErrorMessage').html('');
            jQuery('#forgotPasswordSuccessMessage').html(data.message);
        } else if (data.status === "err") {
            jQuery('#forgotPasswordSuccessMessage').html('');
            jQuery('#forgotPasswordErrorMessage').html(data.message);
        }
    }
});
