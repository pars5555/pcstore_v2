<div class="row cart-item bundle-cart-item" id="cart_bundle_container^{$bundleItems.0->getId()}" >
    <div style="height:100%; background-color:#ccc;" class="col-md-1 col-same-height">
        <div class="cart_item_delete-wp text-center">
            <a  href="{$SITE_PATH}/dyn/main/do_delete_cart_item?id={$bundleItems.0->getId()}">
                <i class="glyphicon glyphicon-remove"></i>
            </a>
            <a href="{$SITE_PATH}/buildpc/{$bundleItems.0->getId()}">{$ns.lm->getPhrase(288)}...</a>		
        </div>
    </div>
    {math equation="1 - x/100" x=$bundleItems.0->getDiscount() assign="discountParam"}
    {foreach from=$bundleItems item=cartItem}
        {if $cartItem->getItemAvailable() == 0 && $cartItem->getSpecialFeeId() == 0}
            {assign var='someItemsMissing' value='true'}		 	
        {/if}
    {/foreach}
    <div class="col-md-6">
        <img src="{$ns.itemManager->getItemImageURL(0,0, '150_150', 1)}"/> 
        <div class="bundle">
            <a href="javascript:void(0)" class="f_bundle_btn btn btn-primary btn-default">See Components</a>
            <div class="f_bundle_wrapper bundle-components-wrapper">
                <ul class="f_current_bundle_slider current-bundle-list">
                    <li class="item current-bundle-comp">
                        <div id="cart_bundle_items_container_{$bundleItems.0->getId()}">
                            {assign var="bundle_items" value = "true"}
                            {foreach from=$bundleItems item=cartItem}	
                                {include file="$TEMPLATE_DIR/main/cart/cart_item.tpl" cartItem=$cartItem}
                            {/foreach}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div style="{if isset($someItemsMissing)}color:red;{/if}">
        {assign var="phrase_id" value = $bundleItems.0->getBundleDisplayNameId()}
        {$ns.lm->getPhrase($phrase_id)}
    </div>
    <div >
        {if !isset($someItemsMissing)}
            <select id="cart_item^{$bundleItems.0->getId()}">
                {section name=foo start=1 loop=21 step=1}
                    {assign var='index' value=$smarty.section.foo.index}
                    <option value="{$index}" {if $bundleItems.0->getCount() == $index}selected="selected"{/if}>{$index}</option>
                {/section}
            </select>
        {/if}
    </div>

    {assign var="bundlePrice" value=$ns.bundleItemsManager->calcBundlePriceForCustomerWithoutDiscount($bundleItems, $ns.userLevel)}

    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
        <div>
            {if !isset($someItemsMissing)}
                {if $bundlePrice.1 > 0}
                    ${$bundlePrice.1|number_format:1}
                {/if}
            {/if}
        </div>
    {/if}

    {assign var= "count" value =$bundleItems.0->getCount()}
    {assign var= "specialFee" value =$bundlePrice.2}
    {assign var="totUSD" value="`$count*$bundlePrice.1`"}
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
        <div>
            {if !isset($someItemsMissing)}
                {if $bundlePrice.1 > 0}
                    ${$totUSD|number_format:1}
                {/if}
            {/if}
        </div>
    {/if}
    {assign var="bundle_item_total_deal_discount_amd" value=$ns.checkoutManager->getBundleItemTotalDealsDiscountAMD($bundleItems)}

    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
        <div >
            {if !isset($someItemsMissing)}				 
                {if $bundlePrice.0+$specialFee > 0}				
                    <span style="{if $discountParam != 1 || $bundle_item_total_deal_discount_amd>0}text-decoration: line-through{/if}">
                        {$bundlePrice.0+$specialFee|number_format:0} Դր.
                    </span>
                    {if $discountParam != 1}
                        <br/>
                        <span style="{if $bundle_item_total_deal_discount_amd>0}text-decoration: line-through{/if}">
                            {$bundlePrice.0*$discountParam+$specialFee|number_format:0} Դր.
                        </span>
                    {/if}
                    {if $bundle_item_total_deal_discount_amd>0}
                        <br/>
                        <span>
                            {$bundlePrice.0*$discountParam+$specialFee-$bundle_item_total_deal_discount_amd|number_format:0} Դր.							
                        </span>
                    {/if}
                {/if}
            {/if}
        </div>
    {/if}

    {math equation="count*(price*discount+specFee)" discount=$discountParam count=$count price=$bundlePrice.0 specFee=$specialFee assign="totAMDWithDiscount"}
    {math equation="count*(price+specFee)" discount=$discountParam count=$count price=$bundlePrice.0 specFee=$specialFee assign="totAMDWithoutDiscount"}
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
        <div>
            {if !isset($someItemsMissing)}
                {if $bundlePrice.0+$specialFee > 0}
                    <span style="{if $discountParam != 1 || $bundle_item_total_deal_discount_amd>0}text-decoration: line-through{/if}">
                        {$totAMDWithoutDiscount|number_format:0} Դր.
                    </span>
                    {if $discountParam != 1}
                        <br/>
                        <span style="{if $bundle_item_total_deal_discount_amd>0}text-decoration: line-through{/if}">
                            {$totAMDWithDiscount|number_format:0} Դր.
                        </span>
                    {/if}
                    {if $bundle_item_total_deal_discount_amd>0}
                        <br/>
                        <span>
                            {$totAMDWithDiscount-$count*$bundle_item_total_deal_discount_amd|number_format:0} Դր.
                        </span>

                    {/if}
                {/if}
            {/if}
        </div>
    {/if}
    {if !isset($someItemsMissing)}
        <div>
            {if $bundleItems.0->getDiscount() > 0}
                {$bundleItems.0->getDiscount()}%
                <br/>
            {/if}
            {if $bundle_item_total_deal_discount_amd>0}
                {$count} x {$bundle_item_total_deal_discount_amd|number_format:0} Դր.
            {/if}
        </div>
    {/if}
</div>


