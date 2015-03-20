ngs.MainLoad = Class.create(ngs.AbstractLoad, {
    initialize: function ($super, shortCut, ajaxLoader) {
        $super(shortCut, "main", ajaxLoader);
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
        return "main";
    },
    afterLoad: function () {
        this.initLoginFunctionallity();
        this.initLanguages();
        this.initSocialLogout();
        this.initGoogleLogoutOnWindowUnload();
        this.newsLetterBlockController();
        this.initForgotPassword();
        ngs.action('ping_pong', {});
        this.leftMenu();
        this.overlay();
        this.leftPanelActiveElement();
        this.checkbox();
        ngs.nestLoad(jQuery('#contentLoad').val());

        this.notifications();
        this.mainPopupActions();
        this.categoriesProductCheckbox();
        this.pccLoader();
    },
    pccLoader: function () {
        jQuery("#pcc_loader").addClass("hidden");
        jQuery(".f_current_item_block,.f_component").on("click", function () {
            jQuery("#pcc_loader").removeClass("hidden");
        });
    },
    initPopup: function (title, content, confirm, cancel, confirm_click) {
        var default_title = jQuery("#main_popup_default_title").val();
        var default_content = jQuery("#main_popup_default_content").val();
        var default_confirm_btn = jQuery("#main_popup_default_confirm_btn").val();
        var default_cancel_btn = jQuery("#main_popup_default_cancel_btn").val();

        title = typeof title === 'undefined' ? default_title : title;
        content = typeof content === 'undefined' ? default_content : content;
        confirm = typeof confirm === 'undefined' ? default_confirm_btn : confirm;

        if (typeof cancel === 'undefined') {
            jQuery(".f_pop_up_cancel_btn").remove();
        }
        else {
            jQuery("#mainPopup .f_pop_up_cancel_btn").html(cancel);
        }

        jQuery("#mainPopup").addClass("active");
        jQuery("#mainPopup .f_pop_up_title").html(title);
        jQuery("#mainPopup .f_pop_up_content").html(content);
        jQuery("#mainPopup .f_pop_up_confirm_btn").html(confirm);


        jQuery("#mainPopup .f_pop_up_confirm_btn").on("click", function () {
            if (typeof confirm_click === "function") {
                confirm_click();
            }
            jQuery("#mainPopup").removeClass("active hide");

        });
    },
    mainPopupActions: function () {
        jQuery("#mainPopup .overlay,#mainPopup .f_pop_up_cancel_btn,#mainPopup .close_button").click(function () {
            jQuery("#mainPopup").removeClass("active hide");
        });
        jQuery(".f_main_pop_up_container .overlay,.f_main_pop_up_container .f_pop_up_confirm_btn,.f_main_pop_up_container .close_button").click(function () {
            jQuery(this).closest(".f_main_pop_up_container").removeClass("active hide");

        });
    }
    ,
    notifications: function () {
        jQuery("#notification").on("click", function () {
            jQuery(this).removeClass("new_notification");
            window.localStorage.setItem("unreadNotificationExist", "");
        });
    }
    ,
    initGoogleLogoutOnWindowUnload: function () {
        window.onbeforeunload = function (e) {
            if (typeof gapi.auth !== 'undefined') {
                gapi.auth.signOut();
            }
        };
    },
    leftPanelActiveElement: function () {
        jQuery(".sidebar-nav a").each(function () {
            if (jQuery(this).attr("href") == window.location.href) {
                jQuery(this).addClass("active");
            }
            ;
        });
    },
    initForgotPassword: function () {
        jQuery('#forgotPasswordForm').submit(function () {
            jQuery(this).find('#forgotPasswordEmailInput').attr('disabled', 'disabled');
            ngs.action('send_forgot_password', {'email': jQuery('#forgotPasswordEmailInput').val()});
            return false;
        });
    },
    newsLetterBlockController: function () {
        jQuery("#newsLetterInp").focus(function () {
            jQuery("#newsLetterAboveBlock").stop(true, false).slideDown();
        });
        jQuery("#newsLetterInp").focusout(function () {
            jQuery("#newsLetterAboveBlock").stop(true, false).slideUp();
        });
        jQuery('#newsletterSubscribeBtn').click(function () {
            var email = jQuery('#newsLetterInp').val();
            ngs.action('add_newsletter_subscriber', {'email': email});
        });
    },
    initSocialLogout: function () {
        jQuery('#mainLogoutBtn').click(function () {
            if (typeof gapi.auth !== 'undefined') {
                gapi.auth.signOut();
            }
            if (typeof IN !== 'undefined' && typeof IN.User !== 'undefined') {
                IN.User.logout();
            }
            if (typeof FB !== 'undefined') {
                FB.getLoginStatus(function (response) {
                    if (response && response.status === 'connected') {
                        FB.logout(function (response) {
                        });
                    }
                });
            }
            return true;
        });

    },
    initLanguages: function () {
        jQuery('.mainSetLanguage').click(function () {
            var l = jQuery(this).attr('lang');
            ngs.action('set_language', {lang: l});
            return false;
        });

        jQuery("#navMenu .dropdown-toggle").click(function () {
            jQuery(this).siblings(".dropdown-menu").slideToggle(500);
            if (jQuery(this).hasClass("active")) {
                jQuery(this).removeClass("active");
            }
            else {
                jQuery(this).addClass("active");
            }
            jQuery("body").click(function (event) {
                if (!jQuery(event.target).hasClass("dropdown-menu") && !jQuery(event.target).hasClass("dropdown-toggle") || jQuery(event.target).parents("#navMenu").length < 1) {
                    jQuery("#navMenu .dropdown-menu").slideUp(500);
                    jQuery("#navMenu .dropdown-toggle").removeClass("active");
                }
                if (jQuery(event.target).hasClass("dropdown-toggle") && jQuery(event.target).parents("#navMenu").length > 0) {
                    jQuery(event.target).closest(".f_dropdown").siblings(".f_dropdown").children(".dropdown-toggle").removeClass("active");
                    jQuery(event.target).closest(".f_dropdown").siblings(".f_dropdown").children(".dropdown-menu").slideUp(500);
                }
                ;
            });
        });

    },
    initLoginFunctionallity: function () {
        var modal = jQuery("#myModal .f_modal_content");
        jQuery(".f_myModal_toggle").on("click", function () {
            jQuery("#myModal").removeClass("hide");
            modal.addClass("active");
        });
        jQuery("#myModal .close_button,#myModal .overlay").click(function () {
            modal.removeClass("active");
            jQuery("#myModal").addClass("hide");
        });

        jQuery("#forgot_pass").click(function () {
            jQuery("#forgotModal .f_modal_content").addClass("active");
            jQuery("#forgotModal").removeClass("hide");
        });
        jQuery("#forgotModal .close_button,#forgotModal .overlay").click(function () {
            jQuery("#forgotModal .f_modal_content").removeClass("active");
            jQuery("#forgotModal").addClass("hide");
        });

        ngs.checkLogin = true;
        var thisInstace = this;
        jQuery('#mainLoginBtn').click(function () {
            thisInstace.login();
            return false;
        });
        jQuery('#mainLoginForm').submit(function (e) {
            thisInstace.login();
            e.preventDefault();
            return false;
        });
    },
    login: function () {
        var email = jQuery('#mainLoginEmail').val();
        var password = jQuery('#mainLoginPassword').val();
        ngs.action('login', {email: email, password: password});
    },
    leftMenu: function () {
        jQuery("#mainLeftPanel ul li").has("ul").addClass("dropdown");

        jQuery("#mainLeftPanel .dropdown-toggle").click(function (event) {
            event.preventDefault();
            var closest_li = jQuery(this).closest("li");

            if (closest_li.hasClass("opened")) {
                closest_li.removeClass("opened");
                closest_li.children("ul").slideUp(500);
                if (!jQuery(this).parents("li").hasClass("opened")) {
                }
            }
            else {
                if (!jQuery(this).parents("li").hasClass("opened")) {
                    jQuery("#mainLeftPanel li").removeClass("opened");
                    jQuery("#mainLeftPanel li.f_dropdown ul").slideUp(500);
                }
                closest_li.addClass("opened");
                closest_li.children("ul").slideDown(500);
            }
        });
        var count = jQuery(".cat_count");
        count.each(function () {
            if (parseInt(jQuery(this).text()) > 9999) {
                jQuery(this).text("10k+");
            }
        });
    },
    overlay: function () {
        jQuery(".overlay").click(function () {
            jQuery(this).parent().addClass("hide");
        });
    },
    checkbox: function () {
        jQuery(".f_checkbox_label").click(function () {
            jQuery(this).siblings(".f_checkbox").toggleClass("checked");
        });
        jQuery(".f_checkbox").click(function () {
            jQuery(this).toggleClass("checked");
        });
    },
    categoriesProductCheckbox: function () {
        jQuery(".f_product_checkbox").on("click", function () {
            window.location.href = jQuery(this).parent().attr("href");
        });
    }
});
