<div id="pcc_select_component_inner_container" component_index="{$ns.componentIndex}">
        {if $ns.itemsDtos|@count>0}
            {foreach from=$ns.itemsDtos item=item name=fi}		
                {include file="$TEMPLATE_DIR/main/pcc/pcc_item_view.tpl"}
            {/foreach}
        {else}
            <div style="text-align: center;padding: 30px">
                <h1>{$ns.lm->getPhrase(350)}</h1>
            </div>
        {/if}

  
</div>

{foreach from=$ns.allSelectedComponentsIdsArray item=selectedComponentIds name=cl}
    {if is_array($selectedComponentIds)}
        {assign var="selectedComponentIds" value=$selectedComponentIds|@implode:','}		
    {/if}
    <input id='selected_component_{$smarty.foreach.cl.index+1}' type="hidden" value="{$selectedComponentIds}"/>
{/foreach}

