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
        this.initAdminChatOnOff();
        this.initLoginFunctionallity();
        this.dropDownMenu();
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

        this.initMainTabsContents();
        this.showActiveTabContent(jQuery(".f_tab_title.active"));

        this.hideErrorSuccessMessages();
        this.initSocialLogins();

        jQuery('#search_text_form').submit(function () {
            jQuery('#search_text_form :input').each(function(){
                if (jQuery(this).val()=='' || jQuery(this).val()==0)
                {
                    jQuery(this).attr('name', '');
                }
            });
            return true;
        });

    },
    initAdminChatOnOff: function () {
        jQuery('#chat_on_off').change(function () {
            var chatEnable = jQuery(this).is(':checked');

        });
    },
    initSocialLogins: function () {
        if (jQuery('#googleLoginBtn').length > 0) {
            gapi.signin.render('googleLoginBtn', {});
        }
        jQuery("#linkedinLoginBtn").click(function () {
            IN.UI.Authorize().place();
            IN.Event.on(IN, "auth", function () {
                onLinkedLogin();
            });
        });
        if (typeof FB !== 'undefined') {
            FB.init({
                appId: '647621848648600',
                xfbml: true,
                version: 'v2.0'
            });
            jQuery("#facebookLoginBtn").click(function () {
                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        FB.api('/me', onFacebookLogin);
                    } else {
                        FB.login(function (response) {
                            FB.api('/me', onFacebookLogin);
                        }, {scope: 'email'});
                    }

                });
            });
        }
    },
    hideErrorSuccessMessages: function () {
        window.setInterval(function () {
            jQuery(".error,.success").slideUp(300, function () {
                jQuery(".error,.success").html("");
            });
        }, 7000);
    },
    initMainTabsContents: function () {
        var self = this;
        jQuery(".f_tab_title").on("click", function () {
            self.showActiveTabContent(jQuery(this));
        });
    },
    showActiveTabContent: function (tab) {
        var tab_id = tab.attr("data-tab-id");
        jQuery(".f_tab_title").removeClass("active");
        tab.addClass("active");
        jQuery(".f_tab_content").hide();
        jQuery(".f_tab_content[data-tab-id=" + tab_id + "]").show();
    },
    mainLoader: function (param) {
        if (param === true) {
            jQuery("#main_loader").removeClass("hidden");
        }
        if (param === false) {
            jQuery("#main_loader").addClass("hidden");
        }
    },
    pccLoader: function () {
        jQuery("#pcc_loader").addClass("hidden");
        jQuery(".f_current_item_block,.f_component").on("click", function (event) {
            if (!jQuery(event.target).hasClass("f_product_link")) {
                jQuery("#pcc_loader").removeClass("hidden");
            }
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
    },
    dropDownMenu: function () {
        function hideAllDropdowns() {
            jQuery("#navMenu .f_dropdown_menu").slideUp(500);
            jQuery("#navMenu .f_dropdown_toggle").removeClass("active");
        }
        ;
        jQuery("#navMenu .f_dropdown_toggle").click(function () {
            hideAllDropdowns();
            jQuery(this).siblings(".f_dropdown_menu").slideToggle(500);
            jQuery(this).toggleClass("active");

            jQuery(document).on("click", function (event) {
                if (jQuery(event.target).closest(".f_dropdown").length < 1) {
                    hideAllDropdowns();
                }
            });
        });
    },
    initLoginFunctionallity: function () {
        var self = this;
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

            jQuery("#forgotModal #forgotPasswordEmailInput").val("");
            jQuery('#forgotPasswordErrorMessage').html("");
            jQuery('#forgotPasswordSuccessMessage').html("");
        });
        jQuery("#forgotPasswordBtn").on("click", function () {
            self.mainLoader(true);
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
            jQuery(this).toggleClass("active");
            closest_li.toggleClass("opened");
            closest_li.children("ul").slideToggle(300);
        });

        var count = jQuery(".cat_count");
        count.each(function () {
            var text = jQuery(this).find("span");
            if (parseInt(text.text()) > 9999) {
                text.text("10k+");
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
