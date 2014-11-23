<div class="user-profile-wrapper profile-wrapper">
	<div class="user-profile-content">
		{include file="$TEMPLATE_DIR/user/user_left_panel.tpl"}
		<div class="profile-content">
			<div class="current-user-info">
				<form role="form" method="post" action="{$SITE_PATH}/dyn/user/do_change_password" autocomplete="off">
					{if isset($ns.success_message)}
					<div class="success">
						<strong> {$ns.success_message}</strong>
					</div>
					{/if}
					{if isset($ns.error_message)}
					<div class="error">
						<strong> {$ns.error_message}</strong>
					</div>
					{/if}
					<div class="form-group">
						<label class="input_label" for="password">{$ns.lm->getPhrase(4)}</label>
						<input type="password" class="form-control text"  name= "password" id="password" placeholder="{$ns.lm->getPhrase(4)}">
					</div>
					<div class="form-group">
						<label class="input_label" for="new_password">{$ns.lm->getPhrase(28)}</label>
						<input type="password" class="form-control text"  name= "new_password" id="new_password" placeholder="{$ns.lm->getPhrase(28)}">
					</div>
					<div class="form-group">
						<label class="input_label" for="repeat_new_password">{$ns.lm->getPhrase(29)}</label>
						<input type="password" class="form-control text"  name= "repeat_new_password" id="repeat_new_password" placeholder="{$ns.lm->getPhrase(29)}">
					</div>

					<button class="btn btn-default btn-primary center-block button blue">
						{$ns.lm->getPhrase(43)}
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
