<div class="cart-item bundle-cart-item" id="cart_bundle_container^{$bundleItems.0->getId()}" >
	<div class="component_block">
		

		{assign var="bundlePrice" value=$ns.bundleItemsManager->calcBundlePriceForCustomerWithoutDiscount($bundleItems, $ns.userLevel)}

		{assign var= "count" value =$bundleItems.0->getCount()}
		{assign var= "specialFee" value =$bundlePrice.2}
		{assign var="totUSD" value="`$count*$bundlePrice.1`"}

		{assign var="bundle_item_total_deal_discount_amd" value=$ns.checkoutManager->getBundleItemTotalDealsDiscountAMD($bundleItems)}

		<span class="discount">{math equation="1 - x/100" x=$bundleItems.0->getDiscount() assign="discountParam"}</span>
		{foreach from=$bundleItems item=cartItem}
		{if $cartItem->getItemAvailable() == 0 && $cartItem->getSpecialFeeId() == 0}
		{assign var='someItemsMissing' value='true'}
		{/if}
		{/foreach}
		<div class="component_img">
			<img src="{$ns.itemManager->getItemImageURL(0,0, '150_150', 1)}"/>
		</div>
		<div class="component_info" style="{if isset($someItemsMissing)}color:red;{/if}">
			{assign var="phrase_id" value = $bundleItems.0->getBundleDisplayNameId()}
			{$ns.lm->getPhrase($phrase_id)}
		</div>
		{if !isset($someItemsMissing)}
		<div class="cart_item_count">
			<div class="select_wrapper">
				<select id="cart_item^{$bundleItems.0->getId()}">
					{section name=foo start=1 loop=21 step=1}
					{assign var='index' value=$smarty.section.foo.index}
					<option value="{$index}" {if $bundleItems.0->getCount() == $index}selected="selected"{/if}>{$index}</option>
					{/section}
				</select>
			</div>
		</div>
		{/if}
		
		
		<div class="component_unit_prie">
			{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
			{if !isset($someItemsMissing)}
			{if $bundlePrice.0+$specialFee > 0}
			<span class="price {if $discountParam != 1 || $bundle_item_total_deal_discount_amd>0}old_price{/if}"> {$bundlePrice.0+$specialFee|number_format:0} Դր. </span>
			{if $discountParam != 1}
			<br/>
			<span class="price {if $bundle_item_total_deal_discount_amd>0}old_price{/if}"> {$bundlePrice.0*$discountParam+$specialFee|number_format:0} Դր. </span>
			{/if}
			{if $bundle_item_total_deal_discount_amd>0}
			<br/>
			<span class="price"> {$bundlePrice.0*$discountParam+$specialFee-$bundle_item_total_deal_discount_amd|number_format:0} Դր. </span>
			{/if}
			{/if}
			{/if}
			{/if}
			{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
			{if !isset($someItemsMissing)}
			{if $bundlePrice.1 > 0}
			<br/>
			<span class="price">${$bundlePrice.1|number_format:1}</span>
			{/if}
			{/if}
			{/if}
		</div>

		{math equation="count*(price*discount+specFee)" discount=$discountParam count=$count price=$bundlePrice.0 specFee=$specialFee assign="totAMDWithDiscount"}
		{math equation="count*(price+specFee)" discount=$discountParam count=$count price=$bundlePrice.0 specFee=$specialFee assign="totAMDWithoutDiscount"}

		<div class="component_total_price">
			{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
			{if !isset($someItemsMissing)}
			{if $bundlePrice.0+$specialFee > 0}
			<span class="price {if $discountParam != 1 || $bundle_item_total_deal_discount_amd>0}old_price{/if}"> {$totAMDWithoutDiscount|number_format:0} Դր. </span>
			{if $discountParam != 1}
			<br/>
			<span class="price {if $bundle_item_total_deal_discount_amd>0}old_price{/if}"> {$totAMDWithDiscount|number_format:0} Դր. </span>
			{/if}
			{if $bundle_item_total_deal_discount_amd>0}
			<br/>
			<span class="price"> {$totAMDWithDiscount-$count*$bundle_item_total_deal_discount_amd|number_format:0} Դր. </span>

			{/if}
			{/if}
			{/if}
			{/if}
			{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
			{if !isset($someItemsMissing)}
			{if $bundlePrice.1 > 0}
			<br/>
			<span class="price"> ${$totUSD|number_format:1} </span>
			{/if}
			{/if}
			{/if}
		</div>
		{if !isset($someItemsMissing)}
		<div class="discount">
			{if $bundleItems.0->getDiscount() > 0}
			{$ns.lm->getPhrase(285)} {$bundleItems.0->getDiscount()}%
			<br/>
			{/if}
			{if $bundle_item_total_deal_discount_amd>0}
			{$count} x {$bundle_item_total_deal_discount_amd|number_format:0} Դր.
			{/if}
		</div>
		{/if}
		<div class="component_delete">
			<a  href="{$SITE_PATH}/dyn/main/do_delete_cart_item?id={$bundleItems.0->getId()}"> <span class="item-delete glyphicon"></span> </a>
		</div>
	</div>

	<!-- =======================Computer Bundle Details==================== -->

	<div class="bundle">
		<a href="javascript:void(0)" class="f_bundle_btn see_more button blue">See Components</a>
		<a class="component_edit button blue" href="{$SITE_PATH}/buildpc/{$bundleItems.0->getId()}">{$ns.lm->getPhrase(288)}...</a>
		<div class="f_bundle_wrapper bundle-components-wrapper" id="cart_bundle_items_container_{$bundleItems.0->getId()}">
				{assign var="bundle_items" value = "true"}
				{foreach from=$bundleItems item=cartItem}
				{include file="$TEMPLATE_DIR/main/cart/cart_item.tpl" cartItem=$cartItem bundle="true"}
				{/foreach}
		</div>
	</div>
</div>

