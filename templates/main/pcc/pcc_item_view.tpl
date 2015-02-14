{if (isset($ns.selected_component_id) && $ns.selected_component_id == $item->getId()) || (isset($ns.selected_components_ids_array) && in_array($item->getId(), $ns.selected_components_ids_array))}
    {assign var="item_is_selected" value=true}
{/if}
{assign var = "selected_component_count" value =1}
{if (isset($ns.multi_count_selection_item))}
    {assign var = "max_count" value = $ns.componentLoad->getComponentMaxPossibleCount($item)}
    {assign var = "selected_component_count" value = $ns.componentLoad->getSelectedItemCount($item)}

    {if $max_count == $selected_component_count}
        {assign var = "component_limit_over" value=true}
    {/if}
{/if}

{if ($item->getPccItemCompatible()== 0)}
    {assign var="error_message"  value=$ns.pcmm->getItemAllNotCompatibleReasonsMessages($item, $ns.componentIndex)}
{/if}

{*if ($item->getPccItemCompatible()==1)}#EEFFEE{else}#FFBBBB{/if*}
<div class="{if isset($ns.multi_count_selection_item) && isset($ns.selected_components_ids_array) && in_array($item->getId(), $ns.selected_components_ids_array)}select_count{/if} {if isset($item_is_selected)}checked_component{/if}">
	
    <a href="javascript:void(0);" {if isset($error_message)} class="f_current_item_block list-group-item current-item-block no-match"{else}class="f_current_item_block list-group-item current-item-block"{/if}>
        <label for="item_{$item->getId()}">
            {if isset($error_message)}
                <div class="no-match-wrapper">
                    <div class="no-match-text">	
                        {$ns.lm->getPhrase(370)}
                        {$error_message}
                    </div>
                    <div class="arrow">
                    </div>
                </div>
            {/if}
            <div class="component_block">
                <div class="component_check">
                    {if !isset($ns.multiselect_component)}
                        <input class="pull-left f_selectable_component" name="sssss" id="item_{$item->getId()}" item_id="{$item->getId()}" count="{$selected_component_count}" type="radio" {if isset($item_is_selected)}checked="checked"{/if} autocomplete="off"/>		

                    {else}	
                        {if !isset($component_limit_over) || isset($item_is_selected)}
                            <input class="pull-left f_selectable_component" id="item_{$item->getId()}" item_id="{$item->getId()}" count="{$selected_component_count}" type="checkbox" {if isset($item_is_selected)}checked="checked"{/if} autocomplete="off"/>
                        {/if}
                    {/if}
                </div>

                <div class="component_img">
                    <img src="{$ns.itemManager->getItemImageURL($item->getId(), $item->getCategoriesIds(),'60_60', 1 , true)}" />
                </div>
                <div class="component_info">
                    <p class="components-title">
                        {if ($item->getDisplayName()|strlen)>100}
                            {$item->getDisplayName()|substr:0:100}...
                        {else}
                            {$item->getDisplayName()}
                        {/if}
                        {if $item->getBrand()} <span class="brand_name"> by {$item->getBrand()}</span> {/if}		
                        {if $item->getIsDealerOfThisCompany()==1}
                            <span class="company_name" title="{$ns.lm->getPhrase(271)}: {$item->getCompanyPhones()|replace:',':'&#13;&#10;'}" > 
                                {$ns.lm->getPhrase(66)}: <span>{$item->getCompanyName()} </span>
                            </span> 
                        {/if}
                    </p>
                </div>
                <div class="component_price">    
                    <p class="price">
                        {if $item->getIsDealerOfThisCompany()==1}
                            <span>${$item->getDealerPrice()|number_format:1}</span>						
                        {else}						
                            {assign var="price_in_amd" value=$ns.itemManager->exchangeFromUsdToAMD($item->getCustomerItemPrice())}
                            <span class="old_price">
                                {$price_in_amd|number_format} Դր.
                            </span>
                            </br>		
                            {math equation="1 - x/100" x=$ns.pc_configurator_discount assign="discountParam"}                                
                            <span title="{$ns.pc_configurator_discount}% {$ns.lm->getPhrase(285)}" >							
                                {($price_in_amd*$discountParam)|number_format} Դր.
                            </span>	

                        {/if} 
                    </p>

                </div>
            </div>
        </label>  
    </a>                   	
    {if isset($ns.multi_count_selection_item) && isset($ns.selected_components_ids_array) && in_array($item->getId(), $ns.selected_components_ids_array)}	
        <div class="pcc_select_wrapper">
        <div class="select_wrapper select_wrapper_min">
            <select class="pcc_selected_component_count" item_id="{$item->getId()}" id="selected_component_count_{$item->getId()}">
                {section name=spid start=1 loop=$max_count+1 step=1}
                    {assign var="index" value=$smarty.section.spid.index}		
                    <option value="{$index}" 			
                            {if $selected_component_count == $index} 
                                selected="selected"
                            {/if}>
                        {$index}
                    </option>
                {/section}
            </select>	
        </div>
        </div>
    {/if}
    {if isset($item_is_selected)}  
	    <div class="component_delete">        	
	          <span class="item-delete glyphicon" href="javascript:void(0);"> 
	          
	          </span>
	    </div>
    {/if}


</div>