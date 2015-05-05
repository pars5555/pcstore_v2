<div class="user-left-panel left-panel f_side_panel" data-side-panel="categories-panel" data-side-position="left">
	<!-- <div id="leftMenuBtn" class="left-menu-btn">  -->
	<div class="left-panel_content">
		<h1 class="any_categories"><span class="glyphicon"></span>Profile Settings</h1>
		<ul class="sidebar-nav">
			<li>
				<a href="{$SITE_PATH}/uprofile"> <span class="cat_name">{$ns.lm->getPhrase(94)}</span> </a>
			</li>
			{if $ns.customer->getLoginType()=='pcstore'}
			<li>
				<a href="{$SITE_PATH}/uchangepass"> <span class="cat_name">{$ns.lm->getPhrase(27)}</span> </a>
			</li>
			{/if}
		</ul>
		<script>
			jQuery(".sidebar-nav a").each(function() {
				if (jQuery(this).attr("href") == window.location.href) {
					jQuery(this).addClass("active");
				};
			});
		</script>
	</div>
</div>
