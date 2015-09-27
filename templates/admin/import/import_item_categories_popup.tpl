{function name=drawCategory}{$category->getDisplayName()}
    {*if $category->getLastClickable()!=1*}
    <ul id="{$category->getId()}_categoryNode">
        {assign var="children" value=$ns.categoryManager->getChildren($category->getId())}
        {foreach $children as $child}
            <li id="{$child->getId()}_categoryNode">
                {drawCategory category=$child}
            </li>
        {/foreach}
    </ul>
    {*/if*}
{/function}

<a class="button blue" id="admin_item_categories_save_button" href="javascript:void(0);">save</a>
<div class="itemCategoriesContainer" id="itemCategoriesContainer">
    {drawCategory category=$ns.rootDto}
</div>
<div class="clear"></div>