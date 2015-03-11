<div id="inviteSuccessMessage" class="success invite_mes"></div>
<div id="inviteErrorMessage" class="error invite_mes"></div>
<form method="post" autocomplete="off" action="{$SITE_PATH}/dyn/user/do_invite" id="userInviteForm">
    <label class="input_label default_width" for="email">Email</label>
    <input id="userInviteEmail" class="text default_width" type="email" name="email"/>
    <button  class="button blue">Invite</button>
</form>
{if $ns.pendingUsers|@count>0}
    <h1>{$ns.lm->getPhrase(147)}</h1>
    {assign var="yesterday" value='-1 day'|strtotime}
    {assign var="yesterday" value=$yesterday|date_format:"%Y-%m-%d %H:%M:%S"}
    <table>
        <th>{$ns.lm->getPhrase(60)}</th>
        <th>{$ns.lm->getPhrase(3)}</th>
        <th>Resend</th>
            {foreach from=$ns.pendingUsers item=pu_dto name=pu}
            <tr	>
                <td>{$smarty.foreach.pu.index+1}</td>
                <td>{$pu_dto->getPendingSubUserEmail()}</td>			
                <td>
                    {if $pu_dto->getLastSent()<$yesterday}
                        <button data-invite-email="{$pu_dto->getPendingSubUserEmail()}" class="f_resend_invite button blue inline small" pk="{$pu_dto->getId()}">{$ns.lm->getPhrase(612)}</button>
                    {/if}
                </td>			

            </tr>
        {/foreach}
    </table>
{else}
    <div style="text-align: center;margin:20px">
        <h1>{$ns.lm->getPhraseSpan(150)}</h1>
    </div>
{/if}