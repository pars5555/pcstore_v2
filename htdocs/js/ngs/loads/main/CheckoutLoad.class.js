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
        this.checkoutConfirmPosition();
        this.cellPhoneNumber();
        this.ConfirmCellPhoneNumberCode();
        this.selectPaymentType();
        this.shippingDetailsChange();
        ngs.nestLoad('main_checkout_calculation');
    },
    calculateShippingCost: function () {
        var shippingRegion = jQuery('#shipping_region').val();
        var doShipping = jQuery('.f_ship_addr_container .f_checkbox').hasClass('checked') ? 1 : 0;
        ngs.load('main_checkout_calculation', {'do_shipping': doShipping, 'region': shippingRegion});
    },
    checkoutConfirmPosition: function () {
        var top = jQuery("#checkout_confirm_container").offset().top + 30;
        jQuery(window).on("scroll", function () {
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
    },
    shippingAddrSlide: function () {
        var thisInstance = this;
        jQuery(".f_ship_addr_container .f_checkbox,.f_ship_addr_container .f_checkbox_label").click(function () {
            jQuery(".f_ship_addr_form").slideToggle(500);
            thisInstance.calculateShippingCost();
            thisInstance.sele
            if (jQuery(".f_ship_addr_container .f_checkbox").hasClass("checked")) {
                jQuery("#do_shipping").val(1);
            }
            else {
                jQuery("#do_shipping").val(0);
            }
            thisInstance.calculatePaymentDetails(jQuery(".f_payment_type.active").attr("p_type"));
        });
        jQuery('#shipping_region').change(function () {
            thisInstance.calculateShippingCost();
        });

    },
    shippingDetailsChange : function(){
        var thisInstance = this;
        jQuery(".f_ship_addr_container input,.f_ship_addr_container select").on("change",function(){
            thisInstance.calculatePaymentDetails(jQuery(".f_payment_type.active").attr("p_type"));            
        })
    },
    selectPaymentType: function () {
        var thisInstance = this;
        this.calculatePaymentDetails("cash");

        var p_type = jQuery("#payment_type .f_payment_type");
        p_type.on("click", function (event) {
            p_type.each(function () {
                jQuery(this).removeClass("active");
            });
            jQuery(this).addClass("active");
            thisInstance.calculatePaymentDetails(jQuery(this).attr("p_type"));

        });
    },
    
    calculatePaymentDetails: function (type) {
        var do_shipping = 0;
        var ship_params = null;
        if (jQuery(".f_ship_addr_container .f_checkbox").hasClass("checked") && jQuery("#do_shipping").val() == 1) {
            do_shipping = 1;
            ship_params = {
                recipientName: jQuery("#recipientName").val(),
                shipAddr: jQuery("#shipAddr").val(),
                shippingRegion: jQuery("#shipping_region").val(),
                shipCellTel: jQuery("#shipCellTel").val(),
                shipTel: jQuery("#shipTel").val()
            };
        }
        ngs.load("payment_" + type, {
            do_shipping: do_shipping,
            ship_params: JSON.stringify(ship_params)
        });
    }

});
