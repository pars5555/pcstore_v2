ngs.AdminMainLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "admin", ajaxLoader);
    },
    getUrl: function () {
        return "main";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "admin_main";
    },
    afterLoad: function () {
        this.overlay();
        this.checkbox();
        this.popupClose();
        ngs.nestLoad(jQuery('#contentLoad').val());
    },
    overlay: function () {
        jQuery(".overlay").click(function () {
            jQuery(this).parent().addClass("hide");
        });
    },
    checkbox: function () {
        jQuery(".f_checkbox_label").on("click", function () {
            jQuery(this).siblings(".f_checkbox").trigger("click");
        });
        jQuery(".f_checkbox").on("click", function () {
            jQuery(this).toggleClass("checked");
            var checkbox = jQuery(this).find("input[type='checkbox']");
            if (jQuery(this).hasClass("checked")) {
                checkbox.prop("checked", true);
            }
            else {
                checkbox.prop("checked", false);
            }
        });
    },
    popupClose: function () {
        var mainPopup = jQuery(".main_pop_up");
        mainPopup.find(".overlay").add(mainPopup.find(".f_pop_up_cancel_btn")).add(mainPopup.find(".close_button")).on("click tap", function () {
            mainPopup.removeClass("active hide");
        });
    }
});
