<div class="container">
    {assign var="tree_days_ago" value='-3 day'|strtotime}
    {assign var="tree_days_ago" value=$tree_days_ago|date_format:"%Y-%m-%d %H:%M:%S"}						
    {if isset($ns.item) && $ns.item->getCreatedDate()>$tree_days_ago}
        {assign var="new_item" value=true}			
    {else}
        {assign var="new_item" value=false}			
    {/if}
    {assign var="show_dealer_price" value=1}
    {if $ns.userLevel==$ns.userGroupsAdmin}
        {if $ns.admin_price_group != 'admin'}
            {assign var="show_dealer_price" value=0}
        {/if}
    {/if}

    {if $ns.item}
        <h2>{$ns.itemManager->getItemCategoriesPathToString($ns.item)}</h2>      
    {/if}
    <div class="container-fluid">
        <div class="col-md-5">
            <img src="{$ns.itemManager->getItemImageURL($ns.item->getId(),$ns.item->getCategoriesIds(), '400_400', 1)}" /> 
        </div>
        <div class="col-md-7">
            <h2>{$ns.item->getDisplayName()}{if $ns.item->getBrand()} by {$ns.item->getBrand()}{/if}</h2>
            {if $ns.item}
                <div class="current-product-price-list">
                    {if $new_item == true}
                        NEW ITEM!!!
                    {/if}

                    {if $ns.item->getWarranty()>0 || $ns.item->getWarranty()=='lifetime'}
                    <p>{$ns.lm->getPhrase(82)}:{$ns.item->getWarranty()} {if $ns.item->getWarranty()|lower!='lifetime'}{$ns.lm->getPhrase(183)}{/if}</p>
                    {/if}

                    {if $ns.item->getVatPrice()>0} 
                        {assign var = "showvatprice" value = "true"}
                    {/if}                

                    {if $ns.item->getIsDealerOfThisCompany()==1 && $show_dealer_price == 1}
                        {if $ns.item->getDealerPriceAmd()>0}
                            {$ns.item->getDealerPriceAmd()|number_format} Դր.
                        {else}
                            ${$ns.item->getDealerPrice()|number_format:1}
                        {/if}
                    {else}
                        {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($ns.item->getCustomerItemPrice())}                        
                        <p>List price: {$ns.item->getListPriceAmd()} Դր.</p>
                        <p>{$ns.lm->getPhrase(88)}:{$price_in_amd|number_format} Դր.</p>
                        <p>{math equation="100-x*100/y" x=$price_in_amd y=$ns.item->getListPriceAmd() assign="list_price_discount"}
                            you save: {$ns.item->getListPriceAmd()-$price_in_amd|number_format} ({$list_price_discount|number_format}%)</p>                        
                        {/if} 
                        {if isset($showvatprice)}
                        VAT price: 
                        {if $ns.item->getIsDealerOfThisCompany()==1 && $show_dealer_price == 1}
                            {if $ns.item->getVatPriceAmd()>0}
                                ({$ns.item->getVatPriceAmd()|number_format} Դր.)
                            {else}
                                (${$ns.item->getVatPrice()|number_format:1})
                            {/if}	
                        {else}
                            {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($ns.item->getCustomerVatItemPrice())}
                            ({$price_in_amd|number_format} Դր.)
                        {/if}	
                    {/if}
                    {if $ns.item->getIsDealerOfThisCompany()}
                        {$ns.lm->getPhrase(66)}:
                    {/if}
                </div>
                {if ($ns.userLevel!=$ns.userGroupsGuest)}
                    {if $smarty.now|date_format:"%Y-%m-%d">$ns.item->getItemAvailableTillDate()}
                        {if $ns.item->getIsCompanyOnline()}
                            {$ns.lm->getPhrase(86)}
                            <br/>{$ns.lm->getPhrase(526)} {$ns.lm->getCmsVar('pcstore_sales_phone_number')}
                        {else}
                            </br>{$ns.lm->getPhrase(525)}   {$ns.lm->getCmsVar('pcstore_sales_phone_number')}
                        {/if}
                    {else}
                        {$ns.lm->getPhrase(83)}
                        {if $new_item == true}
                            <br/>
                            {$ns.lm->getPhrase(559)}
                        {else}
                            {if $ns.item->getUpdatedDate() && $ns.item->getUpdatedDate() != "0000-00-00 00:00:00"}
                                <br/>
                                {$ns.lm->getPhrase(453)}: {$ns.item->getUpdatedDate()|date_format:"%d/%m/%Y"}
                            {/if}
                        {/if}
                    {/if}
                {/if}

                {if ($ns.userLevel!==$ns.userGroupsGuest)}
                    {if !($smarty.now|date_format:"%Y-%m-%d">$ns.item->getItemAvailableTillDate())}
                        {if $ns.userLevel==$ns.userGroupsUser && !$ns.item->getIsDealerOfThisCompany()}
                            {$ns.lm->getPhrase(284)}
                        {/if}
                    {/if}
                {else}
                    <a class="btn btn-default btn-primary center-block f_myModal_toggle" href="javascript:void(0);">{$ns.lm->getPhrase(85)}</a>
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


