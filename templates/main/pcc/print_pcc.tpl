{foreach from=$ns.selected_components item=item name=sc}
    {if isset($item)}
        {if !($item|is_array)}			
            {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=1 item=$item}				
        {else}
            {assign var="groupedSameItems" value=$ns.pccm->groupSameItemsInSubArrays($item)}				
            {foreach from=$groupedSameItems item=subarray}
                {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=$subarray|@count item=$subarray.0}			
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

<div class="pcc_total_price">
	{$ns.lm->getPhrase(261)}
	{if $ns.total_usd>0}
	<span class="text_green"> ${$ns.total_usd|number_format:1} </span>
	{/if}
	{if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
	<span class="text_blue">{($ns.total_amd+$ns.pc_build_fee_amd)|number_format:0} Դր. </span>
	{/if}
	{if $ns.total_amd==0 && $ns.total_usd==0}
	<span class="text_blue"> 0 Դր. </span>
	{/if}

	{*   discounted price   *}
	{if $ns.total_amd>0}
	{$ns.lm->getPhrase(285)} {$ns.pc_configurator_discount}%

	{if $ns.total_usd>0}
	${$ns.total_usd|number_format:1}
	{/if}
	{if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
	{$ns.grand_total_amd|number_format:0} Դր.
	{/if}
	{if $ns.total_amd==0 && $ns.total_usd==0}
	0 Դր.
	{/if}
	{/if}
</div>