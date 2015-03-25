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
            <h1 class="any_categories"><span class="glyphicon"></span><span>{$ns.lm->getPhrase(105)}</span></h1>
            {$ns.itemsCategoryMenuView->display(false)}
        {/if}
        {if ($ns.properties_views && $ns.properties_views|@count>0)}
            {foreach from=$ns.properties_views item=property_view}
                {$property_view->display()}
            {/foreach}	

        {/if}
    </div>
</div>