ngs.AdminItemPicturesPopupLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "item_pictures_popup";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "adminItemPicturesPopupBody";
    },
    getName: function () {
        return "admin_item_pictures_popup";
    },
    afterLoad: function () {
        jQuery('#ip_select_picture_button').click(function () {
            jQuery("#ip_file_input").trigger('click');
            return false;
        });

        jQuery("#ip_file_input").change(function () {
            jQuery('#ip_add_item_picture_form').submit();
        });

        jQuery(".ip_remove_item_picture_x").click(function () {
            var item_id = jQuery(this).attr('item_id');
            var picture_index = jQuery(this).attr('picture_index');
            ngs.action('admin_add_remove_item_picture', {'action': 'delete', 'item_id': item_id, 'picture_index': picture_index});
        });
        jQuery(".ip_default_item_picture").click(function () {
            var item_id = jQuery(this).attr('item_id');
            var picture_index = jQuery(this).attr('picture_index');
            ngs.action('admin_add_remove_item_picture', {'action': 'make_default', 'item_id': item_id, 'picture_index': picture_index});
        });
    }
});
