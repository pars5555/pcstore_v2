{$ns.companyDto->getName()} Import Price (Step2)

<div>
    items simillarity aceptable percent: 
    <div class="select_wrapper">
        <select id="is1_aceptable_simillarity_percent"  onkeyup="this.blur();
                this.focus();" class="cmf-skinned-select cmf-skinned-text" >
            {html_options values=$ns.acepableItemSimillarityPercentOptions  selected=$ns.acepableItemSimillarityPercent output=$ns.acepableItemSimillarityPercentOptions}
        </select>
    </div>
    %	
    <br>
    {$ns.matched_price_items_count} matched items!
    <br>
    {$ns.unmatched_price_items_count} new items!
</div>

<div id="step2Container" class="table table_striped">

    {*stock items table*}

    <div class="table-row table_header_group">
        <div class="table-cell">
            warehouse
        </div>
        <div class="table-cell">
            Excel
        </div>
    </div>

    <div class="table-cell">
        <div class="table">
            <div class="table-row table_header_group">
                {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle}
                    <div class="table-cell">
                        {$columnTitle}
                    </div>
                {/foreach}
            </div>
            {*stock items list matched to price items*}
            {foreach from=$ns.priceRowsDtos item=rowDto}
                {assign var=correspondingStockItemId value=$rowDto->getMatchedItemId()}
                {if isset($correspondingStockItemId)}
                    {assign var=correspondingStockItemDto value=$ns.stockItemsDtosMappedByIds.$correspondingStockItemId}
                    <div class="table-row" data-istock_table_pk_value="{$correspondingStockItemId}">
                        <div class="table-cell">							
                        </div>

                        {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle}
                            {if $dtoFieldName=="warrantyMonths"}
                                {assign var=fieldName value="warranty"} 
                            {else}
                                {assign var=fieldName value=$dtoFieldName} 
                            {/if}
                            <div class="table-cell" dtoFieldName="{$fieldName}">
                                {$correspondingStockItemDto->$fieldName}
                            </div>
                        {/foreach}
                    </div>
                {else}
                    <div class="table-row">
                        {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle}		
                            <div class="table-cell">
                            </div>
                        {/foreach}			
                    </div>
                {/if}
            {/foreach}

            {*unmatched stock items list to price items*}
            {foreach from=$ns.unmatchedCompanyItems item=stockItemDto}

                <div class="table-row">
                    <div class="table-cell">
                        <button class="ii_link_source_button button blue" pk_value="{$stockItemDto->getId()}">link<br>source</button>
                    </div>
                    {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle}
                        {if $dtoFieldName=="warrantyMonths"}
                            {assign var=fieldName value="warranty"} 
                        {else}
                            {assign var=fieldName value=$dtoFieldName} 
                        {/if}
                        <div class="table-cell" dtoFieldName="{$fieldName}">
                            {$stockItemDto->$fieldName}<br>&nbsp
                        </div>
                    {/foreach}
                </div>

            {/foreach}

        </div>
    </div>

    {*price items table*}
    <div class="table-cell">
        <div class="table">
            <div class="table-row table_header_group">
                <div class="table-cell">
                </div>
                {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle name=columnNamesForeach}
                    <div class="table-cell">
                        {$columnTitle}
                    </div>
                {/foreach}
            </div>

            {foreach from=$ns.priceRowsDtos item=rowDto}
                {assign var=correspondingStockItemId value=$rowDto->getMatchedItemId()}
                {if isset($correspondingStockItemId)}
                    {assign var=correspondingStockItemDto value=$ns.stockItemsDtosMappedByIds.$correspondingStockItemId}
                {/if}
                <div class="table-row" ii_table_pk_value="{$rowDto->id}" style="height:60px">
                    <div class="table-cell">
                        {if $rowDto->getMatchedItemId()>0}
                            <button class="is1_unbind_item" price_item_id="{$rowDto->getId()}">X</button>
                        {else}
                            <button class="ii_link_target_button" pk_value="{$rowDto->getId()}">link<br>target
                            </button>
                        {/if}
                    </div>
                    {foreach from=$ns.columnNames key=dtoFieldName item=columnTitle name=columnNamesForeach}

                        {if $dtoFieldName=="warrantyMonths"}
                            {assign var=originalFieldName value="originalWarranty"} 
                        {else}
                            {assign var=cap value=$dtoFieldName|capitalize}
                            {assign var=originalFieldName value="original`$cap`"} 
                        {/if}
                        <div class="table-cell" dtoFieldName="{$dtoFieldName}" dtoOriginalFieldName="{$originalFieldName}" pk_value="{$rowDto->id}" cellValue = "{$rowDto->$dtoFieldName}" originalCellValue = "{$rowDto->$originalFieldName}" class="is1_popup_menu_td">							
                            <span class="editable_cell" id="ii_table_editable_span_{$rowDto->getId()}_{$dtoFieldName}" dtoFieldName='{$dtoFieldName}' pk_value="{$rowDto->id}" 
                                  style='width:100%;
                                  {if !($rowDto->getMatchedItemId()>0)}color:red{/if}		
                                  {if isset($correspondingStockItemDto) && $correspondingStockItemDto->$dtoFieldName|regex_replace:"#\s+#":""|lower!=
												$rowDto->$dtoFieldName|regex_replace:"#\s+#":""|lower}color:magenta;{/if}'>{$rowDto->$dtoFieldName}</span>
                            {*
                            <br>
                            <span style="color:#888">{$rowDto->$originalFieldName}</span>	
                            *}
                        </div>
                    {/foreach}
                </div>
            {/foreach}
        </div>
    </div>
</div>


<ul id="is1_popup_menu" style="position:fixed;display: none"> 
    <li><a id="is1_menu_copy" href="javascript:void(0);">Copy</a></li>
    <li><a id="is1_menu_copy_original" href="javascript:void(0);">Copy Original Value</a></li>
    <li><a id="is1_menu_paste" href="javascript:void(0);">Paste</a></li>
    <li><a id="is1_menu_delete" href="javascript:void(0);">Delete</a></li>
</ul>
<input type="hidden" id="is1_used_columns_indexes_array" value="{$ns.used_columns_indexes_array}" />