<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/style.css?{$VERSION}" />
		<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/skin.css?{$VERSION}" />
		<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/responsive.css?{$VERSION}" />
		<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/main/fonts.css?{$VERSION}" />
    </head>    
    <body>

        {foreach from=$ns.selected_components item=item name=sc}
            {if isset($item)}
                {if !($item|is_array)}			
                    {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=1 item=$item print=1}				
                {else}
                    {assign var="groupedSameItems" value=$ns.pccm->groupSameItemsInSubArrays($item)}				
                    {foreach from=$groupedSameItems item=subarray}
                        {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=$subarray|@count item=$subarray.0 print=1}			
                    {/foreach}
                {/if}			
            {/if}
        {/foreach}

        <div style="clear:both"> </div>


        {*} PC build fee {*}
        <div class="pcc_build_pc_fee">
            <div class="component_block">
                <div class="component_check"></div>
                <div class="component_img">
                    <span class="glyphicon"></span>
                </div>
                <div class="component_info">
                    {$ns.lm->getPhrase(320)}*
                </div>
                <div class="component_price">
                    <span style="{if $ns.pc_build_fee_amd==0}color:#008800{/if}"> {if $ns.pc_build_fee_amd>0}
                        {$ns.pc_build_fee_amd} Դր.
                        {else}
                            {$ns.lm->getPhrase(289)}
                            {/if} </span>
                        </div>
                    </div>
                </div>


{*   total price   *}
        <div class="pcc_total_price">
            <div class="total_ph">{$ns.lm->getPhrase(261)}</div>
            {if $ns.total_usd>0}
                <span class="price"> ${$ns.total_usd|number_format:1} </span>
            {/if}            
            {if $ns.total_usd>0 && ($ns.total_amd>0 || $ns.pc_build_fee_amd>0)}
                <span class="and_phrase">{$ns.lm->getPhrase(270)}</span>
            {/if}
            {if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
                <span class="{if $ns.pc_configurator_discount>0}old_price{else}price{/if}">{($ns.total_amd+$ns.pc_build_fee_amd)|number_format:0} Դր. </span>
            {/if}
            {if $ns.total_amd==0 && $ns.total_usd==0}
                <span class="price"> 0 Դր. </span>
            {/if}
            <div class="clear"></div>
            {*   discounted price   *}
            {if $ns.total_amd>0}
                <div class="discount text_red">{$ns.lm->getPhrase(285)} {$ns.pc_configurator_discount}%</div>

                {if $ns.total_usd>0}
                    <span class="price">${$ns.total_usd|number_format:1}</span>
                {/if}       
                {if $ns.total_usd>0 && ($ns.total_amd>0 || $ns.pc_build_fee_amd>0)}
                    <span class="and_phrase">{$ns.lm->getPhrase(270)}</span>
                {/if}
                {if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
                    <span class="price"> {$ns.grand_total_amd|number_format:0} Դր. </span>
                {/if}
                {if $ns.total_amd==0 && $ns.total_usd==0}
                    <span class="price">0 Դր. </span>
                {/if}
            {/if}
        </div>

            </body>
        </html>
