<h1>{$ns.lm->getPhrase(59)}</h1>
{if isset($ns.success_message)}
    <div class="alert alert-success">
        <strong><span class="glyphicon"></span> {$ns.success_message}</strong>
    </div>
{/if}
<div id="dl_dealers_container">
    {if $ns.dealers|@count>0}
        <table>
            <thead>
                <tr>
                    <th>{$ns.lm->getPhrase(60)}</th>
                    <th>{$ns.lm->getPhrase(61)}</th>
                    <th>{$ns.lm->getPhrase(62)}</th>
                    <th>{$ns.lm->getPhrase(63)}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$ns.dealers item=dealer name=dl}
                    <tr>
                        <td >{$smarty.foreach.dl.index+1}</td>
                        <td >{$dealer->getUserName()} {$dealer->getUserLastName()}</td>					
                        <td ><span style="display: inline-block;"> 
                                {assign var=phones value=","|explode:$dealer->getUserPhones()}
                                {foreach from=$phones item=phone}
                                    {$phone}
                                    <br/>
                                {/foreach}
                            </span> </td>
                        <td >{$dealer->getUserEmail()}</td>
                        <td>
                            <a  href="{$SITE_PATH}/dyn/company/do_delete_dealer?user_id={$dealer->getUserId()}">{$ns.lm->getPhrase(148)}</a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {else}           
        <h2>{$ns.lm->getPhrase(64)}</h2>
    {/if}

</div>

