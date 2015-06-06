<div class="container cart-wrapper">
    {if isset($ns.customerMessages)}
        <h1 class="main_title customer_mes_title">The current Products are not available</h1>
        <div class="list-customer-message">
            {foreach from=$ns.customerMessages item=customerMessage}
                {include file="$TEMPLATE_DIR/main/message.tpl" type="error" content="{$customerMessage}"} 
            {/foreach}
        </div>
    {/if}
    {if $ns.emptyCart == true}
        <h1>{$ns.lm->getPhrase(296)}</h1>		
    {else}   
        <h1 class="main_title">{$ns.lm->getPhrase(278)}</h1>
        <div class="cart-item cart_items_head">
            <div class="component_block">
                <div class="component_img">
                    {$ns.lm->getPhrase(108)}
                </div>
                <div class="component_info">
                    {$ns.lm->getPhrase(109)}
                </div>
                <div class="cart_item_count">
                    {$ns.lm->getPhrase(328)}
                </div>
                <div class="component_unit_prie">
                    {$ns.lm->getPhrase(674)}
                </div>
                <div class="component_total_price">
                    {$ns.lm->getPhrase(313)}
                </div>
                <div class="component_discount">
                    {$ns.lm->getPhrase(285)}
                </div>
                <div class="component_actions">
                </div>
            </div>
        </div>
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
            <a href="{$SITE_PATH}/dyn/main/do_set_customer_cart_included_vat?include_vat={if $ns.customer->getCartIncludedVat()==1}0{else}1{/if}" class="checkbox {if $ns.customer->getCartIncludedVat()==1}checked{/if}">
            </a>
            <span>{$ns.lm->getPhrase(565)}</span>
            <div class="clear"></div>
        </div>

        {if $ns.totalPromoDiscountAmd>0}
            <div class="promo">
                <span>Promo Discount</span>
                <span class="text_red">{$ns.totalPromoDiscountAmd|number_format:0} Դր.</span>
                <div class="clear"></div>
            </div>
        {/if}
        {if $ns.totalDealDiscountAmd>0}
            <div class="deal">
                <span>{$ns.totalDealDiscountAmd|number_format:0} Դր.</span>
                <span>Deal Discount</span>
                <div class="clear"></div>
            </div>
        {/if}
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
            <div class="clear"></div>
        </div>

    {/if}
    {if $ns.emptyCart}
        {assign var="warningMessage" value="296"}
    {else}
        {if !$ns.allItemsAreAvailable}
            {assign var="warningMessage" value="295"}
        {else}
            {if !$ns.minimum_order_amount_exceed}			
                {assign var="warningMessage" value="`420` `$ns.minimum_order_amount_amd`"}
            {/if}	
        {/if}
    {/if}

    {if !$ns.allItemsAreAvailable || $ns.emptyCart || !$ns.minimum_order_amount_exceed || ($ns.customer->getCartIncludedVat() == 1 && !$ns.all_non_bundle_items_has_vat)}
        {assign var="disableButton" value=1}
    {else}
        {assign var="disableButton" value=0}
    {/if}
    <a class="button {if $disableButton == 1}grey{else}blue{/if}" {if $disableButton == 0}href="{$SITE_PATH}/checkout"{/if} {if $disableButton == 1}disabled{/if}>{$ns.lm->getPhrase(281)}</a>
    {if isset($warningMessage)}
        {include file="$TEMPLATE_DIR/main/message.tpl" type="warning" content="{$ns.lm->getPhrase($warningMessage)}"}
    {/if}
</div>
{if $ns.userLevel==$ns.userGroupsUser}
    <div class="promo_code_container">
        <form autocomplete="off" action="{$SITE_PATH}/dyn/main/do_set_promo_code" method="POST">
            <div class="form-group">    
                <div class="table">
                    <div class="table-cell">                
                        <input class="text" type="text" placeholder="{$ns.lm->getPhrase(551)}" id="promo_code" name="promo_code" />
                    </div>
                    <div class="table-cell">                
                        <button class="button blue">Apply</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
{/if}
<div class="clear"></div>