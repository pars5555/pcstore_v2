ngs.AdminImportIndexLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_import", ajaxLoader);
    },
    getUrl: function () {
        return "import_index";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_import_index";
    },
    afterLoad: function () {
        this.importAction();
    },
    importAction: function () {
        jQuery(".f_import_action_btn").on("click", function () {
            var type = jQuery(this).data("type");
            var acton = type + "_import";
            var company_id = jQuery("#import_index_company_id").val();

            ngs.action('import_steps_actions_group_action',
                    {
                        'action': acton,
                        'company_id': company_id
                    }
            );
        });
    }
});
