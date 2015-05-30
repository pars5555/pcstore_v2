ngs.AdminOpenNewsletterLoad = Class.create(ngs.AbstractLoad, {
	initialize: function($super, shortCut, ajaxLoader) {
		$super(shortCut, "admin_newsletter", ajaxLoader);
	},
	getUrl: function() {
		return "open_newsletter";
	},
	getMethod: function() {
		return "POST";
	},
	getContainer: function() {
		return "save_load_manage_popups_container";
	},
	getName: function() {
		return "admin_open_newsletter";
	},
	afterLoad: function() {
		jQuery("#popup_open_button").click(function() {
			var newsletterId = jQuery('#on_newsletter_select').val();
			jQuery('.pop_up_container').addClass("hide");
			ngs.action("admin_open_newsletter", {"newsletter_id": newsletterId});
		});
	},
	onLoadDestroy: function()
	{

	}
});

