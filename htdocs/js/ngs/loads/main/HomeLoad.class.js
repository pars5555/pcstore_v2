ngs.HomeLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "home";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "main_home";
    },
    afterLoad: function () {
        this.addListeners();
        this.listingCols();
        this.initAdminItemsCategoriesPopupButton();
        this.initAdminItemsPicturesPopupButton();
    },
    initAdminItemsCategoriesPopupButton: function () {
        jQuery(".f_admin_listing_item_categories_buttons").on("click", function () {
            var itemId = jQuery(this).attr('item_id');
            ngs.load('admin_item_categories_popup', {'item_id': itemId});
            ngs.MainLoad.prototype.mainLoader(true);
        });
        jQuery("#adminItemCategoriesPopup .close_button,#adminItemCategoriesPopup .overlay").click(function () {
            jQuery("#adminItemCategoriesPopup").removeClass("active");
        });
    },
    initAdminItemsPicturesPopupButton: function () {
        jQuery(".f_admin_listing_item_pictures_buttons").on("click", function () {
            var itemId = jQuery(this).attr('item_id');
            ngs.load('admin_item_pictures_popup', {'item_id': itemId});
            ngs.MainLoad.prototype.mainLoader(true);
        });
        jQuery("#adminItemPicturesPopup .close_button,#adminItemPicturesPopup .overlay").click(function () {
            jQuery("#adminItemPicturesPopup").removeClass("active");
        });
    },
    setInputValuesToHeaderhiddenInputs: function () {
        var cehcked = jQuery('#show_only_vat_items').is(':checked');
        jQuery("#show_only_vat_items_checkbox").val(cehcked ? 1 : 0);
        jQuery("#sort_by_input").val(jQuery("#sort_by").val());
        jQuery("#selected_company_id_input").val(jQuery("#selected_company_id").val());
    },
    addListeners: function () {
        var thisInstance = this;
        jQuery("#sort_by, #selected_company_id, #show_only_vat_items").change(function () {
            thisInstance.setInputValuesToHeaderhiddenInputs();
            jQuery('#search_text_form').trigger('submit');
        });
    },
    listingCols: function () {
        jQuery("#listing_cols_view .f_listing_cols_item").on("click tap", function () {
            jQuery("#listing_cols_select").val(jQuery(this).attr("data-value"));
            jQuery("#search_text_form").trigger("submit");
        });
    }
});
