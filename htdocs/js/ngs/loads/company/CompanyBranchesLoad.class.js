ngs.CompanyBranchesLoad = Class.create(ngs.AbstractLoad, {
    initialize: function($super, shortCut, ajaxLoader) {
        $super(shortCut, "company", ajaxLoader);
    },
    getUrl: function() {
        return "branches";
    },
    getMethod: function() {
        return "POST";
    },
    getContainer: function() {
        return "content";
    },
    getName: function() {
        return "company_branches";
    },
    afterLoad: function() {
    	this.wrapSelect();
    	this.branchPopUp();
    },
    wrapSelect : function(){
    	jQuery("#working_hours select").wrap("<div class='select_wrapper'></div>");
    },
    branchPopUp : function(){
    	var branch_pop_up = jQuery(".branch_pop_up");
    	jQuery("#branch_btn").click(function(){
            branch_pop_up.removeClass("hide"); 
            branch_pop_up.addClass("active");     		
    	});
        jQuery(".branch_pop_up .close_button,.branch_pop_up .overlay").click(function () {
            branch_pop_up.removeClass("active");  
            branch_pop_up.addClass("hide");      
        });
    }
});
