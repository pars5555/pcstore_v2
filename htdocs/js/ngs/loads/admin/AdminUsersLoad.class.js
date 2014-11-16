ngs.AdminUsersLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function() {
        return "users";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "f_admin_config_user_management_container";
    },
    getName: function() {
        return "admin_users";
    },
    afterLoad: function() {       
        jQuery('.aum_delete_user_buttons').click(function() {
            var user_id = jQuery(this).attr('user_id');
            ngs.DialogsManager.actionOrCancelDialog('Delete', '', true, '', 'Warning!', '<div>Are you sure you want to delete the user?</div>', function() {
                
                ngs.action('admin_group_actions', {'action': 'delete_user', 'user_id': user_id});
            });
        });
    }
});