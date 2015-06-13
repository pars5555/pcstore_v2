<div class="container_import">

    {if isset($ns.selectedCompanyDto)}
        <div id="im_header_container">
            <select onkeyup="this.blur();
                    this.focus();" class="cmf-skinned-select cmf-skinned-text f_price_column_name" id="ip_select_price">
                {foreach from=$ns.price_names item=price_name key=price_index}
                    <option value="{$price_index}" {if $price_index==$ns.selected_price_index}selected="selected"{/if} >{$price_name}</option>
                {/foreach}
            </select>
            <select onkeyup="this.blur();
                    this.focus();" class="cmf-skinned-select cmf-skinned-text f_price_column_name" id="ip_select_worksheet">
                {foreach from=$ns.price_sheets_names item=col_name key=col_index}
                    <option value="{$col_index}" {if $col_index==$ns.selected_sheet_index}selected="selected"{/if} >{$col_name}</option>
                {/foreach}
            </select>
            <select onkeyup="this.blur();
                    this.focus();" class="cmf-skinned-select cmf-skinned-text f_price_column_name" id="ip_select_brand_model_name_concat_method">
                <option value="n" selected>Name</option>
                <option value="bmn" >Brand+Model+Name</option>
                <option value="bn" >Brand+Name</option>
                <option value="mn" >Model+Name</option>
            </select>
            <button id="ip_select_all" class="button glyph">Select All</button>
            <button id="ip_select_none" class="button glyph">Select None</button>
        </div>
        {if $ns.priceNotFound == true}
            price not found!	
        {else}
            <table style="background-color: #ddd">
                <thead>
                    <tr>
                        <th>				
                        </th>
                        {foreach from=$ns.allColumns item=columnId}
                            <th>
                                {assign var=selected_index value=0}
                                {if isset($ns.modelColumnName) && $columnId == $ns.modelColumnName}
                                    {assign var=selected_index value=1}
                                {/if}
                                {if isset($ns.itemNameColumnName) && $columnId == $ns.itemNameColumnName}
                                    {assign var=selected_index value=2}
                                {/if}
                                {if isset($ns.dealerPriceColumnName) && $columnId == $ns.dealerPriceColumnName}
                                    {assign var=selected_index value=3}
                                {/if}
                                {if isset($ns.dealerPriceAmdColumnName) && $columnId == $ns.dealerPriceAmdColumnName}
                                    {assign var=selected_index value=4}
                                {/if}
                                {if isset($ns.vatPriceColumnName) && $columnId == $ns.vatPriceColumnName}
                                    {assign var=selected_index value=5}
                                {/if}
                                {if isset($ns.vatPriceAmdColumnName) && $columnId == $ns.vatPriceAmdColumnName}
                                    {assign var=selected_index value=6}
                                {/if}
                                <select onkeyup="this.blur();
                                        this.focus();" class="cmf-skinned-select cmf-skinned-text f_price_column_name" column_id="{$columnId}" style="float:left">
                                    {foreach from=$ns.priceColumnOptions item=col_name key=col_index}
                                        <option value="{$col_index}" {if $col_index==$selected_index}selected="selected"{/if} class="translatable_element" phrase_id="Model">{$col_name}</option>
                                    {/foreach}
                                </select>
                    <div style="cursor: pointer;float:left;padding: 5px;background:#fff;color:#F00;margin-left: 5px" title="Delete Column" 
                         class="ip_delete_column" column_letter="{$columnId}">X</div>
                    </th>
                {/foreach}
                </tr>
                </thead>
                <tbody style="line-height: 14px">

                    {foreach from=$ns.valuesByRows item=row key=key}
                        <tr>
                            <td>						
                                <input type="checkbox" class="ip_include_row" row_index="{$key}"							   
                                       {if $key|in_array:$ns.selected_rows_index}
                                           checked="checked"
                                       {/if}/>
                            </td>
                            {foreach from=$row key=cellKey item=cellValue}
                                <td style='max-width:400px; overflow: hidden;text-overflow: ellipsis;'>{$cellValue}</td>
                            {/foreach}


                        </tr>
                    {/foreach}

                </tbody>
            </table>
        {/if}
    {/if}

    <div class="table_striped admin_companies_list">
        <div class="table_header_group">
            <div class="table-row">
                <div class="table-cell">
                    Company logo
                </div>
                <div class="table-cell">
                    Company name
                </div>
            </div>
        </div>
        {foreach from=$ns.allCompaniesDtos item=companyDto}
            <a class="table-row" href="{$SITE_PATH}/admin/import/{$companyDto->getId()}" style="{if isset($ns.selectedCompanyDto) && $ns.selectedCompanyDto->getId()==$companyDto->getId()}color:red{/if}">
                <span class="table-cell">
                    <img {if $companyDto->getPassive() == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/small_logo/{$companyDto->getId()}" alt="logo"/>
                </span>
                <span class="table-cell">
                    {$companyDto->getName()}
                </span>
            </a>
        {/foreach}
    </div>
</div>