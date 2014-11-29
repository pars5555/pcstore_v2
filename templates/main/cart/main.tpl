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
    
