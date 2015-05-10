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
    {if $ns.priceVariety == 'both' or $ns.priceVariety == 'usd'}
        <div>
            {$ns.lm->getPhrase(114)} ($)
        </div>
    {/if}
    <div>
        {$ns.lm->getPhrase(372)}
    </div>
</div>