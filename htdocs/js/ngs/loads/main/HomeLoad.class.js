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
        this.initAdminItemsCategoriesPopupButtons();
    },
    initAdminItemsCategoriesPopupButtons: function () {
        var modal = jQuery("#adminItemCategoriesPopup .f_modal_content");
        jQuery(".f_admin_listing_item_categories_buttons").on("click", function () {
            ngs.load('admin_item_categories_popup', {});
            jQuery("#adminItemCategoriesPopup").removeClass("hide");
            modal.addClass("active");
        });
        jQuery("#adminItemCategoriesPopup .close_button,#adminItemCategoriesPopup .overlay").click(function () {
            modal.removeClass("active");
            jQuery("#adminItemCategoriesPopup").addClass("hide");
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
        jQuery("#listing_cols").on("change", function () {
            jQuery("#listing_cols_select").val(jQuery(this).val());
            jQuery("#search_text_form").trigger("submit");
        });
    }
});
