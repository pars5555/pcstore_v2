<div class="container_settings">
    <table>
        <thead>
            <tr>
                <th>var</th>
                <th>value</th>
                <th>save</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$ns.settings item=setting name=cp}
            <form action="{$SITE_PATH}/dyn/admin/do_save_setting" autocomplete="off" method="post">
                <input type="hidden" name="var" value="{$setting->getVar()}"/>
                <tr>                   
                    <td>
                        {$setting->getVar()}
                    </td>
                    <td>
                        <input type="text" value="{$setting->getValue()}" name="value"/>
                    </td>
                    <td>
                        <input type="submit" value="save"/>
                    </td>
                </tr>
            </form>
        {/foreach}
        </tbody>
    </table>
</div>