<div class="container_categories">
    {function name=drawCategory}{$category->getDisplayName()}
        {*if $category->getLastClickable()!=1*}
        <ul id="{$category->getId()}_categoryNode">
            {assign var="children" value=$ns.categoryManager->getChildren($category->getId())}
            {foreach $children as $child}
                <li id="{$child->getId()}_categoryNode">
                    {drawCategory category=$child} {if $child->getLastClickable()==1}*{/if}
                </li>
            {/foreach}
        </ul>
        {*/if*}
    {/function}


    <div id="categoriesContainer" >
        {drawCategory category=$ns.rootDto}
    </div>


    <div id="admin_categoy_details_container">

    </div>
</div>