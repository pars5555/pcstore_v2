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
    },
    wrapSelect : function(){
    	jQuery("#working_hours select").wrap("<div class='select_wrapper'></div>");
    }
});
