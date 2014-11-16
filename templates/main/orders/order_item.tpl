{$orderItem->getOrderDetailsItemDisplayName()}
{$orderItem->getOrderDetailsItemCount()}
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
    {if $orderItem->getOrderDetailsIsDealerOfItem() != 1}
        {$ns.itemManager->exchangeFromUsdToAMD($orderItem->getOrderDetailsCustomerItemPrice(), $orderItem->getDollarExchangeUsdAmd())|number_format:0} Դր.
    {/if}
{/if}
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
    {if $orderItem->getOrderDetailsIsDealerOfItem() == 1}
        ${$orderItem->getOrderDetailsCustomerItemPrice()|number_format:1}
    {/if}			
{/if}
