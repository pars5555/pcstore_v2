<div class="company-profile-wrapper profile-wrapper">
	<div class="profile-main-content">
		{include file="$TEMPLATE_DIR/company/company_left_panel.tpl"}
		{if isset($ns.branch_not_exist)}
		Branch not exists!
		{else}
		<div class="profile-content">
			<div class="current-user-info">
				<div class="form-group">
					<label for="cp_branch_select" >{$ns.lm->getPhrase(562)}: </label>
					{foreach from=$ns.company_branches item=branch_name key=branch_id}
					<a class="link {if $branch_id == $ns.selected_company_branch_id}btn-primary{/if}" href="{$SITE_PATH}/branches/{$branch_id}">{$branch_name}</a>
					{/foreach}
				</div>
				<form role="form" method="post" action="{$SITE_PATH}/dyn/company/do_update_branch" autocomplete="off">
					<input type="hidden" value="{$ns.selected_company_branch_id}" name="branch_id"/>
					<div class="form-group">
						<label class="input_label" for="phone1">{$ns.lm->getPhrase(33)} 1</label>
						<input class="text"  name='phone1' id="phone1" type="text" value="{$ns.phones[0]|default:""}" />
					</div>
					<div class="form-group">
						<label class="input_label" for="phone2">{$ns.lm->getPhrase(33)} 2</label>
						<input class="text" name='phone2' id="phone2" type="text" value="{$ns.phones[1]|default:""}"/>
					</div>
					<div class="form-group">
						<label class="input_label" for="phone3">{$ns.lm->getPhrase(33)} 3</label>
						<input class="text" name='phone3' id="phone3" type="text" value="{$ns.phones[2]|default:""}"/>
					</div>
					<div class="form-group">
						<label class="input_label" for="address">{$ns.lm->getPhrase(13)}</label>
						<input class="text" name="address" id="address" type="text" value="{$ns.branch_address}"/>
					</div>
					<div class="form-group">
						<label class="input_label" for="zip">{$ns.lm->getPhrase(604)}</label>
						<input class="text" name="zip" id="zip" type="text" value="{$ns.zip}"/>
					</div>

					<div class="form-group">
						<label for="region">{$ns.lm->getPhrase(45)}:</label>
						<div class="select_wrapper">
							<select   name='region' id="region">
								{foreach from=$ns.regions_phrase_ids_array item=value key=key}
								<option value="{$ns.lm->getPhrase($value, 'en')}" {if $ns.region_selected == $ns.lm->getPhrase($value, 'en')}selected="selected"{/if}>{$ns.lm->getPhrase($value)}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="input_label" for="working_days">{$ns.lm->getPhrase(34)}</label>
						<table class="days_table">
							<tr>
								<th><label for='monday_checkbox'>{$ns.lm->getPhrase(35)}</label></th>
								<th><label for='tuseday_checkbox'>{$ns.lm->getPhrase(36)}</label></th>
								<th><label for='wednesday_checkbox'>{$ns.lm->getPhrase(37)}</label></th>
								<th><label for='thursday_checkbox'>{$ns.lm->getPhrase(38)}</label></th>
								<th><label for='friday_checkbox'>{$ns.lm->getPhrase(39)}</label></th>
								<th><label for='saturday_checkbox'>{$ns.lm->getPhrase(40)}</label></th>
								<th><label for='sunday_checkbox'>{$ns.lm->getPhrase(41)}</label></th>
							</tr>
							<tr>
								<td>
								<input name='monday_checkbox' id='monday_checkbox' type="checkbox" {if $ns.working_days[0]==1}checked{/if}/>
								</td>
								<td>
								<input name='tuseday_checkbox' id='tuseday_checkbox' type="checkbox" {if $ns.working_days[1]==1}checked{/if}/>
								</td>
								<td>
								<input name='wednesday_checkbox' id='wednesday_checkbox' type="checkbox" {if $ns.working_days[2]==1}checked{/if}/>
								</td>
								<td>
								<input name='thursday_checkbox' id='thursday_checkbox' type="checkbox" {if $ns.working_days[3]==1}checked{/if}/>
								</td>
								<td>
								<input name='friday_checkbox' id='friday_checkbox' type="checkbox" {if $ns.working_days[4]==1}checked{/if}/>
								</td>
								<td>
								<input name='saturday_checkbox' id='saturday_checkbox' type="checkbox" {if $ns.working_days[5]==1}checked{/if}/>
								</td>
								<td>
								<input name='sunday_checkbox' id='sunday_checkbox' type="checkbox" {if $ns.working_days[6]==1}checked{/if}/>
								</td>
							</tr>
						</table>

					</div>

					<div class="working_hours form-group" id="working_hours" class="form-group">
						<label class="input_label" for="longitute_latitude">Working hours</label>
						{html_select_time use_24_hours=true display_seconds=false minute_interval=15 time=$ns.workingStart prefix="startWorking"} <span class="glyphicon">−</span> {html_select_time use_24_hours=true display_seconds=false minute_interval=15 time=$ns.workingEnd prefix="endWorking"}
					</div>
					<div class="form-group">
						<label class="input_label" for="longitute_latitude">Lng/Lat:</label>
						<input class="text" name='longitute' type="text" value="{$ns.lng}"/>
						<input class="text" name='latitude' type="text" value="{$ns.lat}"/>
					</div>
					<button type="submit" class="button blue">
						{$ns.lm->getPhrase(43)}
					</button>
				</form>
			
			<button id="branch_btn" class="button green branch_btn">Add new branch</button>
			<div class="branch_pop_up hide">
				<div class="overlay"></div>
				<div class="branch_wrapper">
					<div class="close_button"></div>
				<form role="form">
					<h3>Add new branch</h3>
					<div class="form-group">
						<label class="input_label" for="">Add new Branch</label>
						<input type="text" class="form-control text" id="" placeholder="New Branch">
					</div>
					<div class="form-group">
						<label for="">Region:</label>
						<div class="select_wrapper">
							<select class="form-control">
								<option>1</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="input_label" for="">Postal Code</label>
						<input type="text" class="form-control text" id="" placeholder="Postal Code">
					</div>
					<button type="submit" class="button blue">
						{$ns.lm->getPhrase(43)}
					</button>
				</form>
				</div>
				</div>
			</div>
		</div>
		{/if}
	</div>
</div>
