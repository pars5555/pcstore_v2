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
        this.leftSideSubMenusController();
        this.initLoginFunctionallity();
        this.initLanguages();
        this.initSocialLogout();      
        this.newsLetterBlockController();
        this.initForgotPassword();
        ngs.action('ping_pong', {});
        ngs.nestLoad(jQuery('#contentLoad').val());
        this.notificationCustomScroll();
        this.leftMenu();
    },
    notificationCustomScroll: function () {
        jQuery("#notificationListWrapper").mCustomScrollbar({
            theme: "light-3"
        });
    },
    initForgotPassword: function () {
        jQuery('#forgotPasswordForm').submit(function () {
            jQuery(this).find('input, button').attr('disabled', 'disabled');
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
    leftSideSubMenusController: function () {
        jQuery(".f_left_side_sub_menu").click(function () {
            jQuery(this).next().stop(true, false).slideToggle();
        });
        jQuery("#closeBtn").click(function () {
            //@TODO
            jQuery("#mainLeftPanel").toggleClass("closed");
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
        
        jQuery("#navMenu .dropdown-toggle").click(function(){
        	jQuery("#navMenu .dropdown-menu").slideToggle(500);
        	if(jQuery(this).hasClass("active")){
        		jQuery(this).removeClass("active");
        	}
        	else{
        		jQuery(this).addClass("active");
        	}
        });

    },
    initLoginFunctionallity: function () {
        jQuery(".f_myModal_toggle").click(function () {
            jQuery("#myModal").addClass("active");
        });
        jQuery("#myModal #close_button").click(function () {
            jQuery("#myModal").removeClass("active");
        });

        jQuery("#forgot_pass").click(function () {
            jQuery("#forgotModal").addClass("active");
        });
        jQuery("#forgotModal #close_button").click(function () {
            jQuery("#forgotModal").removeClass("active");
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
    leftMenu: function(){
    	jQuery("#mainLeftPanel ul li").has("ul").addClass("dropdown");
    	
    	jQuery("#mainLeftPanel li ul").slideUp(0);
    	
    	jQuery("#mainLeftPanel .dropdown-toggle").click(function(event){
    		event.preventDefault();
    		var closest_li = jQuery(this).closest("li");
    		
    		if(closest_li.hasClass("opened")){
	    		closest_li.removeClass("opened");
	    		jQuery(this).closest("a").siblings("ul").slideUp(500);  
	    		if(!jQuery(this).parents("li").hasClass("opened")){
	    			jQuery("#mainLeftPanel a").removeClass("dark_bg");  	
	    		}		
    		}
    		else{
    			if(!jQuery(this).parents("li").hasClass("opened")){
	    			jQuery("#mainLeftPanel li").removeClass("opened");
	    			jQuery("#mainLeftPanel li ul").slideUp(500); 
	    			jQuery("#mainLeftPanel a").addClass("dark_bg");  				
    			}
	    		closest_li.addClass("opened");
	    		closest_li.find("a").removeClass("dark_bg");
	    		jQuery(this).closest("a").siblings("ul").slideDown(500);    			
    		}
    	});
    	var count = jQuery(".cat_count");
    	count.each(function(){
	    	if(parseInt(jQuery(this).text())>9999){
	    		jQuery(this).text("10k+");
	    	}    		
    	});
    }
});
