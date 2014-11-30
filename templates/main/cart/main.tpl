<div class="container cart-wrapper">
    {if isset($ns.customerMessages)}
        <h1 class="cart_title">The current Products are not available</h1>
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
        <h1 class="cart_title">Shopping Cart Summary</h1>
        {foreach from=$ns.cartItems item=cartItem}
            {if is_array($cartItem)}
                {include file="$TEMPLATE_DIR/main/cart/cart_bundle_item.tpl" bundleItems=$cartItem}
            {else}
                {include file="$TEMPLATE_DIR/main/cart/cart_item.tpl" cartItem=$cartItem}
            {/if}
        {/foreach}
    {/if}
</div>

{if !$ns.emptyCart}
    <a href="{$SITE_PATH}/dyn/main/do_set_customer_cart_included_vat?include_vat={if $ns.customer->getCartIncludedVat()==1}0{else}1{/if}" >
        {if $ns.customer->getCartIncludedVat()==1}Exclude Vat{else}Include Vat{/if}
    </a>
    {$ns.lm->getPhrase(565)}
    {$ns.lm->getPhrase(262)}
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
        ${$ns.grandTotalUSD|number_format:1}
    {/if}
    {if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
        {if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
            {$ns.lm->getPhrase(270)}
        {/if}
        {$ns.grandTotalAMD|number_format:0} Դր.
    {/if}
{/if}

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
<button {if $disableButton == 1}disabled{/if}>checkout</button>
{if isset($nextButtonTitlePhraseId)}
    {$ns.lm->getPhrase($nextButtonTitlePhraseId)}
{/if}