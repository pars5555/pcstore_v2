ngs.AdminSaveNewsletterAction= Class.create(ngs.AbstractAction, {

	initialize : function($super, shortCut, ajaxLoader) {
		$super(shortCut, "admin_newsletter", ajaxLoader);
	},

	getUrl : function() {
		return "do_save_newsletter";
	},

	getMethod : function() {
		return "POST";
	},

	beforeAction : function() { 
	},

	afterAction : function(transport) {
		var data = transport.responseText.evalJSON();
		
	}
});
