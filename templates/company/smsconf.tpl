<div class="company-profile-wrapper profile-wrapper">
	<div class="profile-main-content">
		{include file="$TEMPLATE_DIR/company/company_left_panel.tpl"}
		<div class="profile-content">
			<div class="current-user-info">

				<form role="form" method="post" action="{$SITE_PATH}/dyn/company/do_update_sms_settings" autocomplete="off">
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

					<h3 class="sms_title">SMS receiving settings</h3>
					<div class="form-group">
						<label class="input_label">
							Receive only these days:
						</label>
						<table class="days_table">
							<tr>
								<th><label for='monday_checkbox'>{$ns.lm->getPhrase(35)}</label></th>
								<th><label for='tuseday_checkbox'>{$ns.lm->getPhrase(36)}</label></th>
								<th><label for='wednesday_checkbox'>{$ns.lm->getPhrase(37)}</label></th>
								<th><label for='thursday_checkbox'>{$ns.lm->getPhrase(38)}</label></th>
								<th><label for='friday_checkbox'>{$ns.lm->getPhrase(39)}</label></th>
								<th><label for='saturday_checkbox'>{$ns.lm->getPhrase(40)}</label></th>
								<th><label for='sunday_checkbox'>{$ns.lm->getPhrase(41)}</label></th>
							<tr>
							<tr>
								<td>
								<input name='monday_checkbox' id='monday_checkbox' type="checkbox" {if $ns.weekDays[0]==1}checked{/if}/>
								</td>
								<td>
								<input name='tuseday_checkbox' id='tuseday_checkbox' type="checkbox" {if $ns.weekDays[1]==1}checked{/if}/>
								</td>
								<td>
								<input name='wednesday_checkbox' id='wednesday_checkbox' type="checkbox" {if $ns.weekDays[2]==1}checked{/if}/>
								</td>
								<td>
								<input name='thursday_checkbox' id='thursday_checkbox' type="checkbox" {if $ns.weekDays[3]==1}checked{/if}/>
								</td>
								<td>
								<input name='friday_checkbox' id='friday_checkbox' type="checkbox" {if $ns.weekDays[4]==1}checked{/if}/>
								</td>
								<td>
								<input name='saturday_checkbox' id='saturday_checkbox' type="checkbox" {if $ns.weekDays[5]==1}checked{/if}/>
								</td>
								<td>
								<input name='sunday_checkbox' id='sunday_checkbox' type="checkbox" {if $ns.weekDays[6]==1}checked{/if}/>
								</td>
							<tr>
						</table>
					</div>
					<div class="form-group">
						<label class="input_label" for="phone">Phone:</label>
						<input type="text" name="phone" class="form-control text" value="{$ns.customer->getPriceUploadSmsPhoneNumber()}"/>
					</div>
					<div class="form-group sms_time_ctl">
						<label class="input_label sms_label" for="sms_time_control">{$ns.lm->getPhrase(403)}:</label>
						<input class="sms_chekbox" type="checkbox" id="sms_time_control" name="sms_time_control" {if ($ns.customer->
						getSmsToDurationMinutes()>0)} checked="checked"{/if}/>
						<div id="smsTimeControlContainer" {if $ns.customer->
							getSmsToDurationMinutes()==0}style="display: none"{/if}>
							<div class="select_wrapper">
								<select name="sms_from_time" >
									{html_options values=$ns.times selected=$ns.customer->getSmsReceiveTimeStart()|date_format:"%H:%M" output=$ns.times}
								</select>
							</div>
							<span class="glyphicon">−</span>
							<div class="select_wrapper">
								<select name="sms_to_duration_minutes">
									{html_options values=$ns.values selected=$ns.customer->getSmsToDurationMinutes() output=$ns.timesDisplayNames}
								</select>
							</div>
						</div>
					</div>
					<button type="submit" class="button blue">
						Submit
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
