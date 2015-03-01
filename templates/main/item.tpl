<div class="container current_product_container">
    {if isset($ns.item)}
        {assign var="tree_days_ago" value='-3 day'|strtotime}
        {assign var="tree_days_ago" value=$tree_days_ago|date_format:"%Y-%m-%d %H:%M:%S"}						
        {if isset($ns.item) && $ns.item->getCreatedDate()>$tree_days_ago}
            {assign var="new_item" value=true}			
        {else}
            {assign var="new_item" value=false}			
        {/if}    
        <h1 class="main_title">{$ns.itemManager->getItemCategoriesPathToString($ns.item)}</h1>      
        <div class="product-wrapper current_product_wp">
            <div class="product-img">
                <img src="{$ns.itemManager->getItemImageURL($ns.item->getId(),$ns.item->getCategoriesIds(), '400_400', 1)}" /> 
            </div>
            <div class="product-info">
                <h2>{$ns.item->getDisplayName()}{if $ns.item->getBrand()} by {$ns.item->getBrand()}{/if}</h2>
                <div class="product-price">

                    {if $ns.item->getVatPrice()>0} 
                        {assign var = "showvatprice" value = "true"}
                    {/if}                

                    {if $ns.item->getIsDealerOfThisCompany()==1}
                        {if $ns.item->getDealerPriceAmd()>0}
                            <span>{$ns.item->getDealerPriceAmd()|number_format} Դր.</span>
                        {else}
                            <span>${$ns.item->getDealerPrice()|number_format:1}</span>
                        {/if}
                    {else}
                        {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($ns.item->getCustomerItemPrice())}                        
                        <p><span>List price:</span> <span>{$ns.item->getListPriceAmd()} Դր.</span></p>
                        <p class="price"><span>{$ns.lm->getPhrase(88)}:</span> <span>{$price_in_amd|number_format} Դր.</span></p>
                        <p>{math equation="100-x*100/y" x=$price_in_amd y=$ns.item->getListPriceAmd() assign="list_price_discount"}
                            <span>you save:</span> <span>{$ns.item->getListPriceAmd()-$price_in_amd|number_format} ({$list_price_discount|number_format}%)</span></p>                        
                        {/if} 
                        {if isset($showvatprice)}
                        <p>
                            <span>VAT price:</span>
                            {if $ns.item->getIsDealerOfThisCompany()==1}
                                {if $ns.item->getVatPriceAmd()>0}
                                    <span>({$ns.item->getVatPriceAmd()|number_format} Դր.)</span>
                                {else}
                                    <span>(${$ns.item->getVatPrice()|number_format:1})</span>
                                {/if}	
                            {else}
                                {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($ns.item->getCustomerVatItemPrice())}
                                <span>({$price_in_amd|number_format} Դր.)</span>
                            {/if}	
                        </p> 
                    {/if}
                    {if $ns.item->getIsDealerOfThisCompany()}
                        <span>{$ns.lm->getPhrase(66)}:</span>
                        <span title="{$ns.lm->getPhrase(271)}: {$ns.item->getCompanyPhones()|replace:',':'&#13;&#10;'}" style="font-size: 14px; {if ($ns.item->getIsCompanyOnline())}color:green;{/if}"
                              >{$ns.item->getCompanyName()}</span>
                    {/if}
                </div>
                <div class="product_other_info">
                    {if $new_item == true}
                        <div> NEW ITEM!!!</div>
                    {/if}

                    {if $ns.item->getWarranty()>0 || $ns.item->getWarranty()=='lifetime'}
                        <span>{$ns.lm->getPhrase(82)}:{$ns.item->getWarranty()} {if $ns.item->getWarranty()|lower!='lifetime'}{$ns.lm->getPhrase(183)}{/if}</span>
                    {/if}

                    {if ($ns.userLevel!=$ns.userGroupsGuest)}
                        {if $smarty.now|date_format:"%Y-%m-%d">$ns.item->getItemAvailableTillDate()}
                            {if $ns.item->getIsCompanyOnline()}
                                <p>{$ns.lm->getPhrase(86)}</p>
                                <p>$ns.lm->getPhrase(526)} {$ns.lm->getCmsVar('pcstore_sales_phone_number')}</p>
                            {else}
                                <p>{$ns.lm->getPhrase(525)}   {$ns.lm->getCmsVar('pcstore_sales_phone_number')}</p>
                            {/if}
                        {else}
                            <p>{$ns.lm->getPhrase(83)}</p>
                            {if $new_item == true}
                                <p>{$ns.lm->getPhrase(559)}</p>
                            {else}
                                {if $ns.item->getUpdatedDate() && $ns.item->getUpdatedDate() != "0000-00-00 00:00:00"}
                                    <p>{$ns.lm->getPhrase(453)}: {$ns.item->getUpdatedDate()|date_format:"%d/%m/%Y"}</p>
                                {/if}
                            {/if}
                        {/if}
                    {/if}
                </div>
                {if ($ns.userLevel!==$ns.userGroupsGuest)}
                    {if !($smarty.now|date_format:"%Y-%m-%d">$ns.item->getItemAvailableTillDate())}
                        {if $ns.userLevel==$ns.userGroupsUser && !$ns.item->getIsDealerOfThisCompany()}
                            <a href="{$SITE_PATH}/dyn/user/do_add_to_cart?item_id={$item->getId()}" class="button blue" title="{$ns.lm->getPhrase(284)}">{$ns.lm->getPhrase(284)}</a>
                        {/if}
                    {/if}
                {else}
                    <a class="button blue f_myModal_toggle" href="javascript:void(0);">{$ns.lm->getPhrase(85)}</a>
                {/if}
            </div>
        </div>
        <div class="current-product-description container-fluid">
            {assign var="short" value=$ns.item->getShortDescription()}
            {assign var="full" value=$ns.item->getFullDescription()}
            {if !empty($short) || !empty($full)}
                <h2>Product Description</h2>
                {$short|default:""}
                {$full|default:""}
            {/if}
        </div>
    {/if}
</div>


