<div class="cart-item" style="{if $ns.include_vat==1 && $cartItem->getCustomerVatItemPrice()==0 && $cartItem->getItemId()>0}color:red{/if}">
	<!-- ===============================Component Block================================= -->
	{block name="component_block"}
	<div class="component_block">
		{math equation="1 - x/100" x=$cartItem->getDiscount() assign="discountParam"}
		<!-- ==============Component image============== -->

		<div class="component_img">
			{if $cartItem->getItemAvailable() == 1}
			{if isset($bundle_items)}
			{assign var="itemId" value=$cartItem->getBundleItemId()}
			{else}
			{assign var="itemId" value=$cartItem->getItemId()}
			{/if}
			{if !isset($bundle_items)}
			<img src="{$ns.itemManager->getItemImageURL($itemId,$cartItem->getItemCategoriesIds(), '150_150', 1 , true)}"/>

			{else}
			<!-- <img src="{$SITE_PATH}/img/your_pc.png"/> -->
			<img src="{$ns.itemManager->getItemImageURL($itemId,$cartItem->getItemCategoriesIds(), '60_60', 1 , true)}"/>
			{/if}
			{/if}
		</div>

		<!-- ==============Component Information============== -->

		<div class="component_info"  style="{if $cartItem->getItemAvailable() == 0 && $cartItem->getSpecialFeeId() == 0}color:red;{/if}">
			<span> {if $cartItem->getSpecialFeeId() > 0}
				{assign var="spec_fee_desc_id" value = $cartItem->getSpecialFeeDescriptionTextId()}
				{$ns.lm->getPhrase($spec_fee_desc_id)}
				{else}
				{if $cartItem->getItemAvailable() == 1}
				{$cartItem->getItemDisplayName()}
				{else}
				{if isset($bundle_items)}
				{$cartItem->getBundleCachedItemDisplayName()}
				{else}
				{$cartItem->getCachedItemDisplayName()}
				{/if}
				{/if}
				{/if} </span>
		</div>


		<!-- ==============Component Count============== -->

		{if $cartItem->getItemAvailable() == 1}
		{if isset($bundle)}
		<span class="component_count">{$cartItem->getBundleItemCount()}x</span>
		{else}
		<div class="cart_item_count">
			<div class="select_wrapper">
				<select {if isset($bundle_items)}disabled="true"{/if} >
					{section name=foo start=1 loop=$ns.maxItemCartCount+1 step=1}
					{assign var='index' value=$smarty.section.foo.index}
					{if isset($bundle_items)}
					{assign var='count' value=$cartItem->getBundleItemCount()}
					{else}
					{assign var='count' value=$cartItem->getCount()}
					{/if}
					<option value="{$index}" {if $count == $index}selected="selected"{/if}>{$index}</option>
					{/section}

				</select>
			</div>
		</div>
		{/if}
		{/if}

		<!-- ==============Parameter Assign Block============== -->

		{if isset($bundle_items)}
		{assign var= "count" value = $cartItem->getBundleItemCount()}
		{else}
		{assign var= "count" value = $cartItem->getCount()}
		{/if}

		{if $cartItem->getSpecialFeeId() > 0}
		{if $cartItem->getSpecialFeeDynamicPrice()>=0}
		{assign var="price" value=$cartItem->getSpecialFeeDynamicPrice()}
		{else}
		{assign var="price" value=$cartItem->getSpecialFeePrice()}
		{/if}
		{else}
		{if $cartItem->getIsDealerOfThisCompany()==1 || $ns.userLevel === $ns.userGroupsAdmin || $ns.userLevel === $ns.userGroupsCompany}
		{assign var="showDealerPrice" value=1}
		{if $ns.include_vat == 1 && $cartItem->getItemId()>0}
		{assign var="price" value=$cartItem->getItemVatPrice()}
		{else}
		{assign var="price" value=$cartItem->getItemDealerPrice()}
		{/if}
		{else}
		{assign var="showDealerPrice" value=0}
		{if $ns.include_vat == 1 && $cartItem->getItemId()>0}
		{assign var="price" value=$cartItem->getCustomerVatItemPrice()}
		{else}
		{assign var="price" value=$cartItem->getCustomerItemPrice()}
		{/if}
		{/if}

		{assign var="totP" value="`$count*$price`"}

		{/if}

		<!-- ==============Component Unit price AMD============== -->

		{* printing item price *}

		{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
		<div class="component_unit_prie">
			{if $cartItem->getSpecialFeeId() > 0}
			{else}
			{if $cartItem->getItemAvailable() == 1}
			{if $showDealerPrice == 0}
			{assign var="itemAmdPrice" value=$ns.itemManager->exchangeFromUsdToAMD($price)}
			<span class="price {if $discountParam != 1 || $cartItem->getDealDiscountAmd()>0}old_price{/if}"> {$itemAmdPrice|number_format:0} Դր. </span>
			{if $discountParam != 1 && $cartItem->getDealDiscountAmd()<=0}
			<br/>
			<span class="price"> {$itemAmdPrice*$discountParam|number_format:0} Դր. </span>
			{/if}
			{if $cartItem->getDealDiscountAmd()>0}
			<br/>
			<span class="price"> {$itemAmdPrice-$cartItem->getDealDiscountAmd()|number_format:0} Դր. </span>

			{/if}
			{/if}
			{/if}
			{/if}

			{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
			{if $cartItem->getItemAvailable() == 1}
			{if $showDealerPrice == 1}
			<span class="price">${$price|number_format:1}</span>
			{/if}
			{/if}
			{/if}
		</div>
		{/if}

		<!-- ==============Component Unit Price AMD============== -->

		{* printing item total price *}
		{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
		<div class="component_total_price">
			{if $cartItem->getSpecialFeeId() > 0}
			<span class="price"> {$price|number_format:0} Դր. </span>
			{else}
			{if $cartItem->getItemAvailable() == 1}
			{if  $showDealerPrice == 0}
			{assign var="totPrAMD" value=$ns.itemManager->exchangeFromUsdToAMD($totP)}
			<span  class="price {if $discountParam != 1 || $cartItem->getDealDiscountAmd()>0}old_price{/if}"> {$totPrAMD|number_format:0} Դր. </span>
			{if $discountParam != 1 && $cartItem->getDealDiscountAmd()<=0}
			<br/>
			<span class="price"> {$totPrAMD*$discountParam|number_format:0} Դր. </span>
			{/if}
			{if $cartItem->getDealDiscountAmd()>0}
			<br/>
			<span class="price"> {$totPrAMD-$count*$cartItem->getDealDiscountAmd()|number_format:0} Դր. </span>

			{/if}
			{/if}
			{/if}
			{/if}
			{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
			{if $cartItem->getItemAvailable() == 1}
			{if $showDealerPrice == 1}
			<span class="price">${$totP|number_format:1}</span>
			{/if}
			{/if}
			{/if}
		</div>
		{/if}

		<!-- ==============Parameters Assign Bock============== -->

		{if $cartItem->getDealDiscountAmd()>0}
		{assign var="deal_discount_applied" value=true}
		{/if}
		{if 0 < $cartItem->getDiscount() && isset($showDealerPrice) && $showDealerPrice==0 && $cartItem->getSpecialFeeId()==0 && $cartItem->getItemAvailable()==1}
		{assign var="discount_available" value=true}
		{else}
		{assign var="discount_available" value=false}
		{/if}

		<!-- ==============Component Discount============== -->

		{if isset($deal_discount_applied) || $discount_available}
		<div class="component_discount">
			{if $discount_available && $cartItem->getDealDiscountAmd()<=0}
			<span class="discount">{$ns.lm->getPhrase(285)} {$cartItem->getDiscount()}%</span>
			{/if}
			{if isset($deal_discount_applied)}
			<br/>
			<span class="price">{$count} x {$cartItem->getDealDiscountAmd()|number_format:0} Դր.</span>
			{/if}
		</div>
		{/if}
		<!-- ==============Component Delete============== -->

		{if !isset($bundle_items)}
		<div class="component_delete">
			<a  href="{$SITE_PATH}/dyn/main/do_delete_cart_item?id={$cartItem->getId()}"> <span class="item-delete glyphicon"></span> </a>
		</div>
		{/if}
	</div>
	{/block}
</div>