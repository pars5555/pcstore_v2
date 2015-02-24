<div class="order_header">
    <div>{$ns.lm->getPhrase(109)}</div>
    <div>{$ns.lm->getPhrase(285)}</div>
    <div>{$ns.lm->getPhrase(328)}</div>
    <div>{$ns.lm->getPhrase(88)} (Դր.)</div>
    <div>
        {if $ns.priceVariety == 'both' or $ns.priceVariety == 'usd'}
            {$ns.lm->getPhrase(88)} ($)
        {/if}
    </div>
</div>