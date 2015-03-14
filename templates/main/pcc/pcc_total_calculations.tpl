<div class="your_pc">
    <span>Your PC</span><span class="your_pc_img"></span>
</div>
<a href="#" class="facebook_share" onclick="
        var sharer = '//www.facebook.com/sharer/sharer.php?s=100&p[url]=' +
                encodeURIComponent(location.href) + '&p[images][0]=' + '{$SITE_PATH}/img/icon_pc.png' +
                '&p[title]=PcStore PC configurator' + '&p[summary]=';
        window.open(sharer,
                'fb-share-dialog',
                'width=626,height=436');
        return false;"> </a>

<div class="clear"></div>
{foreach from=$ns.selected_components item=item key=key name=sc}
    {if isset($item) && !empty($item)}
        {if !($item|is_array)}
            {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=1 item=$item componentTypeIndex=$key+1}
        {else}
            {assign var="groupedSameItems" value=$ns.pccm->groupSameItemsInSubArrays($item)}
            {foreach from=$groupedSameItems item=subarray}
                {include file="$TEMPLATE_DIR/main/pcc/pcc_totcalc_component_row.tpl" count=$subarray|@count item=$subarray.0 componentTypeIndex=$key+1}
            {/foreach}
        {/if}
    {/if}
{/foreach}

<div class="clear"></div>

{*} PC build fee {*}
<div class="pcc_build_pc_fee">
    <div class="component_block">
        <div class="component_check"></div>
        <div class="component_img">
            <span class="glyphicon"></span>
        </div>
        <div class="component_info">
            {$ns.lm->getPhrase(320)}*
        </div>
        <div class="component_price">
            <span style="{if $ns.pc_build_fee_amd==0}color:#008800{/if}"> {if $ns.pc_build_fee_amd>0}
                {$ns.pc_build_fee_amd} Դր.
                {else}
                    {$ns.lm->getPhrase(289)}
                    {/if} </span>
                </div>
            </div>
        </div>

        {*   total price   *}
        <div class="pcc_total_price">
            <div class="total_ph">{$ns.lm->getPhrase(261)}</div>
            {if $ns.total_usd>0}
                <span class="price"> ${$ns.total_usd|number_format:1} </span>
            {/if}            
            {if $ns.total_usd>0 && ($ns.total_amd>0 || $ns.pc_build_fee_amd>0)}
                <span class="and_phrase">{$ns.lm->getPhrase(270)}</span>
            {/if}
            {if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
                <span class="{if $ns.pc_configurator_discount>0 && $ns.total_amd>0}old_price{else}price{/if}">{($ns.total_amd+$ns.pc_build_fee_amd)|number_format:0} Դր. </span>
            {/if}
            
            <div class="clear"></div>
            {*   discounted price   *}
            
                <div class="discount text_red">{$ns.lm->getPhrase(285)} {$ns.pc_configurator_discount}%</div>

                {if $ns.total_usd>0}
                    <span class="price">${$ns.total_usd|number_format:1}</span>
                {/if}       
                {if $ns.total_usd>0 && ($ns.total_amd>0 || $ns.pc_build_fee_amd>0)}
                    <span class="and_phrase">{$ns.lm->getPhrase(270)}</span>
                {/if}
                {if $ns.total_amd>0 || $ns.pc_build_fee_amd>0}
                    <span class="price"> {$ns.grand_total_amd|number_format:0} Դր. </span>
                {/if}
                
           
        </div>

        {if $ns.ready_to_order == "true"}
            {if ($ns.userLevel!=$ns.userGroupsGuest)}
                {if isset($ns.configurator_mode_edit_cart_row_id) && $ns.configurator_mode_edit_cart_row_id > 0}
                    <a href="{$SITE_PATH}/dyn/user/do_add_pc_to_cart?bundle_items_ids={$ns.selected_components_comma_separated}&replace_cart_row_id={$ns.configurator_mode_edit_cart_row_id}" class="button blue save_pcc">{$ns.lm->getPhrase(43)}</a>
                {else}
                    <a href="{$SITE_PATH}/dyn/user/do_add_pc_to_cart?bundle_items_ids={$ns.selected_components_comma_separated}" class="button blue add_to_cart"><span class="glyphicon"></span>{$ns.lm->getPhrase(284)}</a>
                {/if}
            {else}
                <a class="f_myModal_toggle button blue" href="javascript:void(0);">{$ns.lm->getPhrase(85)}</a>
            {/if}
            <a href="javascript:void(0);" id="pcc_print_button" class="button blue pcc_print_button" > <span class="glyphicon"></span>{$ns.lm->getPhrase(629)} </a>
        {/if}
