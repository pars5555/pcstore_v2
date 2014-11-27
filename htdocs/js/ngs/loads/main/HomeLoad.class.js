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
        this.sortBy();
    },
    sortBy: function () {
        jQuery(".f_select_filter, #selected_company_id").change(function () {
            jQuery('#search_text_form').trigger('submit');
        });
    }
});
