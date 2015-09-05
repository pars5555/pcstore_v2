ngs.AdminImportStep1Load = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin_import", ajaxLoader);
    },
    getUrl: function () {
        return "import_step1";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_import_step1";
    },
    afterLoad: function () {
        this.getData();
        this.checkAll();
    },
    getData: function () {
        jQuery("#step_1_form").on("click", function (event) {
            event.preventDefault();
            var checked_array = [];
            var select_values = {};

            jQuery("#step1Container input[type='checkbox']:checked:not(.f_check_all)").each(function () {
                checked_array.push(jQuery(this).data("row-id"));
            });
            jQuery("#selected_row_ids").val(checked_array.join());

            jQuery("#step1Container select").each(function () {
                if (jQuery(this).val() != 0) {
                    select_values[jQuery(this).data("name")] = jQuery(this).val();
                }
            });
            jQuery("#select_values").val(JSON.stringify(select_values));

            if (checked_array.length > 0) {
                jQuery(this).closest("form").submit();
            }
        });
    },
    checkAll: function () {
        var checkAll = jQuery("#step1Container .f_check_all")
        checkAll.on("click", function () {
            jQuery("#step1Container input[type='checkbox']").prop("checked", jQuery(this).prop("checked"));
        });
    }
});
