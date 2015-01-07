{assign var="bundleInfo" value=$orderItem[0]}
{assign var="bundleDisplayNameId" value=$bundleInfo->getOrderDetailsBundleDisplayNameId()}
<div class="order_bundle_item_total">
<div>{$ns.lm->getPhrase($bundleDisplayNameId)}</div>
<div>{$bundleInfo->getOrderDetailsDiscount()}% {* $ns.lm->getPhrase(285) *}</div>
<div>{$bundleInfo->getOrderDetailsBundleCount()}</div>
<div>
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'amd'}
    {$bundleInfo->getOrderDetailsCustomerBundlePriceAmd()|number_format:0} Դր
{/if}
</div>
<div>
{if $ns.priceVariety == 'both' || $ns.priceVariety == 'usd'}
    ${$bundleInfo->getOrderDetailsCustomerBundlePriceUsd()|number_format:1}
{/if}
</div>
</div>
{*<div id="bundle_collapse_expande_button^{$bundleInfo->getOrderDetailsBundleId()}" class="order_slide_btn f_order_slide_btn">See more</div>*}

