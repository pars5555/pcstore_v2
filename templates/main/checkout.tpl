<div class="checkout-wrapper container">
    <h3 class="main_title">Checkout</h3>

    {if isset($ns.success_message)}
        <div class="success">
            <strong> {$ns.success_message}</strong>
        </div>
    {/if}
    {if isset($ns.error_message)}
        <div class="error">
            <strong> {$ns.error_message}</strong>
        </div>
    {/if}
    <form role="form" method="post" action="{$SITE_PATH}/dyn/user/do_checkout" autocomplete="off">

        {****************Shipping Address Container******************}

        <div class="ship_addr_container">
            <div class="form-group ship_addr_state f_ship_addr_state">
                <input type="checkbox" class="ship_addr_checkbox" name="ship_addr_state" id="shipAddrState">
                <label class="input_label" for="shipAddrState">{$ns.lm->getPhrase(297)}</label>
            </div>
            <div class="ship_addr_form f_ship_addr_form">
                <div class="form-group">
                    <label class="input_label" for="recipientName">{$ns.lm->getPhrase(293)}</label>
                    <input type="text" class="text"  name= "recipient_name" id="recipientName" placeholder="{$ns.lm->getPhrase(293)}" />
                </div>
                <div class="form-group">
                    <label class="input_label" for="shipAddr">{$ns.lm->getPhrase(13)}</label>
                    <input type="text" class="text"  name= "ship_addr" id="shipAddr" placeholder="{$ns.lm->getPhrase(13)}" />
                </div>
                <div class="form-group">
                    <label class="input_label" for="recipientName">{$ns.lm->getPhrase(45)}</label>
                    <div class="select_wrapper">
                        <select>
                            <option>
                                Yerevan
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="input_label" for="shipCellTel">{$ns.lm->getPhrase(309)}</label>
                    <input type="text" class="text"  name= "ship_cell_tel" id="shipCellTel" placeholder="{$ns.lm->getPhrase(309)}" />
                    <div>Բջջային հեռախոսի համարը պետք է լինի իրական և վավեր: Դուք կստանաք SMS այս համարին՝ պատվերը հաստատելու համար:</div>
                </div>
                <div class="form-group">
                    <label class="input_label" for="shipTel">{$ns.lm->getPhrase(62)}</label>
                    <input type="text" class="text"  name= "ship_tel" id="shipTel" placeholder="{$ns.lm->getPhrase(62)}" />
                </div>

                </form>
            </div>
        </div>

        {****************Billing Address Container******************}

        <div class="bill_addr_container">

            <div class="form-group bill_addr_state f_bill_addr_state">
                <input type="checkbox" class="bill_addr_checkbox" name="bill_addr_state" id="billAddrState">
                <label class="input_label" for="billAddrState">{$ns.lm->getPhrase(297)}</label>
            </div>
            <div class="bill_addr_form f_bill_addr_form">
                <div class="form-group">
                    <label class="input_label" for="recipientName">{$ns.lm->getPhrase(304)}</label>
                    <input type="text" class="text"  name= "recipient_name" id="recipientName" placeholder="{$ns.lm->getPhrase(304)}" />
                </div>
                <div class="form-group">
                    <label class="input_label" for="billAddr">{$ns.lm->getPhrase(13)}</label>
                    <input type="text" class="text"  name= "bill_addr" id="billAddr" placeholder="{$ns.lm->getPhrase(13)}" />
                </div>
                <div class="form-group">
                    <label class="input_label" for="recipientName">{$ns.lm->getPhrase(45)}</label>
                    <div class="select_wrapper">
                        <select>
                            <option>
                                Yerevan
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="input_label" for="billCellTel">{$ns.lm->getPhrase(309)}</label>
                    <input type="text" class="text"  name= "bill_cell_tel" id="billCellTel" placeholder="{$ns.lm->getPhrase(309)}" />
                    <div>Բջջային հեռախոսի համարը պետք է լինի իրական և վավեր: Դուք կստանաք SMS այս համարին՝ պատվերը հաստատելու համար:</div>
                </div>
                <div class="form-group">
                    <label class="input_label" for="billTel">{$ns.lm->getPhrase(62)}</label>
                    <input type="text" class="text"  name= "bill_tel" id="billTel" placeholder="{$ns.lm->getPhrase(62)}" />
                </div>

            </div>
        </div>

        {****************Billing Address Container******************}

        <div class="payment_type_container"> 
            <h2>{$ns.lm->getPhrase(367)}</h2>
            <div class="form-group">
                <input type="radio" class=""  name="payment_type" id="payment_cash" />
                <label class="input_label" for="payment_cash">{$ns.lm->getPhrase(363)}<img src="{$SITE_PATH}" alt=""></label>
            </div>
            <div class="form-group">
                <input type="radio" class=""  name="payment_type" id="payment_credit" />
                <label class="input_label" for="payment_credit">{$ns.lm->getPhrase(364)}<img src="{$SITE_PATH}" alt=""></label>
            </div>
            <div class="form-group">
                <input type="radio" class=""  name="payment_type" id="payment_paypal" />
                <label class="input_label" for="payment_paypal">{$ns.lm->getPhrase(365)}<img src="{$SITE_PATH}" alt=""></label>
            </div>
            <div class="form-group">
                <input type="radio" class=""  name="payment_type" id="payment_arca" />
                <label class="input_label" for="payment_arca">{$ns.lm->getPhrase(366)}<img src="{$SITE_PATH}" alt=""></label>
            </div>
            <div class="form-group">
                <input type="radio" class=""  name="payment_type" id="payment_bank" />
                <label class="input_label" for="payment_bank">Bank Transfer <img src="{$SITE_PATH}" alt=""></label>
            </div>
            <div class="form-group">
                <input type="radio" class=""  name="payment_type" id="payment_card" />
                <label class="input_label" for="payment_card"><img src="{$SITE_PATH}" alt=""></label>
            </div>
        </div>

    </form>
</div>
