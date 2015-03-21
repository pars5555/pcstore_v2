ngs.ServiceCompanyBranchesLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "servicecompany", ajaxLoader);
    },
    getUrl: function () {
        return "branches";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "servicecompany_branches";
    },
    afterLoad: function () {
        this.wrapSelect();
        this.branchPopUp();
        this.removeCompanyBranch();
    },
    wrapSelect: function () {
        jQuery("#working_hours select").wrap("<div class='select_wrapper' />");
    },
    branchPopUp: function () {
        var branch_pop_up = jQuery(".branch_pop_up");
        jQuery("#branch_btn").click(function () {
            branch_pop_up.removeClass("hide");
            branch_pop_up.addClass("active");
        });
        jQuery(".branch_pop_up .close_button,.branch_pop_up .overlay").click(function () {
            branch_pop_up.removeClass("active");
            branch_pop_up.addClass("hide");
        });
    },
    removeCompanyBranch: function () {
        jQuery(".f_remove_branch").on("click", function (event) {
            event.stopPropagation();
            event.preventDefault();

            var popup_title = jQuery("#remove_branch_popup_title").val();
            var popup_content = jQuery("#remove_branch_popup_content").val();
            var popup_yes = jQuery("#remove_branch_popup_yes").val();
            var popup_cancel = jQuery("#remove_branch_popup_cancel").val();
            var selected_branch_id = jQuery(this).closest(".f_com_br_item").attr("data-branch-id");

            function confirm_function() {
                jQuery("#branch_id_for_remove").val(selected_branch_id);
                jQuery("#remove_branch_form").trigger("submit");
            }

            ngs.MainLoad.prototype.initPopup(popup_title, popup_content, popup_yes, popup_cancel, confirm_function);
        });
    }
});
