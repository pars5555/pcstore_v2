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
        this.sortByValues();
        this.sortBy();
    },
    sortByValues: function () {
        jQuery("#sort_by_input").val(jQuery("#sort_by").val());
        jQuery("#selected_company_id_input").val(jQuery("#selected_company_id").val());
    },
    sortBy: function () {
        jQuery("#sort_by, #selected_company_id").change(function () {
            if (jQuery(this).attr("id") === "sort_by") {
                jQuery("#sort_by_input").val(jQuery(this).val());
            }
            if (jQuery(this).attr("id") === "selected_company_id") {
                jQuery("#selected_company_id_input").val(jQuery(this).val());
            }
            jQuery('#search_text_form').trigger('submit');
        });
    }
});
