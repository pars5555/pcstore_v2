<div class="order_info">
<div class="order_number">{$orderInfo->getId()}</div>
<div class="order_date">{$orderInfo->getOrderDateTime()}</div>
<div class="order_price">
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
    <span class="price">{$orderInfo->getOrderTotalAmd()|number_format:0} Դր.</span>
    {if $orderInfo->getUsedPoints()>0}
        </br>
        <span class="price">-{$orderInfo->getUsedPoints()|number_format:0} Դր. ({$ns.lm->getPhrase(434)})</span>
    {/if}
{/if}
</div>
    <div class="order_price">
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
    <span class="price">${$orderInfo->getOrderTotalUsd()|number_format:1}</span>
{/if}
</div>
<div class="order_status">
{if ($ns.userLevel === $ns.userGroupsAdmin)}
<div class="select_wrapper">
    <select id='f_order_status_select^{$orderInfo->getId()}'>
        {html_options values=$ns.orderStatusesValues selected=$orderInfo->getStatus() output=$ns.orderStatusesDisplayNames}
    </select>
</div>
{else}        
    {if $orderInfo->getStatus() == 0}         
        <span>{$ns.lm->getPhrase(391)}</span>
        {if $orderInfo->getPaymentType() == 'paypal'}                
            </br>
            <span>{$ns.lm->getPhrase(592)}</span>              
            </br>
            <img class="grayscale" style="width: 150px" src="{$SITE_PATH}/img/checkout/paypal_paynow.png"/>
        {/if}
        {if $orderInfo->getPaymentType() == 'bank'}                
            </br>
            <span>{$ns.lm->getPhrase(596)}</span>
        {/if}
        {if $orderInfo->getPaymentType() == 'creditcard'}                
            </br>
            <span>{$ns.lm->getPhrase(592)}</span>                
            </br>
            <img class="grayscale" src="{$SITE_PATH}/img/checkout/creditcard_paynow.png"/>
        {/if}
    {else}
        {if $orderInfo->getStatus() == 1}  
            {* ORDER COMPLETED (DELIVERED) *}
            <span>{$ns.lm->getPhrase(392)}</span> ({$orderInfo->getDeliveredDateTime()})
            <span class="payment_type">{include file="$TEMPLATE_DIR/main/sub_templates/order_payment_type.tpl"}</span>
        {/if}
        {if $orderInfo->getStatus() == 2}
            {* ORDER CANCELLED *}
            <span>{$ns.lm->getPhrase(393)}</span>
            <img title="{$orderInfo->getCancelReasonText()}" style="cursor: pointer" src="{$SITE_PATH}/img/warning_icon.png" />                
        {/if}
        {if $orderInfo->getStatus() == 3}
            {if $orderInfo->get3rdPartyPaymentReceived()==0}

                {if $orderInfo->getPaymentType() == 'paypal'}                     
                    <span>{$ns.lm->getPhrase(591)}</span>
                    </br>
                    <!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->
                    <form action='{$SITE_PATH}/dyn/main_paypal/do_checkout' METHOD='POST'>
                        <input type="hidden" name="order_id" value="{$orderInfo->getId()}"/>
                        <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' style="border:0;" border='0' align='top' alt='Check out with PayPal'/>
                    </form>                        
                {/if}
                {if $orderInfo->getPaymentType() == 'bank'}
                    <span>{$ns.lm->getPhrase(599)}</span>
                    </br>
                    {if $orderInfo->getIncludedVat()==1}
                        <span>{$ns.lm->getPhrase(598)}</span>
                    {else}
                        <span>{$ns.lm->getPhrase(597)}</span>
                    {/if}
                    </br>
                    <div style="padding: 10px;">
                        <a href="javascript:void(0);" id="print_invoice_btn" order_id="{$orderInfo->getId()}">
                            <img src="{$SITE_PATH}/img/print.png" style="vertical-align: middle"/>
                            <span>{$ns.lm->getPhrase(641)}</span></a>
                    </div>
                {/if}
                {if $orderInfo->getPaymentType() == 'creditcard'}                     
                    <!-- <span>{$ns.lm->getPhrase(591)}<span> -->
                    </br>
                    <!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->                        
                    <a href="javascript:void(0);" class="credit_card_paynow_btn" order_id="{$orderInfo->getId()}" user_email="{$ns.userManager->getRealEmailAddressByUserDto($ns.customer)}" 
                       total_amount="{$ns.orderManager->getOrderTotalUsdToPay($orderInfo, true)}" >    
                        <img src="{$SITE_PATH}/img/checkout/creditcard_paynow.png"/>
                    </a>
                {/if}
                {if $orderInfo->getPaymentType() == 'arca'}                     
                    <span>pay with arca</span>
                {/if}
            {else}
                {* ORDER CONFIRMED PAYMENT*}
                <span>{$ns.lm->getPhrase(590)}</span>
                <span class="payment_type">{include file="$TEMPLATE_DIR/main/sub_templates/order_payment_type.tpl"}</span>
            {/if}
        {/if}              
    {/if}
{/if}
</div>
</div>
<div id="order_collapse_expande_button^{$orderInfo->getId()}" class="order_slide_btn f_order_slide_btn">See more</div>