<script type="text/javascript" src="//checkout.stripe.com/checkout.js"></script>
<input type="hidden" id="stripe_publishable_key" value="{$ns.stripe_publishable_key}"/>
<div class="container">
    {if isset($ns.customerMessages)}
        {foreach from=$ns.customerMessages item=customerMessage}
            <div>
                {$customerMessage}
            </div>
        {/foreach}
    {/if}
    {if isset($ns.customerErrorMessages)}
        {foreach from=$ns.customerErrorMessages item=customerMessage}
            <div>
                {$customerMessage}
            </div>
        {/foreach}
    {/if}
    
    <h1 class="main_title">{$ns.lm->getPhrase(142)}</h1>
    {include file="$TEMPLATE_DIR/main/orders/table_header.tpl"}
    {foreach from=$ns.groupOrdersByOrderIdAndBundleId key=orderId item=orderItems name=foo}
        <div class="order_main_block">

            {*order head row*}
            {assign var="orderInfo" value=$orderItems|@current}
            {if is_array($orderInfo)}
                {assign var="orderInfo" value=$orderInfo|@current}
            {/if}

            {include file="$TEMPLATE_DIR/main/orders/orders_head_row.tpl"}
            <div class="f_order_more_info" style="display: none" >
                <div id="order_container_{$orderInfo->getId()}" class="order_more_info">
                    {include file="$TEMPLATE_DIR/main/orders/orders_head_row_table_head.tpl"}
                    
                    {foreach from=$orderItems key=bundleId item=orderItem name=foo}
                        {if is_array($orderItem)}
                            {include file="$TEMPLATE_DIR/main/orders/order_bundle_item_head_row.tpl"}
                            <div id="bundle_container_{$orderItem[0]->getOrderDetailsBundleId()}" class="order_bundle_components">
                                {include file="$TEMPLATE_DIR/main/orders/order_bundle_item.tpl"}
                            </div>
                        {else}
                            {include file="$TEMPLATE_DIR/main/orders/order_item.tpl"}
                        {/if}

                    {/foreach}
                </div>
            </div>
        </div>
    {/foreach }
</div>
