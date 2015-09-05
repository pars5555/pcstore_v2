{$ns.companyDto->getName()} Import Price (Select Sheet)
<form method="POST" action="{$SITE_PATH}/admin/imp/step1">
    <div class="select_wrapper">
        <select name="sheet_index">
            {foreach from=$ns.sheets item=sheet_name key=sheet_index}
                <option value="{$sheet_index}">{$sheet_name}</option>
            {/foreach}
        </select> 
    </div>
    <input type="hidden" name="company_id" value="{$ns.company_id}"/>
    <input type="hidden" name="price_index" value="{$ns.price_index}"/>
    <input class="button blue" type="submit" value="next"/>
</form>