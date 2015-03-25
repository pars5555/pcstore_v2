<!-- ========================================= Product Wrapper =========================================== -->
<div class="product-table listing-{$ns.listing_cols}-col">
    {assign var="count" value=1}	
    <div class="products_row">
        {section name=listing_empty loop=$ns.listing_cols}
            <div class="product-wrapper"></div>
        {/section}
    </div>
    {assign var="tree_days_ago" value='-3 day'|strtotime}
    {assign var="tree_days_ago" value=$tree_days_ago|date_format:"%Y-%m-%d %H:%M:%S"}		
    {foreach from=$ns.foundItems item=item name=product_row}
        {assign var="brand" value=$item->getBrand()}
        {if $item->getCreatedDate()>$tree_days_ago}
            {assign var="new_item" value=true}			
        {else}
            {assign var="new_item" value=false}			
        {/if}
        {if $count==1}
            <div class="products_row">
            {/if}
            {$count=$count+1}

            <div class="product-wrapper">
                <div class="product_inner">
                    <a class="product-title" href="{$SITE_PATH}/item/{$item->getId()}" title="{$item->getDisplayName()} {if !empty($brand)} by {$brand}{/if}">
                        {$item->getDisplayName()} {if !empty($brand)}<span class="brand_name"> by {$brand}</span>{/if}
                    </a>
                    <div class="product-img" title="{$item->getDisplayName()} {if !empty($brand)} by {$brand}{/if}">
                        <a class="product-img-link" href="{$SITE_PATH}/item/{$item->getId()}" style="background-image: url({$ns.itemManager->getItemImageURL($item->getId(), $item->getCategoriesIds(), '150_150', 1)});">
                            {if $new_item == true}
                                <div class="new_product_listing"></div>
                            {/if}
                        </a>
                    </div>
                    <div class="product-price-container">
                        <div class="product-price">
                            {if $item->getIsDealerOfThisCompany()!=1}
                                <p><span>{$ns.lm->getPhrase(588)}:</span> <span>{$item->getListPriceAmd()|number_format} Դր.</span></p>
                            {/if}
                            <p class="price">
                                <span>{$ns.lm->getPhrase(88)}:</span>
                                <span>
                                    {if $item->getIsDealerOfThisCompany()==1}
                                        {if $item->getDealerPriceAmd()>0}
                                            {$item->getDealerPriceAmd()|number_format} Դր.
                                        {else}
                                            ${$item->getDealerPrice()|number_format:1}
                                        {/if}  
                                    {else}
                                        {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($item->getCustomerItemPrice())}
                                        {$price_in_amd|number_format} Դր.
                                    {/if}                                        
                                </span>
                            </p>
                            {if $item->getVatPrice()>0}
                                <p>
                                    <span>{$ns.lm->getPhrase(488)}:</span>
                                    <span>
                                        {if $item->getIsDealerOfThisCompany()==1}
                                            {if $item->getVatPriceAmd()>0}
                                                {$item->getVatPriceAmd()|number_format} Դր.
                                            {else}
                                                ${$item->getVatPrice()|number_format:1}
                                            {/if}
                                        {else}
                                            {assign var="vat_price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($item->getCustomerVatItemPrice())}
                                            {$vat_price_in_amd|number_format} Դր.
                                        {/if}
                                    </span>
                                </p>
                            {/if}                                        
                            {if $ns.userLevel === $ns.userGroupsAdmin}
                                <p>
                                    <span>Customer Price:</span>
                                    <span>
                                        {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($item->getCustomerItemPrice())}
                                        {$price_in_amd|number_format} Դր.
                                    </span>
                                </p>
                            {/if}                                        
                            {if $item->getIsDealerOfThisCompany()!=1}
                                {math equation="100-x*100/y" x=$price_in_amd y=$item->getListPriceAmd() assign="list_price_discount"}
                                {if $list_price_discount>0}
                                    <p>
                                        <span>{$ns.lm->getPhrase(589)}: </span>
                                        <span>{($item->getListPriceAmd()-$price_in_amd)|number_format} ({$list_price_discount|number_format}%)</span>
                                    </p>
                                {/if}
                            {/if}
                            {if $item->getUpdatedDate() && $item->getUpdatedDate() != "0000-00-00 00:00:00"}
                                <p>
                                    <span>{$ns.lm->getPhrase(453)}:</span>
                                    <span>{$item->getUpdatedDate()|date_format:"%d/%m/%Y"}</span>
                                </p>
                            {/if}
                            {if $item->getIsDealerOfThisCompany()==1}
                                <p title="{$ns.lm->getPhrase(271)}: {$item->getCompanyPhones()|replace:',':'&#13;&#10;'}">
                                    <span>{$ns.lm->getPhrase(66)}:</span>
                                    <span>{$item->getCompanyName()}</span>
                                </p>
                            {/if}
                        </div>
                    </div>
                    <div class="button-wrapper">
                        {if $ns.userLevel === $ns.userGroupsGuest}  
                            <a class="button blue f_myModal_toggle" href="javascript:void(0);">{$ns.lm->getPhrase(85)}</a>
                        {else}
                            {if !($smarty.now|date_format:"%Y-%m-%d">$item->getItemAvailableTillDate()) && $ns.userLevel==$ns.userGroupsUser && !$item->getIsDealerOfThisCompany()}
                                <a href="{$SITE_PATH}/dyn/user/do_add_to_cart?item_id={$item->getId()}" class="button blue" title="{$ns.lm->getPhrase(284)}">{$ns.lm->getPhrase(284)}</a>
                            {else}
                                {*}    <a href="javascript:void(0)" class="button grey not-allowed" title="{$ns.lm->getPhrase(19)}">{$ns.lm->getPhrase(19)}</a>                                                {*}
                            {/if}
                        {/if}
                    </div>
                </div>

            </div>
            {if $count== $ns.listing_cols+1}
            </div>
            {$count=1}

        {/if}
        {if $smarty.foreach.product_row.last && $count!=1} </div> {/if}
    {/foreach}
</div>