{if $orderInfo->getPaymentType() == 'creditcard'}
    </br>
    {$ns.lm->getPhrase(367)}: {$ns.lm->getPhrase(618)}
{/if}
{if $orderInfo->getPaymentType() == 'paypal'}
    </br>
    {$ns.lm->getPhrase(367)}: Paypal
{/if}
{if $orderInfo->getPaymentType() == 'bank'}
    </br>
    {$ns.lm->getPhrase(367)}: {$ns.lm->getPhrase(440)}
{/if}
{if $orderInfo->getPaymentType() == 'arca'}
    </br>
    {$ns.lm->getPhrase(367)}: Arca
{/if}
{if $orderInfo->getPaymentType() == 'credit'}
    </br>
    {$ns.lm->getPhrase(367)}: {$ns.lm->getPhrase(364)}
{/if}
{if $orderInfo->getPaymentType() == 'cash'}
    </br>
    {$ns.lm->getPhrase(367)}: {$ns.lm->getPhrase(363)}
{/if}