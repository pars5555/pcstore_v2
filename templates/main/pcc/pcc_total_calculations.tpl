<h1 class="your_pc">Your PC</h1>
<a href="#" class="facebook_share" onclick="
        var sharer = '//www.facebook.com/sharer/sharer.php?s=100&p[url]=' +
                encodeURIComponent(location.href) + '&p[images][0]=' + '{$SITE_PATH}/img/icon_pc.png' +
                '&p[title]=PcStore PC configurator' + '&p[summary]=';
        window.open(sharer,
                'fb-share-dialog',
                'width=626,height=436');
        return false;">	
</a>

<div class="clear"> </div>
{foreach from=$ns.selected_components item=item name=sc}
    {if $item}
        {if !($item|is_array)}			
            {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=1 item=$item}				
        {else}
            {assign var="groupedSameItems" value=$ns.pccm->groupSameItemsInSubArrays($item)}				
            {foreach from=$groupedSameItems item=subarray}
                {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=$subarray|@count item=$subarray.0}			
            {/foreach}
        {/if}			
    {/if}
{/foreach}


<div class="clear"> </div>


{*} PC build fee {*}
<div class="pcc_build_pc_fee">
{$ns.lm->getPhrase(320)}*
<span style="{if $ns.pc_build_fee_amd==0}color:#008800{/if}"> 
    {if $ns.pc_build_fee_amd>0}
        {$ns.pc_build_fee_amd} Դր.
    {else}
        {$ns.lm->getPhrase(289)}
    {/if} 
</span>
</div>

<div class="clear"> </div>
{*   total price   *}
<div class="pcc_total_price">
{$ns.lm->getPhrase(261)}
{if $ns.total_usd>0}
    ${$ns.total_usd|number_format:1} 
{/if}
{if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
    {($ns.total_amd+$ns.pc_build_fee_amd)|number_format:0} Դր.
{/if}
{if $ns.total_amd==0 && $ns.total_usd==0}
    0 Դր.
{/if}

{*   discounted price   *}
{if $ns.total_amd>0}
    {$ns.lm->getPhrase(285)} {$ns.pc_configurator_discount}%

    {if $ns.total_usd>0}
        ${$ns.total_usd|number_format:1}
    {/if}
    {if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
        {$ns.grand_total_amd|number_format:0} Դր.
    {/if}
    {if $ns.total_amd==0 && $ns.total_usd==0}
        0 Դր.
    {/if}
{/if}
</div>

{if $ns.ready_to_order == "true"}
    {if ($ns.userLevel!=$ns.userGroupsGuest)}
        {if isset($ns.configurator_mode_edit_cart_row_id) && $ns.configurator_mode_edit_cart_row_id > 0}
             <a href="{$SITE_PATH}/dyn/user/do_add_pc_to_cart?bundle_items_ids={$ns.selected_components_comma_separated}&replace_cart_row_id={$ns.configurator_mode_edit_cart_row_id}" class="btn btn-primary btn-block btn-default">{$ns.lm->getPhrase(43)}</a>
        {else}
            <a href="{$SITE_PATH}/dyn/user/do_add_pc_to_cart?bundle_items_ids={$ns.selected_components_comma_separated}" class="btn btn-primary btn-block btn-default">{$ns.lm->getPhrase(284)}</a>
        {/if}            
    {else}
        <a class="btn btn-primary btn-block btn-default f_myModal_toggle" href="javascript:void(0);">{$ns.lm->getPhrase(85)}</a>
    {/if}
    <a href="javascript:void(0);" id="pcc_print_button" > 
        {$ns.lm->getPhrase(629)}
    </a>
{/if}
