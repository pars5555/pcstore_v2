ngs.CompanyDealersLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function () {
        return "dealers";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "company_dealers";
    },
    afterLoad: function () {
        this.messagePopup();
    },
    messagePopup: function () {
        jQuery(".f_dealers_popup .overlay,.f_dealers_popup .f_pop_up_confirm_btn,.f_dealers_popup .close_button").click(function () {
            jQuery(this).closest(".f_dealers_popup").removeClass("active hide");
        });
    }
});
