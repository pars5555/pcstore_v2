<div class="user-profile-wrapper profile-wrapper container row">
    {include file="$TEMPLATE_DIR/user/user_left_panel.tpl"}
    <div class="profile-content row container">
        <div class="current-user-info col-md-8">
            <form role="form" method="post" action="{$SITE_PATH}/dyn/user/do_update_profile" autocomplete="off">
            	{if isset($ns.success_message)}
                    <div class="alert alert-success">
                        <strong><span class="glyphicon glyphicon-send"></span> {$ns.success_message}</strong>
                    </div>
                {/if}
                {if isset($ns.error_message)}
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-alert"></span><strong> {$ns.error_message}</strong>
                    </div>
                {/if}
                <div class="form-group">
                    <label for="firstName">{$ns.lm->getPhrase(61)}</label>
                    <input type="text" class="form-control"  name= "first_name" id="firstName" placeholder="{$ns.lm->getPhrase(61)}" value="{$ns.customer->getName()}">
                </div>
                <div class="form-group">
                    <label for="lastName">{$ns.lm->getPhrase(81)}</label>
                    <input type="text" class="form-control" name= "last_name"  id="lastName" placeholder="{$ns.lm->getPhrase(81)}" value="{$ns.customer->getLastName()}">
                </div>
                <div class="form-group">
                    <label for="phone1">{$ns.lm->getPhrase(12)}1</label>
                    <input type="text" class="form-control"  name= "phone1"  id="phone1" placeholder="{$ns.lm->getPhrase(12)}"  value="{$ns.phones.0|default:''}">
                </div>
                <div class="form-group">
                    <label for="phone2">{$ns.lm->getPhrase(12)}2</label>
                    <input type="text" class="form-control"  name= "phone2" id="phone2" placeholder="{$ns.lm->getPhrase(12)}"  value="{$ns.phones.1|default:''}">
                </div>
                <div class="form-group">
                    <label for="phone3">{$ns.lm->getPhrase(12)}3</label>
                    <input type="text" class="form-control"  name= "phone3" id="phone3" placeholder="{$ns.lm->getPhrase(12)}"  value="{$ns.phones.2|default:''}">
                </div>
                <div class="form-group">
                    <label for="address">{$ns.lm->getPhrase(13)}</label>
                    <input type="text" class="form-control" name= "address"  id="address" placeholder="{$ns.lm->getPhrase(13)}" value="{$ns.customer->getAddress()}">
                </div>
                <div class="form-group">
                    <label for="region">{$ns.lm->getPhrase(45)}</label>
                    <select id="region"  name= "region" >
                        {foreach from=$ns.regions_phrase_ids_array item=value key=key}
                            <option value="{$ns.lm->getPhrase($value, 'en')}" {if $ns.region_selected == $ns.lm->getPhrase($value, 'en')}selected="selected"{/if} class="translatable_element" phrase_id="{$value}">{$ns.lm->getPhrase($value)}</option>
                        {/foreach}		
                    </select>
                </div>
                <button style="width:100%;" type="submit" class="btn btn-default btn-primary center-block">{$ns.lm->getPhrase(43)}</button>
            </form>
        </div>
    </div>
</div>
