<script type="text/javascript" src="//checkout.stripe.com/checkout.js"></script>   
<input type="hidden" id="stripe_publishable_key" value="{$ns.stripe_publishable_key}"/>
<div class="container">
    {if isset($ns.customerMessages)}
        {foreach from=$ns.customerMessages item=customerMessage} 
            <div>{$customerMessage}</div>
        {/foreach}
    {/if}
    {if isset($ns.customerErrorMessages)}
        {foreach from=$ns.customerErrorMessages item=customerMessage} 
            <div>{$customerMessage}</div>
        {/foreach}
    {/if}
    {include file="$TEMPLATE_DIR/main/orders/table_header.tpl"}
    {foreach from=$ns.groupOrdersByOrderIdAndBundleId key=orderId item=orderItems name=foo}			

        {*order head row*}
        {assign var="orderInfo" value=$orderItems|@current}		
        {if is_array($orderInfo)}			
            {assign var="orderInfo" value=$orderInfo|@current}
        {/if}

        {include file="$TEMPLATE_DIR/main/orders/orders_head_row.tpl"}						
        <div id="order_container_{$orderInfo->getId()}">
            {include file="$TEMPLATE_DIR/main/orders/orders_head_row_table_head.tpl"}
            <div style="clear: both"> </div>            
            {foreach from=$orderItems key=bundleId item=orderItem name=foo}                
                {if is_array($orderItem)}
                    {include file="$TEMPLATE_DIR/main/orders/order_bundle_item_head_row.tpl"}											
                    <div id="bundle_container_{$orderItem[0]->getOrderDetailsBundleId()}" style="width:100%;position: relative;display: none">		
                        {include file="$TEMPLATE_DIR/main/orders/order_bundle_item.tpl"}
                        <div style="clear: both"> </div>
                    </div>	
                {else}
                    {include file="$TEMPLATE_DIR/main/orders/order_item.tpl"}
                {/if}
                <div style="clear: both"> </div>

            {/foreach}			
            <div style="clear: both"> </div>
        </div>
    {/foreach }
</div>
