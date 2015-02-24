<div class="payment_credit_wrapper container">
    {if $ns.do_shipping == 1}
        <div>
            <p class="credit_no_ship">{$ns.lm->getPhraseSpan(421)}</p>
            <p class="credit_no_ship">{$ns.lm->getPhraseSpan(422)}</p>
            <div class="doublespace"></div>
            <p class="pcstore_info_text">{$ns.lm->getPhraseSpan(307)}</p>
            {*            <p>{$ns.lm->getPhraseSpan(423)}</p>*}
        </div>	
    {else}
        {if $ns.customer->getCartIncludedVat()==1}
            <div class="text_blue bold">
                {$ns.lm->getPhraseSpan(566)}
            </div>
        {else}
            {if $ns.grandTotalUSD>0}
                <div class="form-group">
                    <h3 class="text_blue" phrase_id="`428`${$ns.grandTotalUSD}`352`">
                        {$ns.lm->getPhraseSpan(428)}${$ns.grandTotalUSD}{$ns.lm->getPhraseSpan(352)} 
                    </h3>
                </div>
            {/if}

            {* credit total amount*}
            <div class="form-group">
                <p>{$ns.lm->getPhraseSpan(429)} : </p>
                <p class="price">{$ns.grandTotalAmdWithCommission} Դր.</p>
            </div>

            {* credit suppler select *}
            <div class="form-group">
                <p class="label">
                    {$ns.lm->getPhraseSpan(426)} : 
                </p>
                <p class="select_wrapper">
                    <select id="cho_credit_supplier_id" name="cho_credit_supplier_id"
                            onkeyup="this.blur();
                                    this.focus();" class="cmf-skinned-select cmf-skinned-text"  >
                        {html_options values=$ns.creditSuppliersIds selected=$ns.cho_credit_supplier_id output=$ns.creditSuppliersDisplayNames}
                    </select>
                </p>
                {*<p>
                    {$ns.credit_supplier_interest_percent}%
                    {if $ns.credit_supplier_annual_commision>0}
                        + {$ns.credit_supplier_annual_commision}% ({$ns.lm->getPhraseSpan(568)})
                    {/if}
                </p>*}
            </div>


            {if ($ns.grandTotalAMD>=$ns.minimum_credit_amount)}
                {* credit months*}
                <div class="form-group">
                    <p class="label">
                        {$ns.lm->getPhraseSpan(424)} : 
                    </p>
                    <p class="select_wrapper">
                        <select id="cp_cho_selected_credit_months" name="cho_selected_credit_months" 
                                onkeyup="this.blur();
                                        this.focus();" class="cmf-skinned-select cmf-skinned-text"  >
                            {html_options values=$ns.possibleCreditMonths selected=$ns.cho_selected_credit_months output=$ns.possibleCreditMonths}
                        </select>
                    </p>
                    <p>
                        {$ns.lm->getPhraseSpan(183)}
                    </p>
                </div>

                {assign var="credit_amount_include_deposit" value=$ns.grandTotalAMD-$ns.deposit_amd}	
                {* credit deposit amount*}
                <div class="form-group">
                    <p class="label">
                        {$ns.lm->getPhraseSpan(427)} : 		
                    </p>
                    <p>
                        <input class="text" id="deposit_amd" name="deposit_amd" type="text" value="{$ns.deposit_amd}" style="{if $ns.minimum_credit_amount>$credit_amount_include_deposit}color:red{/if}"/>
                    </p>
                </div>

                <a class="button blue" href="javascript:void(0);" id="calculate_credit_monthly_payments_button">
                    {$ns.lm->getPhraseSpan(430)}
                </a>
                {if $ns.minimum_credit_amount>$credit_amount_include_deposit}
                    <p style="color:#AA0000;font-size: 16px;font-weight: bold;margin-left: 10px;">{$ns.lm->getPhraseSpan(433)} {$ns.minimum_credit_amount} Դր.</p>
                {/if}


                {* credit monthly payment*}
                <div style="margin-top: 10px">
                    {$ns.lm->getPhraseSpan(425)}: <span class="price">{$ns.credit_monthly_payment} Դր.</span> ({$ns.lm->getPhraseSpan(561)})
                </div>
            {else}
                <div class="form-group text_red">
                    <span>{$ns.lm->getPhraseSpan(420)} : </span> <span class="bold">{$ns.minimum_credit_amount} Դր.</span>
                </div>

            {/if}
        {/if}    
    {/if}



</div>