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
        <div class="product-wrapper">
            <div class="product-img">
                <div class="product-img-inner">
                    <div class="product-img-link-wrapper">
                        <div class="product-img-link f_product_img" style="background-image: url({$ns.itemManager->getItemImageURL($ns.item->getId(),$ns.item->getCategoriesIds(), '800_800', 1)});">

                        </div>
                    </div>

                    <div id="product-other-images" class="product-other-images">
                        {section name=images_counter start=1 loop=$ns.itemPicturesCount+1 step=1}
                            <div class="poi_item f_poi_item {if $smarty.section.images_counter.index==1}active{/if}" style="background-image:url({$ns.itemManager->getItemImageURL($ns.item->getId(),$ns.item->getCategoriesIds(), '800_800', $smarty.section.images_counter.index)})">
                            </div>
                        {/section}
                        <div class="clear"></div>
                    </div>

                    <div class="zoom_img_container" id="zoom-img">
                        <div class="zoom_img f_zoom_img" style="background-image: url({$ns.itemManager->getItemImageURL($ns.item->getId(),$ns.item->getCategoriesIds(), '800_800', 1)});">
                        </div>
                    </div>

                </div>
            </div>

            <div class="product-info">
                <h2 class="product-title" title="{$item->getDisplayName()} {if !empty($brand)} by {$brand}{/if}">
                    {$item->getDisplayName()} {if $ns.item->getBrand()}<span class="product_brand"> by {$ns.item->getBrand()}</span>{/if}
                </h2>
                <div class="product-info-inner">
                    <div class="product-price">

                        {if $ns.item->getVatPrice()>0} 
                            {assign var = "showvatprice" value = "true"}
                        {/if}                

                        {if $ns.item->getIsDealerOfThisCompany()==1}
                            <p class="price">
                                <span>{$ns.lm->getPhrase(88)}:</span>
                                {if $ns.item->getDealerPriceAmd()>0}
                                    <span>{$ns.item->getDealerPriceAmd()|number_format} Դր.</span>
                                {else}
                                    <span>${$ns.item->getDealerPrice()|number_format:1}</span>
                                {/if}
                            </p> 
                        {else}
                            {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($ns.item->getCustomerItemPrice())}                        
                            <p><span>{$ns.lm->getPhrase(588)}:</span> <span>{$ns.item->getListPriceAmd()|number_format} Դր.</span></p>
                            <p class="price"><span>{$ns.lm->getPhrase(88)}:</span> <span>{$price_in_amd|number_format} Դր.</span></p>
                            <p>{math equation="100-x*100/y" x=$price_in_amd y=$ns.item->getListPriceAmd() assign="list_price_discount"}
                                <span>{$ns.lm->getPhrase(589)}:</span> <span>{($ns.item->getListPriceAmd()-$price_in_amd)|number_format} ({$list_price_discount|number_format}%)</span></p>                        
                            {/if} 
                            {if isset($showvatprice)}
                            <p>
                                <span>{$ns.lm->getPhrase(488)}:</span>
                                <span>
                                    {if $ns.item->getIsDealerOfThisCompany()==1}
                                        {if $ns.item->getVatPriceAmd()>0}
                                            {$ns.item->getVatPriceAmd()|number_format} Դր.
                                        {else}
                                            ${$ns.item->getVatPrice()|number_format:1}
                                        {/if}	
                                    {else}
                                        {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($ns.item->getCustomerVatItemPrice())}
                                        {$price_in_amd|number_format} Դր.
                                    {/if}
                                </span>
                            </p> 
                        {/if}
                        {if $ns.item->getIsDealerOfThisCompany()}
                            <p>
                                <span>{$ns.lm->getPhrase(66)}:</span>
                                <span title="{$ns.lm->getPhrase(271)}: {$ns.item->getCompanyPhones()|replace:',':'&#13;&#10;'}" style="font-size: 14px; {if ($ns.item->getIsCompanyOnline())}color:green;{/if}">
                                    {$ns.item->getCompanyName()}
                                </span>
                            </p> 
                        {/if}
                    </div>
                    <div class="product_new_warranty_wp">
                        {if $ns.item->getWarranty()>0 || $ns.item->getWarranty()=='lifetime'}
                            <div class="product_warranty">
                                <div class="product_warranty_text">
                                    {*                                    {$ns.lm->getPhrase(82)}*}
                                    <div class="warranty_month_count">{$ns.item->getWarranty()}</div> 
                                    <div>{if $ns.item->getWarranty()|lower!='lifetime'}{$ns.lm->getPhrase(183)}{/if}</div>  
                                </div>
                            </div>
                        {/if}
                        {if $new_item == true}
                            <div class="new_product"></div>
                        {/if}
                        <div class="product_other_info">
                            {if ($ns.userLevel!=$ns.userGroupsGuest)}
                                {if $smarty.now|date_format:"%Y-%m-%d">$ns.item->getItemAvailableTillDate()}
                                    {if $ns.item->getIsCompanyOnline()}
                                        <p>{$ns.lm->getPhrase(86)}</p>
                                        <p>{$ns.lm->getPhrase(526)} {$ns.lm->getCmsVar('pcstore_sales_phone_number')}</p>
                                    {else}
                                        <p>{$ns.lm->getPhrase(525)}   {$ns.lm->getCmsVar('pcstore_sales_phone_number')}</p>
                                    {/if}
                                {else}
                                    {*}
                                    <p>{$ns.lm->getPhrase(83)}</p>
                                    {if $new_item == true}
                                    <p>{$ns.lm->getPhrase(559)}</p>
                                    {else}
                                    {if $ns.item->getUpdatedDate() && $ns.item->getUpdatedDate() != "0000-00-00 00:00:00"}
                                    <p>{$ns.lm->getPhrase(453)}: {$ns.item->getUpdatedDate()|date_format:"%d/%m/%Y"}</p>
                                    {/if}
                                    {/if}
                                    {*}
                                {/if}
                            {/if}
                        </div>
                    </div>

                    {if !empty($ns.itemPropertiesHierarchy)}
                        <div class="product_spec">	
                            <h1 class="title">{$ns.lm->getPhrase(100)}</h1>
                            <div class="table">
                                {foreach from=$ns.itemPropertiesHierarchy key= k item=sp}
                                    <div class="table-row">
                                        <span class="table-cell product_spec_title">{$k} :</span>
                                        <span class="table-cell product_spec_value">{', '|implode:$sp}</span>
                                    </div>
                                {/foreach}	
                            </div>
                        </div>
                    {/if}

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
        </div>
    </div>
    <div class="clear"></div>
    <div class="current-product-description container-fluid">
        {assign var="short" value=$ns.item->getShortDescription()}
        {assign var="full" value=$ns.item->getFullDescription()}
        {if !empty($short) || !empty($full)}
            <h2 class="title">{$ns.lm->getPhrase(103)}</h2>
            {$short|default:""}
            {$full|default:""}
        {/if}
    </div>
{else}
<h1>{$ns.lm->getPhrase(300)}</h1>
{/if}
</div>

