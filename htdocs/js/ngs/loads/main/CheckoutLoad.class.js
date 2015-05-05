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
        ngs.load('main_checkout_calculation', {'do_shipping': doShipping, 'region': shippingRegion, 'payment_type': jQuery('#payment_type input[type=radio]:checked').val()});

        var p_type_loader = jQuery("#main_loader").clone(false);
        jQuery("#checkout_confirm").append(p_type_loader);
        p_type_loader.removeClass("hidden");
    },
    checkoutConfirmPosition: function () {
        var top = jQuery("#checkout_confirm_container").offset().top;
        jQuery(document).on("scroll", function () {
            top = jQuery("#checkout_confirm_container").offset().top;
            console.log(top);
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
            if (jQuery(".f_ship_addr_container .f_checkbox").hasClass("checked")) {
                jQuery("#do_shipping").val(1);
            }
            else {
                jQuery("#do_shipping").val(0);
            }
            thisInstance.calculatePaymentDetails(jQuery(".f_payment_type.active").attr("p_type"));
        });
        jQuery('#shipping_region').change(function () {
            thisInstance.calculatePaymentDetails(jQuery(".f_payment_type.active").attr("p_type"));
        });

    },
    shippingDetailsChange: function () {
        var thisInstance = this;
        jQuery(".f_ship_addr_container input,.f_ship_addr_container select").on("change", function () {
            thisInstance.calculatePaymentDetails(jQuery(".f_payment_type.active").attr("p_type"));
        });
    },
    selectPaymentType: function () {
        var thisInstance = this;
        this.calculatePaymentDetails("cash");

        var p_type = jQuery("#payment_type .f_payment_type");
        p_type.on("click", function () {
            var self = jQuery(this);
            var p_type_panel = self.closest(".f_side_panel");
            p_type_panel.add(".f_side_panel_btn[data-side-panel="+p_type_panel.attr("data-side-panel")+"]").removeClass("active");
            
            if (!self.hasClass("active")) {
                p_type.siblings().removeClass("active");
                p_type.siblings().find("input").prop('checked', false);
                self.addClass("active");
                self.find("input").prop('checked', true);
                thisInstance.calculatePaymentDetails(self.attr("p_type"));
            }
        });
    },
    calculatePaymentDetails: function (type) {
        var p_type_loader = jQuery("#main_loader").clone(false);
        jQuery("#payment_details").html(p_type_loader);
        p_type_loader.removeClass("hidden");

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

        this.calculateShippingCost();
    }

});
