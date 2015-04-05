<div id="mainLeftPanel"  class="left-panel">
    <div class="left-panel_content">
        {if isset($ns.itemsCategoryMenuView)}
            <h1 class="any_categories">
                <span class="glyphicon"></span>
                <span>
                    {$ns.lm->getPhrase(105)}
                </span>
            </h1>
            {$ns.itemsCategoryMenuView->display(false)}
        {/if}
        {if ($ns.properties_views && $ns.properties_views|@count>0)}
            {foreach from=$ns.properties_views item=property_view}
                {$property_view->display()}
            {/foreach}	
        {/if}
    </div>
</div>