<div class="row cart-item" style="{if $ns.include_vat==1 && $cartItem->getCustomerVatItemPrice()==0 && $cartItem->getItemId()>0}color:red{/if}">
    {if !isset($bundle_items)}
        <div style="height:100%; background-color:#ccc;" class="col-md-1 col-same-height">
            <div class="cart_item_delete-wp text-center">
                <a  href="{$SITE_PATH}/dyn/main/do_delete_cart_item?id={$cartItem->getId()}">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </div>
        </div>
    {/if}
    <div class="col-md-11 col-same-height">
        {math equation="1 - x/100" x=$cartItem->getDiscount() assign="discountParam"}
        <div class="col-md-4">			
            {if $cartItem->getItemAvailable() == 1}
                {if isset($bundle_items)}
                    {assign var="itemId" value=$cartItem->getBundleItemId()}				
                {else}
                    {assign var="itemId" value=$cartItem->getItemId()}																												 
                {/if}
                {if !isset($bundle_items)}
                    <img src="{$ns.itemManager->getItemImageURL($itemId,$cartItem->getItemCategoriesIds(), '150_150', 1 , true)}"/>
                {else}
                    <img src="{$ns.itemManager->getItemImageURL($itemId,$cartItem->getItemCategoriesIds(), '60_60', 1 , true)}"/>
                {/if}
            {/if}
        </div>
        <div class="col-md-4"  style="{if $cartItem->getItemAvailable() == 0 && $cartItem->getSpecialFeeId() == 0}color:red;{/if}">
            {if $cartItem->getSpecialFeeId() > 0}
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
            {/if}
        </div>
        <div>
            {if $cartItem->getItemAvailable() == 1}
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
            {/if}			
        </div>




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


            {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
                <div>
                    {if $cartItem->getItemAvailable() == 1}
                        {if $showDealerPrice == 1}
                            ${$price|number_format:1}
                        {/if}			
                    {/if}
                </div>		
            {/if}


            {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
                <div>
                    {if $cartItem->getItemAvailable() == 1}
                        {if $showDealerPrice == 1}			
                            ${$totP|number_format:1}
                        {/if}			
                    {/if}
                </div>		
            {/if}

        {/if}	

        {* printing item price *}

        {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}	
            <div>
                {if $cartItem->getSpecialFeeId() > 0}
                    <span>
                        {$price|number_format:0} Դր.
                    </span>
                {else}
                    {if $cartItem->getItemAvailable() == 1}
                        {if $showDealerPrice == 0}
                            {assign var="itemAmdPrice" value=$ns.itemManager->exchangeFromUsdToAMD($price)}
                            <span style="{if $discountParam != 1 || $cartItem->getDealDiscountAmd()>0}text-decoration: line-through{/if}">
                                {$itemAmdPrice|number_format:0} Դր.
                            </span>
                            {if $discountParam != 1 && $cartItem->getDealDiscountAmd()<=0}
                                <br/>
                                <span>
                                    {$itemAmdPrice*$discountParam|number_format:0} Դր.
                                </span>
                            {/if}
                            {if $cartItem->getDealDiscountAmd()>0}
                                <br/>
                                <span>
                                    {$itemAmdPrice-$cartItem->getDealDiscountAmd()|number_format:0} Դր.
                                </span>

                            {/if}
                        {/if}
                    {/if}
                {/if}			
            </div>			
        {/if}



        {* printing item total price *}
        {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
            <div>	
                {if $cartItem->getSpecialFeeId() > 0}
                    <span>
                        {$price|number_format:0} Դր.
                    </span>
                {else}
                    {if $cartItem->getItemAvailable() == 1}
                        {if  $showDealerPrice == 0}
                            {assign var="totPrAMD" value=$ns.itemManager->exchangeFromUsdToAMD($totP)}
                            <span  style="{if $discountParam != 1 || $cartItem->getDealDiscountAmd()>0}text-decoration: line-through{/if}">
                                {$totPrAMD|number_format:0} Դր.
                            </span>
                            {if $discountParam != 1 && $cartItem->getDealDiscountAmd()<=0}
                                <br/>
                                <span>
                                    {$totPrAMD*$discountParam|number_format:0} Դր.
                                </span>
                            {/if}
                            {if $cartItem->getDealDiscountAmd()>0}
                                <br/>
                                <span>
                                    {$totPrAMD-$count*$cartItem->getDealDiscountAmd()|number_format:0} Դր.
                                </span>

                            {/if}
                        {/if}			
                    {/if}
                {/if}
            </div>		
        {/if}
        {if $cartItem->getDealDiscountAmd()>0}
            {assign var="deal_discount_applied" value=true}
        {/if}
        {if 0<$cartItem->getDiscount() && isset($showDealerPrice) && $showDealerPrice==0 && $cartItem->getSpecialFeeId()==0 && $cartItem->getItemAvailable()==1}
            {assign var="discount_available" value=true}
        {else}
            {assign var="discount_available" value=false}
        {/if}

        {if isset($deal_discount_applied) || $discount_available}
            <div>
                {if $discount_available && $cartItem->getDealDiscountAmd()<=0}
                    {$cartItem->getDiscount()}%				
                {/if}
                {if isset($deal_discount_applied)}	
                    <br/>
                    {$count} x {$cartItem->getDealDiscountAmd()|number_format:0} Դր.
                {/if}
            </div>
        {/if}
    </div>
</div>