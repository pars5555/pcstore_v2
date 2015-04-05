{*}
<div class="category_navigation">
<a class="cat_nav_elem" href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>0, 'scpids'=>null])}"><span>{$ns.lm->getPhrase(130)}</span></a>

{if isset($ns.category_path)}		
{foreach from=$ns.category_path item=parent_category_dto name=fi}			
{assign var="index" value=$smarty.foreach.fi.index}
<span class="glyphicon"></span>
<a  class="cat_nav_elem" href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>$parent_category_dto->getId(), 'scpids'=>null])}" >{$parent_category_dto->getDisplayName()}</a>
{/foreach}
{/if}
</div>
{*}

{if $ns.category_id > 0}	
    <div class="category_navigation">
        <a class="cat_nav_elem" href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>0, 'scpids'=>null])}">
            <span>{$ns.lm->getPhrase(130)}</span>
        </a>
        {if isset($ns.category_path)}       
            {foreach from=$ns.category_path item=parent_category_dto name=fi}			
                {assign var="index" value=$smarty.foreach.fi.index}
                <span class="glyphicon"></span>
                <a  class="cat_nav_elem" href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['cid'=>$parent_category_dto->getId(), 'scpids'=>null])}" >{$parent_category_dto->getDisplayName()}</a>
            {/foreach}
        {/if}
        <span class="glyphicon"></span>
        <span class="cat_nav_current">{$ns.category_dto->getDisplayName()}</span>
    </div>
{/if}