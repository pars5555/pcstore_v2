<div class="user-profile-wrapper profile-wrapper">
	<div class="profile-main-content">
    {include file="$TEMPLATE_DIR/user/user_left_panel.tpl"}
    <div class="profile-content">
        <div class="current-user-info">
            <form role="form" method="post" action="{$SITE_PATH}/dyn/user/do_update_profile" autocomplete="off">
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
                    <label class="input_label" for="firstName">{$ns.lm->getPhrase(61)}</label>
                    <input type="text" class="form-control text"  name= "first_name" id="firstName" placeholder="{$ns.lm->getPhrase(61)}" value="{$ns.customer->getName()}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="lastName">{$ns.lm->getPhrase(81)}</label>
                    <input type="text" class="form-control text" name= "last_name"  id="lastName" placeholder="{$ns.lm->getPhrase(81)}" value="{$ns.customer->getLastName()}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="phone1">{$ns.lm->getPhrase(12)}1</label>
                    <input type="text" class="form-control text"  name= "phone1"  id="phone1" placeholder="{$ns.lm->getPhrase(12)}"  value="{$ns.phones.0|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="phone2">{$ns.lm->getPhrase(12)}2</label>
                    <input type="text" class="form-control text"  name= "phone2" id="phone2" placeholder="{$ns.lm->getPhrase(12)}"  value="{$ns.phones.1|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="phone3">{$ns.lm->getPhrase(12)}3</label>
                    <input type="text" class="form-control text"  name= "phone3" id="phone3" placeholder="{$ns.lm->getPhrase(12)}"  value="{$ns.phones.2|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="address">{$ns.lm->getPhrase(13)}</label>
                    <input type="text" class="form-control text" name= "address"  id="address" placeholder="{$ns.lm->getPhrase(13)}" value="{$ns.customer->getAddress()}">
                </div>
                <div class="form-group">
                    <label for="region">{$ns.lm->getPhrase(45)}:</label>
                    <div class="select_wrapper">
                    <select id="region"  name= "region" >
                        {foreach from=$ns.regions_phrase_ids_array item=value key=key}
                            <option value="{$ns.lm->getPhrase($value, 'en')}" {if $ns.region_selected == $ns.lm->getPhrase($value, 'en')}selected="selected"{/if} class="translatable_element" phrase_id="{$value}">{$ns.lm->getPhrase($value)}</option>
                        {/foreach}		
                    </select>
                    </div>
                </div>
                <button type="submit" class="profile_save_btn button blue">{$ns.lm->getPhrase(43)}</button>
            </form>
        </div>
    </div>
    </div>
</div>
