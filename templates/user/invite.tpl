<div class="container invite_container">
    <div id="inviteSuccessMessage" class="success invite_mes">
        {if isset($ns.success_message)}
            {$ns.success_message}
        {/if}
    </div>
    <div id="inviteErrorMessage" class="error invite_mes">
        {if isset($ns.error_message)}
            {$ns.error_message}
        {/if}
    </div>
        <form class="unvite_form" method="post" autocomplete="off" action="{$SITE_PATH}/dyn/user/do_invite">
        <label class="input_label default_width" for="email">Email</label>
        <input required="" class="text default_width" type="email" name="email"/>
        <button type="submit" class="button blue">Invite</button>
    </form>
    <div class="tab_title_content_container">
        <div class="tab_title_container">
            <div class="tab_title f_tab_title active" data-tab-id="1">
                {$ns.lm->getPhrase(147)}
            </div>
            <div class="tab_title f_tab_title" data-tab-id="2">
                {$ns.lm->getPhraseSpan(143)}
            </div>
        </div>
        <div class="tab_content_container">
            <div class="tab_content f_tab_content" data-tab-id="1" style="display: none">
                {if $ns.pendingUsers|@count>0}
                    {assign var="yesterday" value='-1 day'|strtotime}
                    {assign var="yesterday" value=$yesterday|date_format:"%Y-%m-%d %H:%M:%S"}

                    <div class="table_striped">
                        <div class="table_header_group">
                            <div class="table-row">
                                <div class="table-cell">{$ns.lm->getPhrase(3)}</div>
                                <div class="table-cell">{$ns.lm->getPhrase(612)}</div>
                            </div>
                        </div>
                        {foreach from=$ns.pendingUsers item=pu_dto name=pu}
                            <div class="table-row">
                                <div class="table-cell">
                                    {$pu_dto->getPendingSubUserEmail()}
                                </div>			
                                <div class="table-cell">
                                    {if $pu_dto->getLastSent()<$yesterday}
                                        <a href="{$SITE_PATH}/dyn/user/do_invite?invitation_id={$pu_dto->getId()}" class=" button blue inline small">{$ns.lm->getPhrase(612)}</a>
                                    {/if}
                                </div>			
                            </div>
                        {/foreach}
                    </div>
                {else}
                    <h1>{$ns.lm->getPhraseSpan(150)}</h1>
                {/if}
            </div>

            <div class="tab_content f_tab_content" data-tab-id="2" style="display: none">
                {if $ns.subUsers|@count>0}
                    <div class="table_striped">
                        <div class="table_header_group">
                            <div class="table-row">
                                <div class="table-cell">
                                    {$ns.lm->getPhrase(3)}
                                </div>
                            </div>
                        </div>
                        {foreach from=$ns.subUsers item=su_dto name=pu}
                            <div class="table-row">
                                <div class="table-cell">
                                    {$su_dto->getUserEmail()}		
                                </div>
                            </div>
                        {/foreach}
                    </div>
                {else}
                    <h1>{$ns.lm->getPhraseSpan(145)}</h1>
                {/if}
            </div>
        </div>
    </div>
</div>