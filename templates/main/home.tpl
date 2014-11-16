<div class="main-search-wrapper">
	
	<!--========================== Top Container ===============================-->
	    
    <div  class="main-top-container container">
        	<div class="search_block">
            <div class="search_container">
                    <form role="search" action="{$SITE_PATH}" id="search_text_form" autocomplete="off" method="get" >
                        <input type="text" id="srch-term" name="st" placeholder="{$ns.lm->getPhrase(91)}" class="search_text" value="{$ns.req.st|default:''}">
                            <button type="submit" class="search_btn"></button>
                        {if isset($ns.req.cid)}
                            <input type="hidden" name="cid" value="{$ns.req.cid}"/>
                        {/if}
                        <input type="hidden" name="s" value="{$ns.selected_sort_by_value}"/>
                        
                    </form>
                    <div class="clear"></div>
                    </div>
            </div>
            <div class="filter_container">
                <h3>Filter</h3> 
                <div class="col-sm-4 col-md-4">
                    <div class="from-group">
                        <label>
                            Sort By Price
                        </label>
                        {foreach from=$ns.sort_by_values item=value key=key}
                            </br>
                            <a href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['s'=>$value])}" 
                               {if $ns.selected_sort_by_value == $value}style="color:red"{/if}>{$ns.sort_by_display_names[$key]}</a>
                        {/foreach}
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        {if ($ns.companiesIds|@count > 1)}
                            <label for="selected_company_id">{$ns.lm->getPhrase(66)}: </label>
                        {/if}
                        <select class="form-control" name='sci' id='selected_company_id'  style="{if !($ns.companiesIds|@count > 1)}display:none;{/if}">
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
                <div class="col-sm-4 col-md-4">
                    {*} <div class="avo_style_price_range_block">
                       
                    <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                    <label for="search_item_price_range_min" >{$ns.lm->getPhrase(88)}: </label>
                    <input id="search_item_price_range_min" class="form-control" name="mip" type="text" value="{$ns.req.mip|default:''}" autocomplete="off"/>
                    </div>
                    </div>
                   
                    <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                    <label style="display:block;" for="search_item_price_range_max"> {$ns.lm->getPhrase(185)}</label>
                    <input style="display:inline-block; width:70%;" class="form-control" id="search_item_price_range_max" name="map" type="text" value="{$ns.req.map|default:''}" autocomplete="off"/>
                    <span> Դր.</span>
                    </div>
                    </div>
                    </div> {*}
                </div>
            </div>       

            {nest ns=paging}
            <div class="clear"></div>
    </div>
	

	
	<!--========================== Product Container ===============================-->
	   
    <div class="products-wrapper">
    	
    		<!--========================== Left Panel ===============================-->
	
    <div id="mainLeftPanel"  class="main-page-left-panel">

        {if $ns.category_id > 0}
            <a href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>0, 'scpids'=>null])}">{$ns.lm->getPhrase(130)}</a>

            {assign var="index" value=0}
            {if isset($ns.category_path)}		
                {foreach from=$ns.category_path item=parent_category_dto name=fi}			
                    {assign var="index" value=$smarty.foreach.fi.index}
                    <div style="margin: 5px 0 5px {$index*15+30}px" >
                        <a href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>$parent_category_dto->getId(), 'scpids'=>null])}" >{$parent_category_dto->getDisplayName()}</a>
                    </div>
                {/foreach}
            {/if}
            {if $ns.category_id > 0}	
                {assign var="index" value=$index+1}
                <div style="padding-left: {$index*15+30}px;" >
                    {$ns.category_dto->getDisplayName()}
                </div>	
            {/if}
        {/if}



        {if isset($ns.itemsCategoryMenuView)}
            {$ns.itemsCategoryMenuView->display(false)}
        {/if}
        {if ($ns.properties_views && $ns.properties_views|@count>0)}

            {foreach from=$ns.properties_views item=property_view}
                {$property_view->display()}
            {/foreach}	

        {/if}
        {*}<div id="leftSideProductCategories" class="panel panel-default closed">
        <!-- Default panel contents -->
        <div class="panel-heading">Categories</div>
        <!-- List group -->
        <ul class="list-group">
        <li class="list-group-item">
        <div class="f_left_side_sub_menu is-sub-menu">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </div>
        <ul class="f_left_side_sub_menu leftPanel-sub-menu list-group">
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        <li class="list-group-item">
        <div class="f_left_side_sub_menu is-sub-menu product-category">
        Morbi leo risus
        <span class="badge pull-right">14</span>
        </div>
        <ul class="f_left_side_sub_menu leftPanel-sub-menu list-group">
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        </ul>
        </li>
        </ul>
        </li>
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        <li class="list-group-item">
        <div class="product-category">
        aaa
        <span class="badge pull-right">14</span>
        </div>
        </li>
        </ul>
        </div>
        {*}
    </div>
    	
            {assign var="count" value=1}	
        {if $ns.foundItems|@count>0}
            {assign var="tree_days_ago" value='-3 day'|strtotime}
            {assign var="tree_days_ago" value=$tree_days_ago|date_format:"%Y-%m-%d %H:%M:%S"}				
            {foreach from=$ns.foundItems item=item name=fi}
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
                            <a class="" href="{$SITE_PATH}/item/{$item->getId()}"><h4 class="product-title">{$item->getDisplayName()}<span>{if !empty($brand)} by {$brand}{/if}</span> </h4></a>
                            <div class="product-img" style="background-image:url('')">
                                <img src="{$ns.itemManager->getItemImageURL($item->getId(), $item->getCategoriesIds(), '150_150', 1)}" />
                                {if $new_item == true}
                                    NEW ITEM!!!
                                {/if}
                            </div>
                            <div class="product-price">
                                {if $item->getIsDealerOfThisCompany()!=1}
                                    <p>{$ns.lm->getPhrase(588)}: <span>{$item->getListPriceAmd()|number_format} Դր.</span></p>
                                {/if}
                                <p>{$ns.lm->getPhrase(88)}: <span>
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
                                    <p>{$ns.lm->getPhrase(488)}: <span>
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
                                    <p>{$ns.lm->getPhrase(589)}: 
                                        <span>{($item->getListPriceAmd()-$price_in_amd)|number_format} ({$list_price_discount|number_format}%)</span>
                                    </p>
                                {/if}
                                {if $item->getUpdatedDate() && $item->getUpdatedDate() != "0000-00-00 00:00:00"}
                                    <p>{$ns.lm->getPhrase(453)}:<span>{$item->getUpdatedDate()|date_format:"%d/%m/%Y"}</span></p>
                                {/if}
                            </div>
                        <div class="button-wrapper">
                            {if $ns.userLevel === $ns.userGroupsGuest}  
                                <a data-toggle="modal" data-target="#myModal" href="#" class='btn btn-default btn-primary pull-right'>{$ns.lm->getPhrase(85)}</a>
                            {else}
                                {if !($smarty.now|date_format:"%Y-%m-%d">$item->getItemAvailableTillDate())}			
                                    {if $ns.userLevel==$ns.userGroupsUser && !$item->getIsDealerOfThisCompany()}
                                        <a href="{$SITE_PATH}/dyn/user/do_add_to_cart?item_id={$item->getId()}" class="btn btn-default btn-primary pull-right" title="{$ns.lm->getPhrase(284)}">{$ns.lm->getPhrase(284)}</a>
                                    {/if}
                                {/if}
                            {/if}
                        </div>
                    </div>

               </div>
                {if $count==4}
                </div>
                {$count=1}
                {/if}
				{if $smarty.foreach.fi.last} </div> {/if}
            {/foreach}
            {nest ns=paging}
        {else}
            <div style="text-align: center">
                <h1>{$ns.lm->getPhrase(117)}</h1>
            </div>
        {/if}
    </div>
    <div class="clear"></div>
</div>
