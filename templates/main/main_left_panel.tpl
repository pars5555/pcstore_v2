<div id="mainLeftPanel"  class="left-panel left_categories_panel f_side_panel" data-side-panel="categories-panel" data-side-position="left">
    <div class="left-panel_content">
        {if isset($ns.itemsCategoryMenuView)}
            <h1 class="any_categories">
                <span class="fontAwesome"></span>
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