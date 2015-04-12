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
<div id="itemCategoriesContainer" style="margin-top: 40px;">
    {drawCategory category=$ns.rootDto}
</div>