ngs.ActionFactory = Class.create();
ngs.ActionFactory.prototype={

	initialize: function(ajaxLoader){
		this.actions = [];
        this.actions["login"] = function temp(){return new ngs.LoginAction("login", ajaxLoader);};
        this.actions["social_login"] = function temp(){return new ngs.SocialLoginAction("social_login", ajaxLoader);};
        this.actions["set_language"] = function temp(){return new ngs.SetLanguageAction("set_language", ajaxLoader);};
        this.actions["ping_pong"] = function temp(){return new ngs.PingPongAction("ping_pong", ajaxLoader);};
        this.actions["add_newsletter_subscriber"] = function temp(){return new ngs.AddNewsletterSubscriberAction("add_newsletter_subscriber", ajaxLoader);};
        this.actions["send_forgot_password"] = function temp(){return new ngs.SendForgotPasswordAction("send_forgot_password", ajaxLoader);};
        this.actions["get_selected_and_require_components"] = function temp(){return new ngs.GetSelectedAndRequireComponentsAction("get_selected_and_require_components", ajaxLoader);};
        this.actions["confirm_stripe_payment"] = function temp(){return new ngs.ConfirmStripePaymentAction("confirm_stripe_payment", ajaxLoader);};

        //user
        this.actions["register_company_dealer"] = function temp(){return new ngs.RegisterCompanyDealerAction("register_company_dealer", ajaxLoader);};
        this.actions["invite"] = function temp(){return new ngs.InviteAction("invite", ajaxLoader);};
        
        //company    
        this.actions["company_upload_logo"] = function temp(){return new ngs.CompanyUploadLogoAction("company_upload_logo", ajaxLoader);};
        this.actions["format_price_email_recipients"] = function temp(){return new ngs.FormatPriceEmailRecipientsAction("format_price_email_recipients", ajaxLoader);};
        this.actions["upload_price"] = function temp(){return new ngs.UploadPriceAction("upload_price", ajaxLoader);};
        this.actions["upload_attachment"] = function temp(){return new ngs.UploadAttachmentAction("upload_attachment", ajaxLoader);};
        this.actions["delete_attachment"] = function temp(){return new ngs.DeleteAttachmentAction("delete_attachment", ajaxLoader);};
        this.actions["send_price_email"] = function temp(){return new ngs.SendPriceEmailAction("send_price_email", ajaxLoader);};
        
        //admin
        this.actions["change_category_attributes"] = function temp(){return new ngs.ChangeCategoryAttributesAction("change_category_attributes", ajaxLoader);};
        this.actions["remove_category"] = function temp(){return new ngs.RemoveCategoryAction("remove_category", ajaxLoader);};
        this.actions["change_category_order"] = function temp(){return new ngs.ChangeCategoryOrderAction("change_category_order", ajaxLoader);};
        this.actions["add_category"] = function temp(){return new ngs.AddCategoryAction("add_category", ajaxLoader);};
     },

	getAction: function(name){
		return this.actions[name]();
	}
};