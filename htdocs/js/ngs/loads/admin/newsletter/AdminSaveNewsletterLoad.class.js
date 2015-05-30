ngs.AdminSaveNewsletterLoad = Class.create(ngs.AbstractLoad, {
	initialize: function($super, shortCut, ajaxLoader) {
		$super(shortCut, "admin_newsletter", ajaxLoader);
	},
	getUrl: function() {
		return "save_newsletter";
	},
	getMethod: function() {
		return "POST";
	},
	getContainer: function() {
		return "save_load_manage_popups_container";
	},
	getName: function() {
		return "admin_save_newsletter";
	},
	afterLoad: function() {
		jQuery('#sn_newsletter_select').change(function() {
			var newsletterId = jQuery(this).val();
			var newsletterText = jQuery(this).find('option:selected').text();
			jQuery('#sn_newsletter_title').val(newsletterText);
			jQuery('#sn_newsletter_title').attr('newsletter_id', newsletterId);
		});
		jQuery("#popup_save_button").click(function() {
			var saveTitle = jQuery('#sn_newsletter_title').val();
			tinyMCE.activeEditor.save();
			var bodyHTML = jQuery('#sc_newsletter_html').val();
			jQuery('.pop_up_container').addClass("hide");
			ngs.action("admin_save_newsletter", {"title": saveTitle, 'html': bodyHTML});
		});

	},
	onLoadDestroy: function()
	{

	}
});

