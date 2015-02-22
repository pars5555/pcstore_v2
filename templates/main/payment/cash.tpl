<div class="payment_cash_wrapper container">
    {if $ns.do_shipping == 1}
        <h3 class="title">{$ns.lm->getPhraseSpan(290)}</h3>
        <div class="pd_cash">
            <div class="form-group">
                <p>
                    {$ns.lm->getPhrase(293)} : 
                </p>
                <p>
                    {$ns.recipientName}
                </p>
            </div>
            <div class="form-group">
                <p>                
                    {$ns.lm->getPhrase(13)} : 
                </p>
                <p>
                    {$ns.shipAddr}
                </p>
            </div>
            <div class="form-group">
                <p>
                    {$ns.lm->getPhrase(45)} : 
                </p>
                <p>
                    {$ns.shippingRegion}
                </p>
            </div>
            <div class="form-group">
                <p>
                    {$ns.lm->getPhrase(309)} : 
                </p>
                <p>
                    {$ns.shipCellTel}
                </p>
            </div>
            <div class="form-group">
                <p>
                    {$ns.lm->getPhrase(62)} : 
                </p>
                <p>
                    {$ns.shipTel}
                </p>
            </div>
        </div>
    {else}
        <h3 class="title">{$ns.lm->getPhraseSpan(306)}</h3>
        <div class="pcstore_info_text">
            {$ns.lm->getPhraseSpan(307)}
        </div>
    {/if}
</div>