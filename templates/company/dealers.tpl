<h1 class="dealers_title main_title">{$ns.lm->getPhrase(59)}</h1>

{if isset($ns.success_message)}
    <div class="pop_up_container main_pop_up active f_dealers_popup">
        <div class="overlay"></div>
        <div class="pop_up">
            <div class="close_button"></div>
            <div class="pop_up_content f_pop_up_content">
                <div class="success">
                    {$ns.success_message}
                </div>
            </div>
            <div class="f_pop_up_confirm_btn button blue">{$ns.lm->getPhrase(485)}</div>
        </div>
    </div>
{/if}

<div class="dealers" id="dl_dealers_container">
    {if $ns.dealers|@count>0}
        <div class="table_striped">
            <div class="table_header_group">
                <div class="table-row">
                    <div class="table-cell">{$ns.lm->getPhrase(61)}</div>
                    <div class="table-cell">{$ns.lm->getPhrase(62)}</div>
                    <div class="table-cell">{$ns.lm->getPhrase(63)}</div>
                    <div class="table-cell"><span class="glyphicon"></span></div>
                </div>
            </div>
            {foreach from=$ns.dealers item=dealer name=dl}
                <div class="table-row">
                    <div class="table-cell" >
                        {$dealer->getUserName()} {$dealer->getUserLastName()}
                    </div>					
                    <div class="table-cell" ><span> 
                            {assign var=phones value=","|explode:$dealer->getUserPhones()}
                            {foreach from=$phones item=phone}
                                {$phone}
                                <br/>
                            {/foreach}
                        </span> 
                    </div>
                    <div class="table-cell" >
                        {$dealer->getUserEmail()}
                    </div>
                    <div class="table-cell">
                        <a  href="{$SITE_PATH}/dyn/company/do_delete_dealer?user_id={$dealer->getUserId()}">{$ns.lm->getPhrase(148)}<span class="glyphicon"></span></a>
                    </div>
                </div>
            {/foreach}
        </div>
    {else}           
        <h2 style="text-align: center">{$ns.lm->getPhrase(64)}</h2>
    {/if}

</div>

