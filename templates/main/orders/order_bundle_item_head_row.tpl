{assign var="bundleInfo" value=$orderItem[0]}
<div id="bundle_collapse_expande_button^{$bundleInfo->getOrderDetailsBundleId()}" class="order_expand_button collapse_expande_buttons"> </div>
{assign var="bundleDisplayNameId" value=$bundleInfo->getOrderDetailsBundleDisplayNameId()}
{$ns.lm->getPhrase($bundleDisplayNameId)}  ({$bundleInfo->getOrderDetailsDiscount()}% {$ns.lm->getPhrase(285)})
{$bundleInfo->getOrderDetailsBundleCount()}
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
    {$bundleInfo->getOrderDetailsCustomerBundlePriceAmd()|number_format:0} Դր
{/if}
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
    ${$bundleInfo->getOrderDetailsCustomerBundlePriceUsd()|number_format:1}
{/if}

