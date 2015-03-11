<div class="vat">
    <a href="javascript:void(0);" class="f_checkbox checkbox {if $ns.customer->getCartIncludedVat()==1}checked{/if}"></a>
    <span>{$ns.lm->getPhrase(565)}</span>
    <div class="clear"></div>
</div>
<div class="shipping_info" id="shipping_cost_container" {if $ns.do_shipping==0}style="display:none"{/if}>
    <span>Shipping</span>
    
    {if isset($ns.shipping_not_available)}
        <span class="text_red">{$ns.lm->getPhrase(315)}</span>
    {else}
        <span class="price">{$ns.shipping_cost} Դր.</span> 
    {/if}
    <div class="clear"></div>
</div>
<div class="cart_total">
    <span class="total_ph">{$ns.lm->getPhrase(262)} {if $ns.customer->getCartIncludedVat()==1}<br><span class="vat_state">({$ns.lm->getPhrase(565)}){/if}</span></span>
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
        <span class="price">${$ns.grandTotalUSD|number_format:1}</span>
    {/if}
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
        {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
            <span class="and_phrase">{$ns.lm->getPhrase(270)}</span>
        {/if}
        <span class="price" ><span id="total_amd">{$ns.grandTotalAMD|number_format:0}</span> Դր.</span>
    {/if}
    <div class="clear"></div>
</div>
<a class="button blue {if isset($ns.shipping_not_available)} disabled {else} checkout_confirm_btn {/if}" href="javascript:void(0);">Checkout confirm</a>
