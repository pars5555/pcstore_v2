<div class="company-profile-wrapper profile-wrapper container row">
    {include file="$TEMPLATE_DIR/company/company_left_panel.tpl"}
    <div class="profile-content row container">

        <form role="form" method="post" action="{$SITE_PATH}/dyn/company/do_update_sms_settings" autocomplete="off">
            {if isset($ns.success_message)}
                <div class="alert alert-success">
                    <strong><span class="glyphicon"></span> {$ns.success_message}</strong>
                </div>
            {/if}
            {if isset($ns.error_message)}
                <div class="alert alert-danger">
                    <span class="glyphicon"></span><strong> {$ns.error_message}</strong>
                </div>
            {/if}

            <h3>SMS receiving settings</h3>
            <p>Receive only these days:</p>
            <table >
                <tr>
                    <th> <label for='monday_checkbox'>{$ns.lm->getPhrase(35)}</label></th>
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

            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control" value="{$ns.customer->getPriceUploadSmsPhoneNumber()}"/>
            </div>
            <div class="form-group">
                <label for="sms_time_control">{$ns.lm->getPhrase(403)}:</label>
                <input type="checkbox" id="sms_time_control" name="sms_time_control" {if ($ns.customer->getSmsToDurationMinutes()>0)} checked="checked"{/if}/>
                <div id="smsTimeControlContainer" {if $ns.customer->getSmsToDurationMinutes()==0}style="display: none"{/if}>
                    <select name="sms_from_time" >
                        {html_options values=$ns.times selected=$ns.customer->getSmsReceiveTimeStart()|date_format:"%H:%M" output=$ns.times} 
                    </select> - 
                    <select name="sms_to_duration_minutes">
                        {html_options values=$ns.values selected=$ns.customer->getSmsToDurationMinutes() output=$ns.timesDisplayNames}
                    </select>

                </div>
            </div>
            <button type="submit" class="btn btn-default btn-primary center-block">Submit</button>
        </form>
    </div>
</div>
