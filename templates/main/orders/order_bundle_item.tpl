{assign var="bundleInfo" value=$orderItem[0]}
{foreach from=$orderItem item=bundleItem name=foo}
    <div class="order_bundle_item">
        {if $bundleItem->getOrderDetailsSpecialFeeId()>0}
            {assign var="special_fee_display_name_id" value=$bundleItem->getOrderDetailsSpecialFeeDisplayNameId()}
            <div>{$ns.lm->getPhrase($special_fee_display_name_id)}</div>
        {else}	
            <div>{$bundleItem->getOrderDetailsItemDisplayName()}</div>
        {/if}	
        <div></div>
        <div>{$bundleItem->getOrderDetailsItemCount()}</div>
        <div class="order_bundle_price">
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
        </div>
        <div class="order_bundle_price">
            {if $ns.priceVariety == 'both' or $ns.priceVariety == 'usd'}
                {if $bundleItem->getOrderDetailsIsDealerOfItem() == 1}
                    ${$bundleItem->getOrderDetailsItemDealerPrice()|number_format:1}
                {/if}			
            {/if}
        </div>
    </div>
{/foreach}