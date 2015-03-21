ngs.UserInviteLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "user", ajaxLoader);
    },
    getUrl: function () {
        return "invite";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "user_invite";
    },
    afterLoad: function () {
        this.userInviteForm();
    },
    userInviteForm: function () {
        jQuery('#userInviteForm').submit(function () {
            var email = jQuery(this).find('input').val();
            ngs.action('invite', {'email': email});
            return false;
        });
    }
});
