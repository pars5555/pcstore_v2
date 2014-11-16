<div id="inviteSuccessMessage"></div>
<div id="inviteErrorMessage"></div>
<form method="post" autocomplete="off" action="{$SITE_PATH}/dyn/user/do_invite" id="userInviteForm">
    <input type="email" name="email"/>
    <button  class="btn btn-default btn-primary">Invite</button>
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
                        <button pk="{$pu_dto->getId()}">{$ns.lm->getPhrase(612)}</button>
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