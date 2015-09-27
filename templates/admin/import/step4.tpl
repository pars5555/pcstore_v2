<h3 class="main_title">
    {$ns.companyDto->getName()} Import Price (Step3)
</h3>

<a href="{$SITE_PATH}/dyn/admin/do_import_steps_actions_group?action=import&company_id={$ns.companyDto->getId()}" class="button blue" >Next</a>

<div oncontextmenu="return false;" id="is3_container_div">
    <button id="is3_select_all" class="button blue inline small">Select All</button>
    <button id="is3_select_none" class="button blue inline small">Select None</button> 
    {*stock items table*}
    <div class="table_striped" id="ii_table_view" style="margin-top:20px;">
        <div class="table_header_group">
            <div class="table-row">
                <div class="table-cell">
                    change
                </div>

                <div class="table-cell">
                    info
                </div>

                {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle}
                    <div class="table-cell" {if $dtoFieldName=='displayName'}style="min-width:400px"{/if} class="is3_popup_menu_th" fieldName="{$dtoFieldName}">
                        {$columnTitle}
                    </div>
                {/foreach}

                <div class="table-cell">
                    Spec
                </div>	

                <div class="table-cell">
                    <button class=" button blue inline small" id="f_find_all_simillar_items">fine all simillar items</button>
                </div>

            </div>
        </div>
        {*stock items list matched to price items*}

        {foreach from=$ns.priceRowsDtos item=rowDto}
            {assign var=correspondingStockItemId value=$rowDto->getMatchedItemId()}
            {if isset($correspondingStockItemId)}
                {assign var=correspondingStockItemDto value=$ns.stockItemsDtosMappedByIds.$correspondingStockItemId}
                <div class="table-row" style="height:60px">
                    <div class="table-cell">
                        <input type="checkbox" class="is3_include_row"  pk_value="{$rowDto->getId()}" 
                               row_id="{$rowDto->getId()}" {if $rowDto->getImport()==1}checked{/if} autocomplete="off"/>
                    </div>
                    <div class="table-cell">
                        stock<br>price<br>original price
                    </div>
                    {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle}
                        {if $dtoFieldName=="warrantyMonths"}
                            {assign var=fieldName value="warranty"} 
                            {assign var=originalFieldName value="originalWarranty"} 
                        {else}
                            {assign var=fieldName value=$dtoFieldName}
                            {assign var=cap value=$dtoFieldName|@ucfirst}
                            {assign var=originalFieldName value="original`$cap`"} 
                        {/if}					


                        <div class="table-cell" fieldName="{$dtoFieldName}" id="is3_editable_td_{$dtoFieldName}_{$rowDto->id}" pk_value="{$rowDto->id}" 
                             stockItemValue = "{$correspondingStockItemDto->$fieldName}" class="is3_popup_menu_td {$dtoFieldName}" 
                             style='max-width:100px; overflow: hidden;text-overflow: ellipsis;
                             {assign var=rowId value=$rowDto->getId()}	
                             {if $ns.changedFields.$rowId.$fieldName == 1}color:magenta;{/if}'>
                            {$correspondingStockItemDto->$fieldName|default:"empty"}<br>
                            <span class="editable_cell" dtoFieldName='{$dtoFieldName}' pk_value="{$rowDto->id}"
                                  id="ii_table_editable_span_{$rowDto->id}_{$dtoFieldName}">{$rowDto->$dtoFieldName|default:"empty"}</span>
                            <br>
                            {$rowDto->$originalFieldName|default:"empty"}
                        </div>
                    {/foreach}
                    <div class="table-cell">							
                        <button class="is3_spec_button button blue inline small" pk_value="{$rowDto->getId()}">spec</button>                            
                        <textarea class="text" style="display: none;" pk_value="{$rowDto->getId()}" id="is3_item_short_spec_{$rowDto->getId()}">{$rowDto->getShortSpec()}</textarea>
                        <textarea class="text" style="display: none;" pk_value="{$rowDto->getId()}" id="is3_item_full_spec_{$rowDto->getId()}">{$rowDto->getFullSpec()}</textarea>
                    </div>
                    <div class="table-cell">		
                        <input type="text" id="is3_simillar_item_search_text_{$rowDto->getId()}" class="is3_simillar_item_search_texts text" pk_value="{$rowDto->getId()}" style="margin-bottom:5px;"/>
                        <button class="is3_find_simillar_items_button button blue inline small" id="is3_find_simillar_items_button_{$rowDto->getId()}" pk_value="{$rowDto->getId()}">load</button>
                        <div class="is3_find_simillar_items_select_wrapper select_wrapper select_wrapper_min inline-block">
                            <select class="is3_simillar_items_select" style="max-width:150px" id="simillar_items_select_{$rowDto->getId()}" pk_value="{$rowDto->getId()}"></select>                                                        
                        </div>
                    </div>
                </div>				
            {/if}
        {/foreach}

    </div>	
</div>
<ul id="is3_popup_menu" style="position:fixed;display: none"> 
    <li><a id="is3_take_stock_value" href="javascript:void(0);">Take Stock Value</a></li>
    <li><a id="is3_menu_delete" href="javascript:void(0);">Delete</a></li>
</ul>