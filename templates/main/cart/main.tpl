<div class="container cart-wrapper">
    {if isset($ns.customerMessages)}
        <h1 class="main_title customer_mes_title">The current Products are not available</h1>
        <ul class="list-customer-message">
            {foreach from=$ns.customerMessages item=customerMessage}
                <li>
                    {$customerMessage}
                </li>
            {/foreach}
        </ul>
    {/if}
    {if $ns.emptyCart == true}
        <h1>{$ns.lm->getPhrase(296)}</h1>		
    {else}   
        <h1 class="main_title">Shopping Cart Summary</h1>
        {foreach from=$ns.cartItems item=cartItem}
            {if is_array($cartItem)}
            <div class="f_bundle_item cart-item bundle-cart-item">
                {include file="$TEMPLATE_DIR/main/cart/cart_bundle_item.tpl" bundleItems=$cartItem}
                </div>
            {else}
            <div class="cart-item">
                {include file="$TEMPLATE_DIR/main/cart/cart_item.tpl" cartItem=$cartItem}
                </div>
            {/if}
        {/foreach}
    {/if}
</div>
<div class="cart_checkout">
{if !$ns.emptyCart}
<div class="vat">
    <a href="{$SITE_PATH}/dyn/main/do_set_customer_cart_included_vat?include_vat={if $ns.customer->getCartIncludedVat()==1}0{else}1{/if}" >
        {if $ns.customer->getCartIncludedVat()==1}Exclude Vat{else}Include Vat{/if}
    </a>
    <span>{$ns.lm->getPhrase(565)}</span>
<div class="clear"></div>
</div>
<div class="cart_total">
    <span class="total_ph">{$ns.lm->getPhrase(262)}</span>
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
        <span class="price">${$ns.grandTotalUSD|number_format:1}</span>
    {/if}
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
        {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
            <span class="and_phrase">{$ns.lm->getPhrase(270)}</span>
        {/if}
        <span class="price">{$ns.grandTotalAMD|number_format:0} Դր.</span>
    {/if}
{/if}
<div class="clear"></div>
</div>
{if $ns.emptyCart}
    {assign var="nextButtonTitlePhraseId" value="296"}
{else}
    {if !$ns.allItemsAreAvailable}
        {assign var="nextButtonTitlePhraseId" value="295"}
    {else}
        {if !$ns.minimum_order_amount_exceed}			
            {assign var="nextButtonTitlePhraseId" value="`420` `$ns.minimum_order_amount_amd`"}
        {/if}	
    {/if}
{/if}

{if !$ns.allItemsAreAvailable || $ns.emptyCart || !$ns.minimum_order_amount_exceed || ($ns.customer->getCartIncludedVat() == 1 && !$ns.all_non_bundle_items_has_vat)}
    {assign var="disableButton" value=1}
{else}
    {assign var="disableButton" value=0}
{/if}
<button class="button blue" {if $disableButton == 1}disabled{/if}>checkout</button>
{if isset($nextButtonTitlePhraseId)}
    <span class="warning_message">{$ns.lm->getPhrase($nextButtonTitlePhraseId)}</span>
{/if}
</div>
<div class="clear"></div>