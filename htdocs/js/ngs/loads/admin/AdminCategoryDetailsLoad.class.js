ngs.AdminCategoryDetailsLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "category_details";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "admin_categoy_details_container";
    },
    getName: function () {
        return "admin_category_details";
    },
    afterLoad: function () {
        jQuery('#ac_save').click(function () {
            var categoryId = jQuery('#ac_category_id').val();
            var name = jQuery('#ac_display_name').val();
            var isLastClickable = jQuery('#ac_is_last_clickable').prop('checked');
            ngs.action('change_category_attributes',
                    {'category_id': categoryId, 'name': name, 'is_last_clickable': isLastClickable ? 1 : 0});
        });
        jQuery('#ac_reset').click(function () {
            var categoryId = jQuery('#ac_category_id').val();
            ngs.load('admin_category_details', {'category_id': categoryId});
        });
        jQuery('#ac_remove_category').click(function () {
            var categoryId = jQuery('#ac_category_id').val();
            ngs.action('remove_category', {'category_id': categoryId});
        });
        jQuery('#ac_move_up').click(function () {
            var categoryId = jQuery('#ac_category_id').val();
            ngs.action('change_category_order', {'category_id': categoryId, 'move_up': 1});
        });
        jQuery('#ac_move_down').click(function () {
            var categoryId = jQuery('#ac_category_id').val();
            ngs.action('change_category_order', {'category_id': categoryId, 'move_up': 0});
        });
        jQuery('#ac_add_child_category').click(function () {
            var categoryId = jQuery('#ac_category_id').val();
            var category_title = prompt("Please enter category title", "");
            if (category_title != null && category_title.trim().length > 0) {
                ngs.action("add_category", {
                    "title": category_title,
                    "parent_category_id": categoryId
                });
            }
        });
    }
});
