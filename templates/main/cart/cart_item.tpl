<div class="component_block" style="{if $ns.customer->getCartIncludedVat()==1 && $cartItem->getCustomerVatItemPrice()==0 && $cartItem->getItemId()>0}color:red{/if}">
    <!-- ===============================Component Block================================= -->
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
                <img src="{$ns.itemManager->getItemImageURL($itemId,$cartItem->getItemCategoriesIds(), '60_60', 1 , true)}"/>
            {/if}
        {/if}
        {if $cartItem->getSpecialFeeId() > 0}
            <span class="glyphicon build_pcc_fee"></span>
        {/if}
        {if $cartItem->getItemAvailable() == 0 && $cartItem->getSpecialFeeId() == 0}        
            <img class="not_avaible_img" src="{$SITE_PATH}/img/not_available.png"/>
        {/if}
    </div>

    <!-- ==============Component Information============== -->

    <div class="component_info"  style="{if $cartItem->getItemAvailable() == 0 && $cartItem->getSpecialFeeId() == 0}color:red;{/if}">
        <span> {if $cartItem->getSpecialFeeId() > 0}
            {assign var="spec_fee_desc_id" value = $cartItem->getSpecialFeeDescriptionTextId()}
            <span class="text_blue bold">{$ns.lm->getPhrase($spec_fee_desc_id)}</span>
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
                    <div class="component_count">
                        <span>{$cartItem->getBundleItemCount()}x</span>
                    </div>
                {else}
                    <div class="cart_item_count">
                        <div class="select_wrapper">
                            <select {if isset($bundle_items)}disabled="true"{/if} class="cart_item_count">
                                {section name=foo start=1 loop=$ns.maxItemCartCount+1 step=1}
                                    {assign var='index' value=$smarty.section.foo.index}
                                    {if isset($bundle_items)}
                                        {assign var='count' value=$cartItem->getBundleItemCount()}
                                    {else}
                                        {assign var='count' value=$cartItem->getCount()}
                                    {/if}
                                    <option  location_url="{$SITE_PATH}/dyn/main/do_set_cart_item_count?id={$cartItem->getId()}&count={$index}" value="{$index}" {if $count == $index}selected="selected"{/if}>{$index}</option>
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
                    {if $ns.customer->getCartIncludedVat() == 1 && $cartItem->getItemId()>0}
                        {assign var="price" value=$cartItem->getItemVatPrice()}
                    {else}
                        {assign var="price" value=$cartItem->getItemDealerPrice()}
                    {/if}
                {else}
                    {assign var="showDealerPrice" value=0}
                    {if $ns.customer->getCartIncludedVat() == 1 && $cartItem->getItemId()>0}
                        {assign var="price" value=$cartItem->getCustomerVatItemPrice()}
                    {else}
                        {assign var="price" value=$cartItem->getCustomerItemPrice()}
                    {/if}
                {/if}

                {assign var="totP" value="`$count*$price`"}

            {/if}

            <!-- ==============Component Unit price AMD============== -->

            {* printing item price *}

            <div class="component_unit_prie">
                {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
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
                {/if}
            </div>

            <!-- ==============Component Unit Price AMD============== -->

            {* printing item total price *}
            <div class="component_total_price">
                {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
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
                {/if}
            </div>

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

            <div class="component_discount">
                {if isset($deal_discount_applied) || $discount_available}
                    {if $discount_available && $cartItem->getDealDiscountAmd()<=0}
                        <span class="discount">{$ns.lm->getPhrase(285)} {$cartItem->getDiscount()}%</span>
                    {/if}
                    {if isset($deal_discount_applied)}
                        <br/>
                        <span class="price">{$count} x {$cartItem->getDealDiscountAmd()|number_format:0} Դր.</span>
                    {/if}
                {/if}
            </div>
            <!-- ==============Component Delete============== -->

            <div class="component_edit">
                
            </div>
            <div class="component_delete">
                {if !isset($bundle_items)}
                    <a  href="{$SITE_PATH}/dyn/main/do_delete_cart_item?id={$cartItem->getId()}"> <span class="item-delete glyphicon"></span> </a>
                {/if}
            </div>
        </div>