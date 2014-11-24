{if ($ns.userLevel === $ns.userGroupsCompany || $ns.userLevel===$ns.userGroupsAdmin) || $item->getIsDealerOfThisCompany() == 1}
{assign var="showDealerPrice" value=true}
{else}
{assign var="showDealerPrice" value=false}
{/if}

{assign var="admin_show_dealer_price" value=1}
{if $ns.userLevel==$ns.userGroupsAdmin}
{if $ns.admin_price_group != 'admin'}
{assign var="admin_show_dealer_price" value=0}
{/if}
{/if}
<div class="pcc_total_calc_item_price_row">
	<div class="component_block">
		<div class="component_check">
			<span class="item-delete pull-right glyphicon f_deleteSelectedComponentBtn" href="javascript:void(0);"></span>
		</div>
		<div class="component_img">
			<img src="{$ns.itemManager->getItemImageURL($item->getId(), $item->getCategoriesIds(),'60_60', 1 , true)}" />
		</div>
		<div class="component_info">
			<span class="pcc_total_calc_item_price_row_item_title">{$item->getDisplayName()} </span>
		</div>
		<div class="component_count">			
			<span class="pcc_total_calc_item_price_row_item_count">{$count}x</span>
		</div>
		<div class="component_price">
			<span class="pcc_total_calc_item_price_row_item_price real-price"> {if $showDealerPrice == true && $admin_show_dealer_price == 1}
				{assign var="price" value=$item->getDealerPrice()}
				${$price*$count|number_format:1}
				{else}
				{assign var="price" value=$item->getCustomerItemPrice()}
				{assign var="amdPrice" value=$ns.itemManager->exchangeFromUsdToAMD($price)}
				{$amdPrice*$count|number_format:0} Դր.
				{/if} </span>
		</div>
	</div>
</div>