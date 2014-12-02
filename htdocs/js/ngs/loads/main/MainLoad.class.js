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
        this.newsLetterBlockController();
        this.initForgotPassword();
        ngs.action('ping_pong', {});
        ngs.nestLoad(jQuery('#contentLoad').val());
        this.notificationCustomScroll();
        this.leftMenu();        
        this.overlay();
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
        	jQuery(this).siblings(".dropdown-menu").slideToggle(500);
        	if(jQuery(this).hasClass("active")){
        		jQuery(this).removeClass("active");
        	}
        	else{
        		jQuery(this).addClass("active");
        	}
        	jQuery("body").click(function(event){
        		if(!jQuery(event.target).hasClass("dropdown-menu") && !jQuery(event.target).hasClass("dropdown-toggle") || jQuery(event.target).parents("#navMenu").length<1){
        			jQuery("#navMenu .dropdown-menu").slideUp(500);
        			jQuery("#navMenu .dropdown-toggle").removeClass("active");
        		}
        		if(jQuery(event.target).hasClass("dropdown-toggle") && jQuery(event.target).parents("#navMenu").length>0){
        			jQuery(event.target).closest(".dropdown").siblings(".dropdown").children(".dropdown-toggle").removeClass("active");
        			jQuery(event.target).closest(".dropdown").siblings(".dropdown").children(".dropdown-menu").slideUp(500);        			
        		};
        	});
        });

    },
    initLoginFunctionallity: function () {
        jQuery(".f_myModal_toggle").click(function () {
            jQuery("#myModal").removeClass("hide"); 
            jQuery("#myModal").addClass("active"); 
        });
        jQuery("#myModal .close_button,#myModal .overlay").click(function () {
            jQuery("#myModal").removeClass("active");  
            jQuery("#myModal").addClass("hide");      
        });

        jQuery("#forgot_pass").click(function () {
            jQuery("#forgotModal").addClass("active");
            jQuery("#forgotModal").removeClass("hide"); 
        });
        jQuery("#forgotModal .close_button,#forgotModal .overlay").click(function () {
            jQuery("#forgotModal").removeClass("active");
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
    leftMenu: function(){
    	jQuery("#mainLeftPanel ul li").has("ul").addClass("dropdown");
    	
    	jQuery("#mainLeftPanel .dropdown-toggle").click(function(event){
    		event.preventDefault();
    		var closest_li = jQuery(this).closest("li");
    		
    		if(closest_li.hasClass("opened")){
	    		closest_li.removeClass("opened");
	    		closest_li.children("ul").slideUp(500);  
	    		if(!jQuery(this).parents("li").hasClass("opened")){ 	
	    		}		
    		}
    		else{
    			if(!jQuery(this).parents("li").hasClass("opened")){
	    			jQuery("#mainLeftPanel li").removeClass("opened");
	    			jQuery("#mainLeftPanel li.dropdown ul").slideUp(500); 			
    			}
	    		closest_li.addClass("opened");
	    		closest_li.children("ul").slideDown(500);    			
    		}
    	});
    	var count = jQuery(".cat_count");
    	count.each(function(){
	    	if(parseInt(jQuery(this).text())>9999){
	    		jQuery(this).text("10k+");
	    	}    		
    	});
    },
   
    overlay : function(){
    	jQuery(".overlay").click(function(){
    		jQuery(this).parent().addClass("hide");
    	});
    }
});
