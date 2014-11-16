ngs.LoadFactory= Class.create();
ngs.LoadFactory.prototype={
	
	initialize: function(ajaxLoader){
	this.loads = [];
	this.loads["main"] = function temp(){return new ngs.MainLoad("main", ajaxLoader);};
	this.loads["main_home"] = function temp(){return new ngs.HomeLoad("main_home", ajaxLoader);};
	this.loads["main_buildpc"] = function temp(){return new ngs.BuildpcLoad("main_buildpc", ajaxLoader);};
	this.loads["main_landingpage"] = function temp(){return new ngs.LandingpageLoad("main_landingpage", ajaxLoader);};
	this.loads["main_signup"] = function temp(){return new ngs.SignupLoad("main_signup", ajaxLoader);};
	this.loads["main_checkout"] = function temp(){return new ngs.CheckoutLoad("main_checkout", ajaxLoader);};
	this.loads["main_companies"] = function temp(){return new ngs.CompaniesLoad("main_companies", ajaxLoader);};
	this.loads["main_item"] = function temp(){return new ngs.ItemLoad("main_item", ajaxLoader);};
	this.loads["main_cart"] = function temp(){return new ngs.CartLoad("main_cart", ajaxLoader);};
	this.loads["main_orders"] = function temp(){return new ngs.OrdersLoad("main_orders", ajaxLoader);};
        this.loads["pcc_select_case"] = function temp(){return new ngs.PccSelectCaseLoad("pcc_select_case", ajaxLoader);};
        this.loads["pcc_select_mb"] = function temp(){return new ngs.PccSelectMbLoad("pcc_select_mb", ajaxLoader);};
        this.loads["pcc_select_ram"] = function temp(){return new ngs.PccSelectRamLoad("pcc_select_ram", ajaxLoader);};
        this.loads["pcc_select_cpu"] = function temp(){return new ngs.PccSelectCpuLoad("pcc_select_cpu", ajaxLoader);};
        this.loads["pcc_select_hdd"] = function temp(){return new ngs.PccSelectHddLoad("pcc_select_hdd", ajaxLoader);};
        this.loads["pcc_select_ssd"] = function temp(){return new ngs.PccSelectSsdLoad("pcc_select_ssd", ajaxLoader);};
        this.loads["pcc_select_cooler"] = function temp(){return new ngs.PccSelectCoolerLoad("pcc_select_cooler", ajaxLoader);};
        this.loads["pcc_select_monitor"] = function temp(){return new ngs.PccSelectMonitorLoad("pcc_select_monitor", ajaxLoader);};
        this.loads["pcc_select_opt"] = function temp(){return new ngs.PccSelectOptLoad("pcc_select_opt", ajaxLoader);};
        this.loads["pcc_select_power"] = function temp(){return new ngs.PccSelectPowerLoad("pcc_select_power", ajaxLoader);};
        this.loads["pcc_select_keyboard"] = function temp(){return new ngs.PccSelectKeyboardLoad("pcc_select_keyboard", ajaxLoader);};
        this.loads["pcc_select_mouse"] = function temp(){return new ngs.PccSelectMouseLoad("pcc_select_mouse", ajaxLoader);};
        this.loads["pcc_select_speaker"] = function temp(){return new ngs.PccSelectSpeakerLoad("pcc_select_speaker", ajaxLoader);};
        this.loads["pcc_select_graphics"] = function temp(){return new ngs.PccSelectGraphicsLoad("pcc_select_graphics", ajaxLoader);};   
        this.loads["pcc_total_calculations"] = function temp(){return new ngs.PccTotalCalculationsLoad("pcc_total_calculations", ajaxLoader);};   
                //user
        this.loads["user_profile"] = function temp(){return new ngs.UserProfileLoad("user_profile", ajaxLoader);};
        this.loads["user_invite"] = function temp(){return new ngs.UserInviteLoad("user_invite", ajaxLoader);};
        this.loads["user_change_password"] = function temp(){return new ngs.UserChangePasswordLoad("user_change_password", ajaxLoader);};

                //company
        this.loads["company_profile"] = function temp(){return new ngs.CompanyProfileLoad("company_profile", ajaxLoader);};
        this.loads["company_dealers"] = function temp(){return new ngs.CompanyDealersLoad("company_dealers", ajaxLoader);};
        this.loads["company_smsconf"] = function temp(){return new ngs.CompanySmsconfLoad("company_smsconf", ajaxLoader);};
        this.loads["company_branches"] = function temp(){return new ngs.CompanyBranchesLoad("company_branches", ajaxLoader);};
        this.loads["company_upload_price"] = function temp(){return new ngs.CompanyUploadPriceLoad("company_upload_price", ajaxLoader);};

                //service company
        this.loads["servicecompany_profile"] = function temp(){return new ngs.ServiceCompanyProfileLoad("servicecompany_profile", ajaxLoader);};

                //admin
        this.loads["admin_main"] = function temp(){return new ngs.AdminMainLoad("admin_main", ajaxLoader);};
	this.loads["admin_home"] = function temp(){return new ngs.AdminHomeLoad("admin_home", ajaxLoader);};
	this.loads["admin_login"] = function temp(){return new ngs.AdminLoginLoad("admin_login", ajaxLoader);};
	this.loads["admin_items"] = function temp(){return new ngs.AdminItemsLoad("admin_items", ajaxLoader);};
	this.loads["admin_upload_price"] = function temp(){return new ngs.AdminUploadPriceLoad("admin_upload_price", ajaxLoader);};
	this.loads["admin_categories"] = function temp(){return new ngs.AdminCategoriesLoad("admin_categories", ajaxLoader);};
	this.loads["admin_category_details"] = function temp(){return new ngs.AdminCategoryDetailsLoad("admin_category_details", ajaxLoader);};
	this.loads["admin_companies"] = function temp(){return new ngs.AdminCompaniesLoad("admin_companies", ajaxLoader);};
	this.loads["admin_service_companies"] = function temp(){return new ngs.AdminServiceCompaniesLoad("admin_service_companies", ajaxLoader);};
},
	
    getLoad: function (name) {
        try {
            return this.loads[name]();
        }
        catch (ex) {
        }
    }
};