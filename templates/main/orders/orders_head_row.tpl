<div id="order_collapse_expande_button^{$orderInfo->getId()}" class="order_expand_button collapse_expande_buttons"></div>
{$orderInfo->getId()}
{$orderInfo->getOrderDateTime()}
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
    {$orderInfo->getOrderTotalAmd()|number_format:0} Դր.
    {if $orderInfo->getUsedPoints()>0}
        </br>
        -{$orderInfo->getUsedPoints()|number_format:0} Դր. ({$ns.lm->getPhrase(434)})
    {/if}
{/if}
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
    ${$orderInfo->getOrderTotalUsd()|number_format:1}
{/if}
{if ($ns.userLevel === $ns.userGroupsAdmin)}
    <select id='f_order_status_select^{$orderInfo->getId()}'>
        {html_options values=$ns.orderStatusesValues selected=$orderInfo->getStatus() output=$ns.orderStatusesDisplayNames}
    </select>
{else}        
    {if $orderInfo->getStatus() == 0}         
        {$ns.lm->getPhrase(391)}
        {if $orderInfo->getPaymentType() == 'paypal'}                
            </br>
            {$ns.lm->getPhrase(592)}                
            </br>
            <img class="grayscale" style="width: 150px" src="{$SITE_PATH}/img/checkout/paypal_paynow.png"/>
        {/if}
        {if $orderInfo->getPaymentType() == 'bank'}                
            </br>
            {$ns.lm->getPhrase(596)}  
        {/if}
        {if $orderInfo->getPaymentType() == 'creditcard'}                
            </br>
            {$ns.lm->getPhrase(592)}                
            </br>
            <img class="grayscale" src="{$SITE_PATH}/img/checkout/creditcard_paynow.png"/>
        {/if}
    {else}
        {if $orderInfo->getStatus() == 1}  
            {* ORDER COMPLETED (DELIVERED) *}
            {$ns.lm->getPhrase(392)} ({$orderInfo->getDeliveredDateTime()})
            {include file="$TEMPLATE_DIR/main/sub_templates/order_payment_type.tpl"}
        {/if}
        {if $orderInfo->getStatus() == 2}
            {* ORDER CANCELLED *}
            {$ns.lm->getPhrase(393)}
            <img title="{$orderInfo->getCancelReasonText()}" style="cursor: pointer" src="{$SITE_PATH}/img/warning_icon.png" />                
        {/if}
        {if $orderInfo->getStatus() == 3}
            {if $orderInfo->get3rdPartyPaymentReceived()==0}

                {if $orderInfo->getPaymentType() == 'paypal'}                     
                    {$ns.lm->getPhrase(591)}
                    </br>
                    <!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->
                    <form action='{$SITE_PATH}/dyn/main_paypal/do_checkout' METHOD='POST'>
                        <input type="hidden" name="order_id" value="{$orderInfo->getId()}"/>
                        <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' style="border:0;" border='0' align='top' alt='Check out with PayPal'/>
                    </form>                        
                {/if}
                {if $orderInfo->getPaymentType() == 'bank'}
                    {$ns.lm->getPhrase(599)}</br>
                    {if $orderInfo->getIncludedVat()==1}
                        {$ns.lm->getPhrase(598)}
                    {else}
                        {$ns.lm->getPhrase(597)}
                    {/if}
                    </br>
                    <div style="padding: 10px;">
                        <a href="javascript:void(0);" id="print_invoice_btn" order_id="{$orderInfo->getId()}">
                            <img src="{$SITE_PATH}/img/print.png" style="vertical-align: middle"/>
                            {$ns.lm->getPhrase(641)}</a>
                    </div>
                {/if}
                {if $orderInfo->getPaymentType() == 'creditcard'}                     
                    {$ns.lm->getPhrase(591)}
                    </br>
                    <!-- INFO: The post URL "checkout.php" is invoked when clicked on "Pay with PayPal" button.-->                        
                    <a href="javascript:void(0);" class="credit_card_paynow_btn" order_id="{$orderInfo->getId()}" user_email="{$ns.userManager->getRealEmailAddressByUserDto($ns.customer)}" 
                       total_amount="{$ns.orderManager->getOrderTotalUsdToPay($orderInfo, true)}" >    
                        <img src="{$SITE_PATH}/img/checkout/creditcard_paynow.png"/>
                    </a>
                {/if}
                {if $orderInfo->getPaymentType() == 'arca'}                     
                    pay with arca
                {/if}
            {else}
                {* ORDER CONFIRMED PAYMENT*}
                {$ns.lm->getPhrase(590)}
                {include file="$TEMPLATE_DIR/main/sub_templates/order_payment_type.tpl"}
            {/if}
        {/if}              
    {/if}
{/if}