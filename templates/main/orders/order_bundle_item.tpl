{assign var="bundleInfo" value=$orderItem[0]}
{foreach from=$orderItem item=bundleItem name=foo}	
    {if $bundleItem->getOrderDetailsSpecialFeeId()>0}
        {assign var="special_fee_display_name_id" value=$bundleItem->getOrderDetailsSpecialFeeDisplayNameId()}
        {$ns.lm->getPhrase($special_fee_display_name_id)}
    {else}	
        {$bundleItem->getOrderDetailsItemDisplayName()}
    {/if}	
    {$bundleItem->getOrderDetailsItemCount()}

    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
        {if $bundleItem->getOrderDetailsSpecialFeeId()>0}
            {$bundleItem->getOrderDetailsSpecialFeePrice()} Դր.
        {else}
            {if $bundleItem->getOrderDetailsIsDealerOfItem() != 1}				
                {assign var="customer_item_price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($bundleItem->getOrderDetailsCustomerItemPrice(), $bundleItem->getDollarExchangeUsdAmd())}				  				  
                {math equation="price*(1 - x/100)" x=$bundleItem->getOrderDetailsDiscount() price =$customer_item_price_in_amd assign="customer_item_price_in_amd_without_discount"}
                <span style="text-decoration: line-through;">
                    {$customer_item_price_in_amd|number_format:0} Դր.
                </span>
                <br />
                {$customer_item_price_in_amd_without_discount|number_format:0} Դր.
            {/if}
        {/if}
    {/if}
    {if $ns.priceVariety == 'both' or $ns.priceVariety == 'usd'}
        {if $bundleItem->getOrderDetailsIsDealerOfItem() == 1}
            ${$bundleItem->getOrderDetailsItemDealerPrice()|number_format:1}
        {/if}			
    {/if}
{/foreach}