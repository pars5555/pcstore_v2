<div class="main-search-wrapper">

    <!--========================== Product Container ===============================-->

    <div class="products-wrapper">

        <!--========================== Left Panel ===============================-->

        <div id="mainLeftPanel"  class="left-panel">
            <div class="left-panel_content">

                {if $ns.category_id > 0}
                    <a class="any_categories" href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>0, 'scpids'=>null])}"><span class="glyphicon"></span> <span>{$ns.lm->getPhrase(130)}</span></a>

                    {assign var="index" value=0}
                    {if isset($ns.category_path)}		
                        {foreach from=$ns.category_path item=parent_category_dto name=fi}			
                            {assign var="index" value=$smarty.foreach.fi.index}
                            <div class="product_test">
                                <a href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>$parent_category_dto->getId(), 'scpids'=>null])}" >{$parent_category_dto->getDisplayName()}</a>
                            </div>
                        {/foreach}
                    {/if}
                    {if $ns.category_id > 0}	
                        {assign var="index" value=$index+1}
                        <div class="product_categorie">
                            {$ns.category_dto->getDisplayName()}
                        </div>	
                    {/if}
                {/if}



                {if isset($ns.itemsCategoryMenuView)}
                    <h1 class="any_categories"><span class="glyphicon"></span><span>Categories</span></h1>
                    {$ns.itemsCategoryMenuView->display(false)}
                {/if}
                {if ($ns.properties_views && $ns.properties_views|@count>0)}
                    {foreach from=$ns.properties_views item=property_view}
                        {$property_view->display()}
                    {/foreach}	

                {/if}
            </div>
        </div>
        <div class="right-content">

                {include file="$TEMPLATE_DIR/main/banner_slider.tpl"} 

            <!--========================== Top Container ===============================-->
            <div class="table filter_conainer_box">
                <div class="table-cell">
                    <div class="filter_container">
                        <h3>Filter</h3> 
                        <div class="form-group">
                            <label for="sort_by">
                                Sort By:
                            </label>
                            <div class="select_wrapper">
                                <select id="sort_by">                                    
                                    {foreach from=$ns.sort_by_values item=value key=key}
                                        <option value="{$value}" {if $value==$ns.selected_sort_by_value}selected="selected"{/if}>{$ns.sort_by_display_names[$key]}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        {if ($ns.companiesIds|@count > 1)}          
                            <div class="form-group">                        
                                <label for="selected_company_id">{$ns.lm->getPhrase(66)}: </label>
                                <div class="select_wrapper">
                                    <select class="" id='selected_company_id'>
                                        {foreach from=$ns.companiesIds item=value key=key}
                                            {if ($key == 0)}
                                                <option value="{$value}" {if $ns.selectedCompanyId == 0}selected="selected"{/if} class="translatable_element" phrase_id="153">{$ns.companiesNames[$key]}</option>
                                            {else}
                                                <option value="{$value}" {if $ns.selectedCompanyId == $value}selected="selected"{/if} >{$ns.companiesNames[$key]}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                        {/if}               
                    </div>           
                </div>           

                <div class="table-cell">
                    {nest ns=paging}
                </div>           
            </div>


            <!-- ========================================= Product Wrapper =========================================== -->
            <div class="product-table">
                <div class="products_row">
                    <div class="product-wrapper"></div>
                    <div class="product-wrapper"></div>
                    <div class="product-wrapper"></div>
                </div>
                {assign var="count" value=1}	
                {if $ns.foundItems|@count>0}
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
                                    <a class="product-title" href="{$SITE_PATH}/item/{$item->getId()}">
                                        {$item->getDisplayName()}<p>{if !empty($brand)} by {$brand}{/if}</p>
                                    </a>
                                    <div class="product-img">
                                        <a class="product-img-link" href="{$SITE_PATH}/item/{$item->getId()}" style="background-image: url({$ns.itemManager->getItemImageURL($item->getId(), $item->getCategoriesIds(), '150_150', 1)});">
                                            {if $new_item == true}
                                                <div class="new_product"></div>
                                            {/if}
                                        </a>
                                    </div>
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
                                                            ({$item->getVatPriceAmd()|number_format} Դր.)
                                                        {else}
                                                            (${$item->getVatPrice()|number_format:1})
                                                        {/if}
                                                    {else}
                                                        {assign var="vat_price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($item->getCustomerVatItemPrice())}
                                                        ({$vat_price_in_amd|number_format} Դր.)
                                                    {/if}
                                                </span>
                                            </p>
                                        {/if}                                        
                                        {if $item->getIsDealerOfThisCompany()!=1}
                                            {math equation="100-x*100/y" x=$price_in_amd y=$item->getListPriceAmd() assign="list_price_discount"}
                                            <p>
                                                <span>{$ns.lm->getPhrase(589)}: </span>
                                                <span>{($item->getListPriceAmd()-$price_in_amd)|number_format} ({$list_price_discount|number_format}%)</span>
                                            </p>
                                        {/if}
                                        {if $item->getUpdatedDate() && $item->getUpdatedDate() != "0000-00-00 00:00:00"}
                                            <p>
                                                <span>{$ns.lm->getPhrase(453)}:</span>
                                                <span>{$item->getUpdatedDate()|date_format:"%d/%m/%Y"}</span></p>
                                            {/if}
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
                            {if $count==4}
                            </div>
                            {$count=1}

                        {/if}
                        {if $smarty.foreach.product_row.last && $count!=1}</div> {/if}
                    {/foreach}
            </div>
            {nest ns=paging}
        </div>
    {else}
        <div style="text-align: center">
            <h1>{$ns.lm->getPhrase(117)}</h1>
        </div>
    {/if}
</div>
</div>
