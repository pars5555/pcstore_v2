<div class="container_settings">

    <div class="table_striped admin_companies_list">
        <div class="table_header_group">
            <div class="table-row">
                <div class="table-cell">
                    var
                </div>
                <div class="table-cell">
                    value
                </div>
                <div class="table-cell">
                    save
                </div>
            </div>
        </div>
        {foreach from=$ns.settings item=setting name=cp}
            <form class="table-row" action="{$SITE_PATH}/dyn/admin/do_save_setting" autocomplete="off" method="post">
                <input type="hidden" name="var" value="{$setting->getVar()}"/>
                <div class="table-cell">
                    {$setting->getVar()}
                </div>
                <div class="table-cell">
                    <input class="text" type="text" value="{$setting->getValue()}" name="value"/>
                </div>
                <div class="table-cell">
                    <input class="button inline blue" type="submit" value="save"/>
                </div>
            </form>
        {/foreach}
    </div>
</div>