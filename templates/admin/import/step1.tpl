{$ns.companyDto->getName()} Import Price (Step1)
<form method="POST" action="{$SITE_PATH}/admin/imp/step2">
    <input type="hidden" name="company_id" value="{$ns.company_id}"/>
    <input type="hidden" name="price_index" value="{$ns.price_index}"/>
    <input type="hidden" name="sheet_index" value="{$ns.sheet_index}"/>
    <input id="selected_row_ids" type="hidden" name="selected_row_ids" value=""/>
    <input id="select_values" type="hidden" name="select_values" value=""/>
    <input id="step_1_form" class="button blue" type="submit" value="next"/>
</form>

<div id="step1Container" class="table table_striped">
    {foreach from=$ns.price_values item=price_row name=pvFor}
        <div class="table-row table_header_group">
            <div class="table-cell">
                <input class="f_check_all" type="checkbox" />
            </div>
            {foreach from=$price_row key=colName item=colValue}
                <div class="table-cell">
                    {$colName}
                </div>
            {/foreach}
        </div>
        <div class="table-row">
            <div class="table-cell">
            </div>
            {foreach from=$price_row key=colName item=colValue}
                <div class="table-cell">
                    <div class="select_wrapper select_wrapper_min">
                        <select data-name="{$colName}">
                            {html_options options=$ns.columns_label selected=0}
                        </select>
                    </div>
                </div>
            {/foreach}
        </div>
        {break}
    {/foreach}
    {foreach from=$ns.price_values item=price_row name=pvFor}
        <div class="table-row">
            <div class="table-cell">
                <input data-row-id="{$price_row.id}" type="checkbox" />
            </div>
            {foreach from=$price_row key=colName item=colValue}
                <div class="table-cell">
                    {$colValue} 
                </div>
            {/foreach}
        </div>
    {/foreach}
</div>