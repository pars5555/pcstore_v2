<div class="orders_main_header">
    <div>
        {$ns.lm->getPhrase(325)}
    </div>
    <div>
        {$ns.lm->getPhrase(326)}
    </div>
    <div>
        {$ns.lm->getPhrase(114)} (Դր.)
    </div>
    <div>
        {if $ns.priceVariety == 'both' or $ns.priceVariety == 'usd'}
            {$ns.lm->getPhrase(114)} ($)
        {/if}
    </div>
    <div>
        {$ns.lm->getPhrase(372)}
    </div>
</div>