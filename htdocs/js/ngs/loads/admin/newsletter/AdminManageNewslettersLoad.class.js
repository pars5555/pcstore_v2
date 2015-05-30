ngs.AdminManageNewslettersLoad = Class.create(ngs.AbstractLoad, {
	initialize: function($super, shortCut, ajaxLoader) {
		$super(shortCut, "admin_newsletter", ajaxLoader);
	},
	getUrl: function() {
		return "manage_newsletters";
	},
	getMethod: function() {
		return "POST";
	},
	getContainer: function() {
		return "save_load_manage_popups_container";
	},
	getName: function() {
		return "admin_manage_newsletters";
	},
	afterLoad: function() {
		jQuery("#popup_delete_button").one('click', function() {
			var id = jQuery('#mn_newsletter_select').val();
			ngs.action("admin_delete_newsletter", {"newsletter_id": id});
		});
	},
	onLoadDestroy: function()
	{

	}
});

