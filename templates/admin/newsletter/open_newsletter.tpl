<select onkeyup="this.blur();
			this.focus();" multiple style="width: 100%;height: 100%" id="on_newsletter_select">
	{html_options options=$ns.all_newsletters selected=$ns.selected_newsletter_id}
</select>
<a class="button" id="popup_open_button">open</a>