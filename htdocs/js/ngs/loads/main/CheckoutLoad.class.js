ngs.CheckoutLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
    },
    getUrl: function () {
        return "checkout";
    },
    getMethod: function () {
        return "POST";
    },
    getContainer: function () {
        return "content";
    },
    getName: function () {
        return "main_checkout";
    },
    afterLoad: function () {
        this.checkoutStepsMenus();
        this.sendCellNumber();

    },
    checkoutStepsMenus: function () {
        this.shippingAddrSlide();
        this.checkoutConfirm();
        this.cellPhoneNumber();
        this.ConfirmCellPhoneNumberCode();
        ngs.nestLoad('main_checkout_calculation');
    },
    shippingAddrSlide: function () {
        var thisInstance = this;
        jQuery(".f_ship_addr_container .f_checkbox,.f_ship_addr_container .f_checkbox_label").click(function () {
            jQuery(".f_ship_addr_form").slideToggle(500);
            thisInstance.calculateShippingCost();
            if (jQuery(".f_ship_addr_container .f_checkbox").hasClass("checked")) {
                jQuery("#do_shipping").val(1);
            }
            else{
                jQuery("#do_shipping").val(0);            
            }
        });
        jQuery('#shipping_region').change(function () {
            thisInstance.calculateShippingCost();
        });

    },
    calculateShippingCost: function () {
        var shippingRegion = jQuery('#shipping_region').val();
        var doShipping = jQuery('.f_ship_addr_container .f_checkbox').hasClass('checked') ? 1 : 0;
        ngs.load('main_checkout_calculation', {'do_shipping': doShipping, 'region': shippingRegion});
    },
    checkoutConfirm: function () {
        var top = jQuery("#checkout_confirm_container").offset().top;
        jQuery(window).scroll(function () {
            var scrollTop = jQuery(window).scrollTop();
            if (scrollTop >= top) {
                jQuery("#checkout_confirm").addClass("fixed");
            }
            else {
                jQuery("#checkout_confirm").removeClass("fixed");
            }
            ;
        });
    },
    sendCellNumber: function () {
        jQuery("#receive_sms_form").submit(function () {
            ngs.action("confirm_cell_phone_number", {
                cell_phone_num: jQuery("#confirm_phone_number").val()
            });
            return false;
        });
    },
    cellPhoneNumber: function () {        
        jQuery("#cell_phone_number .close_button,#cell_phone_number .overlay").click(function () {
            jQuery("#cell_phone_number").addClass("hide");
             jQuery("#cell_phone_number .error").html("").slideUp(0);
        });
    },
    ConfirmCellPhoneNumberCode: function () {
        jQuery("#confirm_code_form").submit(function () {
            ngs.action("confirm_cell_phone_number_code", {
                confirm_code: jQuery("#confirm_code").val()
            });
            return false;
        });
        jQuery("#cell_phone_number_confirm .close_button,#cell_phone_number_confirm .overlay").click(function () {
            jQuery("#cell_phone_number_confirm").addClass("hide");
            jQuery("#confirm_code").val("");
            jQuery("#cell_phone_number_confirm .error").html("").slideUp(0);
        });
    }

});
