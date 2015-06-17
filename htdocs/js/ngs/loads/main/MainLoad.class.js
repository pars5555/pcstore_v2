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
        ngs.AdminChatManager.adminInit();
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
        this.categoriesProductCheckbox();
        this.pccLoader();
        this.sidePanel();
        this.notificationScrolling();
        this.initMainTabsContents();
        this.showActiveTabContent(jQuery(".f_tab_title.active"));
        this.hideErrorSuccessWarningMessages();
        this.autoHideMessages();
        this.initSocialLogins();
        this.searchForm();
        this.signupActivationMessage();
        this.scrollPageToTop();
//        this.buildPcLink();
        this.detectDeviceType();
    },
    detectDeviceType: function () {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            jQuery("#pcc_print_button").addClass("hidden");
        }
        ;
    },
    buildPcLink: function () {
        jQuery(".f_build_pc_link").on("click mousedown touchstart tap", function () {
            window.location.href = jQuery(this).attr("data-href");
        });
        var hasFlash = false;
        try {
            hasFlash = Boolean(new ActiveXObject('ShockwaveFlash.ShockwaveFlash'));
        } catch (exception) {
            hasFlash = ('undefined' != typeof navigator.mimeTypes['application/x-shockwave-flash']);
        }

        if (!hasFlash) {
            jQuery(".f_build_pc_link").addClass("no_flash");
        }
    },
    scrollPageToTop: function () {
        jQuery("#scroll_page_top").on("click", function () {
            jQuery("html,body").animate({scrollTop: 0}, 500);
        });
    },
    signupActivationMessage: function () {
        var signup_message = jQuery("#signup_activation_message");
        var signup_done = jQuery("#signup_activation_done");
        if (signup_message.length > 0) {
            this.initPopup(false, signup_message.val());
        }
        if (signup_done.length > 0) {
            this.initPopup(false, signup_done.val());
        }
    },
    searchForm: function () {
        jQuery('#search_text_form').submit(function () {
            jQuery('#search_text_form :input').each(function () {
                if (jQuery(this).val() == '' || jQuery(this).val() == 0)
                {
                    jQuery(this).attr('name', '');
                }
            });
            return true;
        });
    },
    initGoogle: function () {
        var thisInstance = this;
        gapi.load('auth2', function () {
            // Retrieve the singleton for the GoogleAuth library and set up the client.
            auth2 = gapi.auth2.init({
                client_id: '1035369249-j8j8uc4oacruo2iefonhdj1q0csjb9sj.apps.googleusercontent.com',
                cookiepolicy: 'single_host_origin',
                // Request scopes in addition to 'profile' and 'email'
                //scope: 'additional_scope'
            });
            if (jQuery('#googleLoginBtn').length > 0) {
                thisInstance.attachSignin(document.getElementById('googleLoginBtn'));
            }
        });
    },
    attachSignin: function (element) {
        auth2.attachClickHandler(element, {},
                function (googleUser) {
                    var profile = googleUser.getBasicProfile();
                    ngs.action("social_login", {"login_type": 'google', 'social_user_id': profile.getId(), 'first_name': profile.getName(), 'last_name': '', 'json_profile': JSON.stringify(profile)});
                }, function (error) {
            alert(JSON.stringify(error, undefined, 2));
        });
    },
    initSocialLogins: function () {
        this.initGoogle();
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
    hideErrorSuccessWarningMessages: function () {
        var msgTimeout;
        function hide(time) {
            time = time ? time : 7000;
            window.clearTimeout(msgTimeout);
            var msg = jQuery(".error,.success,.warning").not("[data-not-close='true']");
            msgTimeout = window.setTimeout(function () {
                msg.slideUp(300, function () {
                    msg.html("").show();
                });
            }, time);
        }
        hide();
        jQuery("form").on("submit", function () {
            hide();
        });
    },
    autoHideMessages: function () {
        var msgTimeout;
        function hide(time) {
            time = time ? time : 7000;
            window.clearTimeout(msgTimeout);
            var msg = jQuery(".message[data-auto-close='true']");
            msgTimeout = window.setTimeout(function () {
                msg.slideUp(300, function () {
                    msg.remove();
                });
            }, time);
        }
        hide();
        jQuery("form").on("submit", function () {
            hide();
        });
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
        var mainPopup = jQuery("#mainPopup").clone(true);
        mainPopup.removeAttr("id");
        jQuery("body").append(mainPopup);
        //init default values of fields//
        var default_title = jQuery("#mainPopupSettings .f_main_popup_default_title").val();
        var default_content = jQuery("#mainPopupSettings .f_main_popup_default_content").val();
        var default_confirm_btn = jQuery("#mainPopupSettings .f_main_popup_default_confirm_btn").val();
        var default_cancel_btn = jQuery("#mainPopupSettings .f_main_popup_default_cancel_btn").val();
        title = title ? title : default_title;
        content = content ? content : default_content;
        confirm = confirm ? confirm : default_confirm_btn;
        //init cancel button//
        if (typeof cancel == "undefined") {
            mainPopup.find(".f_pop_up_cancel_btn").remove();
        }
        else {
            if (cancel === true) {
                mainPopup.find(".f_pop_up_cancel_btn").html(default_cancel_btn);
            }
            else {
                mainPopup.find(".f_pop_up_cancel_btn").html(cancel);
            }
        }

        //Set values of fields//
        mainPopup.find(".f_pop_up_title").html(title);
        mainPopup.find(".f_pop_up_content").html(content);
        mainPopup.find(".f_pop_up_confirm_btn").html(confirm);
        //Show Popup//
        window.setTimeout(function () {
            mainPopup.addClass("active");
        }, 150);
        // Hide and remove popup //
        function hideRemove(mainPopup) {
            mainPopup.removeClass("active hide");
            window.setTimeout(function () {
                mainPopup.remove();
            }, 300);
        }
        // Popup buttons actions //
        mainPopup.find(".f_pop_up_confirm_btn").on("click", function () {
            if (typeof confirm_click === "function") {
                confirm_click();
            }
            hideRemove(mainPopup);
        });
        mainPopup.find(".overlay").add(mainPopup.find(".f_pop_up_cancel_btn")).add(mainPopup.find(".close_button")).on("click tap", function () {
            hideRemove(mainPopup);
        });
        return mainPopup;
    },
    notifications: function () {
        jQuery("#notification").on("click", function () {
            jQuery(this).removeClass("new_notification");
            window.localStorage.setItem("unreadNotificationExist", "");
        });
    }
    ,
    initGoogleLogoutOnWindowUnload: function () {
        window.onbeforeunload = function (e) {
            if (typeof gapi.auth2 !== 'undefined') {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                });
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
            if (typeof gapi.auth2 !== 'undefined') {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                });
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
        jQuery("#navMenu .f_dropdown_toggle").click(function () {
            jQuery(this).siblings(".f_dropdown_menu").slideToggle(500);
            jQuery(this).toggleClass("active");
            /*Close drop down menu*/
            jQuery(this).closest(".f_dropdown").siblings(".f_dropdown").find(".f_dropdown_toggle").removeClass("active");
            jQuery(this).closest(".f_dropdown").siblings(".f_dropdown").find(".f_dropdown_menu").slideUp(500);
            /*Click on other elements*/

            jQuery(document).on("click", function (event) {
                if (jQuery(event.target).closest(".f_dropdown").length < 1) {
                    jQuery("#navMenu .f_dropdown_menu").slideUp(500);
                    jQuery("#navMenu .f_dropdown_toggle").removeClass("active");
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
        jQuery("#forgotPasswordForm").on("submit", function () {
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
    categoriesProductCheckbox: function () {
        jQuery(".f_product_checkbox").on("click", function () {
            window.location.href = jQuery(this).parent().attr("href");
        });
    },
    sidePanel: function () {
        jQuery(".f_side_panel_btn").on("click", function () {
            var sidePanel = jQuery(this).attr("data-side-panel");
            jQuery(".f_side_panel").not("[data-side-panel=" + sidePanel + "]").removeClass("active");
            jQuery(".f_side_panel_btn").not("[data-side-panel=" + sidePanel + "]").removeClass("active");
            jQuery(".f_side_panel[data-side-panel=" + sidePanel + "]").toggleClass("active");
            jQuery(this).toggleClass("active");
        });
        jQuery(".f_side_panel[data-side-position=left]").on("swipeleft", function () {
            var sidePanel = jQuery(this).attr("data-side-panel");
            jQuery(this).removeClass("active");
            jQuery(".f_side_panel_btn[data-side-panel=" + sidePanel + "]").removeClass("active");
        });
        jQuery(".f_side_panel[data-side-position=right]").on("swiperight", function () {
            var sidePanel = jQuery(this).attr("data-side-panel");
            jQuery(this).removeClass("active");
            jQuery(".f_side_panel_btn[data-side-panel=" + sidePanel + "]").removeClass("active");
        });
    },
    notificationScrolling: function () {
//        jQuery("#notificationListWrapper").on("mouseover", function () {
//            jQuery(this).bind("scroll mousewheel", function () {
//                console.log(123);
//                jQuery("html").animate({scrollTop: 0}, '0');
//            });
//        });
//        jQuery("#notificationListWrapper").on("mouseleave", function () {
//            console.log(0000000000000000000000000);
//            jQuery(this).unbind("scroll mousewheel");
//        });
    }
});
