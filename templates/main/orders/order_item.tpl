<div class="order_item_block">
	<div class="order_item_name">
		{$orderItem->getOrderDetailsItemDisplayName()}
	</div>
	<div class="order_item_count">
		{$orderItem->getOrderDetailsItemCount()}x
	</div>
	<div class="order_item_price">
		{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
		{if $orderItem->getOrderDetailsIsDealerOfItem() != 1}
		<span class="price">{$ns.itemManager->exchangeFromUsdToAMD($orderItem->getOrderDetailsCustomerItemPrice(), $orderItem->getDollarExchangeUsdAmd())|number_format:0} Դր.</span>
		{/if}
		{/if}
		{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
		{if $orderItem->getOrderDetailsIsDealerOfItem() == 1}
		<span class="price"> ${$orderItem->getOrderDetailsCustomerItemPrice()|number_format:1}</span>
		{/if}
		{/if}
	</div>
</div>