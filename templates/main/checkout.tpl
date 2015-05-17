<div class="checkout-wrapper container">
    <a class="button blue back_to_cart" href="{$SITE_PATH}/cart"><span class="glyphicon"></span>{$ns.lm->getPhrase(678)}</a>
    
    <h3 class="main_title">{$ns.lm->getPhrase(281)}</h3>

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
    <form id="checkout_form"class="table" role="form" method="post" action="{$SITE_PATH}/dyn/main_checkout/do_confirm_order" autocomplete="off">
        <input type="hidden" value="" name="sms_confirm_code" id="sms_confirm_code"/>
        <div class="checkout_confirm_container" id="checkout_confirm_container">

            {****************Shipping Address Container******************}

            <div class="ship_addr_container f_ship_addr_container">
                <div class="form-group">
                    <div class="checkbox_container">
                        <div class="checkbox f_checkbox"></div>
                        <label class="checkbox_label f_checkbox_label label">{$ns.lm->getPhrase(297)}</label>
                        <input type="hidden" id="do_shipping" name="do_shipping"/>
                    </div>
                </div>
                <div class="ship_addr_form f_ship_addr_form" style="display:none;">

                    <div class="form-group">
                        <label class="input_label label" for="recipientName">{$ns.lm->getPhrase(293)}</label>
                        <input required="" type="text" class="text"  name= "recipient_name" id="recipientName" placeholder="{$ns.lm->getPhrase(293)}" />
                    </div>
                    <div class="form-group">
                        <label class="input_label label" for="shipAddr">{$ns.lm->getPhrase(13)}</label>
                        <input required="" type="text" class="text"  name= "ship_addr" id="shipAddr" placeholder="{$ns.lm->getPhrase(13)}" />
                    </div>
                    <div class="form-group">
                        <label class="input_label label" for="recipientName">{$ns.lm->getPhrase(45)}</label>
                        <div class="select_wrapper">
                            <select name="shipping_region" id="shipping_region">
                                {foreach from=$ns.regions_phrase_ids_array item=value key=key}
                                    <option value="{$ns.lm->getPhrase($value, 'en',1)}" {if $ns.default_selected_region == $ns.lm->getPhrase($value, 'en',1)}selected="selected"{/if}>{$ns.lm->getPhrase($value)}</option>
                                {/foreach}		
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="input_label label" for="shipCellTel">{$ns.lm->getPhrase(309)}</label>
                        <input required="" type="text" class="text"  name= "ship_cell_tel" id="shipCellTel" placeholder="{$ns.lm->getPhrase(309)}" />
                        <div>Բջջային հեռախոսի համարը պետք է լինի իրական և վավեր: Դուք կստանաք SMS այս համարին՝ պատվերը հաստատելու համար:</div>
                    </div>
                    <div class="form-group">
                        <label class="input_label label" for="shipTel">{$ns.lm->getPhrase(62)}</label>
                        <input required="" type="text" class="text"  name= "ship_tel" id="shipTel" placeholder="{$ns.lm->getPhrase(62)}" />
                    </div>

                </div>
            </div>


            {****************Payment Type Container******************}

            <h2 class="title">{$ns.lm->getPhrase(367)}</h2>
            <div class="payment_method_container">
                <div class="payment_type_container f_side_panel" id="payment_type" data-side-panel="payment-type" data-side-position="left"> 
                    {foreach from=$ns.payment_option_values item=paymentTypeValue key=index}
                        <div class="payment_type f_payment_type {if $paymentTypeValue === cash }active{/if}" for="payment_{$paymentTypeValue}" p_type="{$paymentTypeValue}">
                            <input {if $paymentTypeValue === cash }checked="checked"{/if} type="radio" class=""  name="payment_type" id="payment_{$paymentTypeValue}" value="{$paymentTypeValue}"/>
                            <img class="payment_img" src="{$SITE_PATH}/img/checkout/{$paymentTypeValue}.png" alt="{$paymentTypeValue}" />
                            <span class="label input_label payment_name">{$ns.lm->getPhrase($ns.payment_options_display_names_ids.$index)}</span>
                        </div>
                    {/foreach}
                </div>
                <div class="payment_details" id="payment_details"> 
                    
                </div>
            </div>

            <div class="checkout_confirm cart_checkout" id="checkout_confirm">
                {nest ns=calculation} 
            </div>
        </div>
    </form>
</div>

<div class="pop_up_container cell_phone_number_pop_up hide" id="cell_phone_number">
    <div class="overlay"></div>
    <form action="" autocomplete="off" id="receive_sms_form">
        <div class="pop_up">
            <div class="close_button"></div>
            <div class="pop_up_title">{$ns.lm->getPhrase(316)}</div>
            <p> {$ns.lm->getPhrase(362)}</p>
            <div class="form-group form-group-table">
                <label class="label input_label">
                    {$ns.lm->getPhrase(309)}
                </label>
                <input class="text" type="text" id="confirm_phone_number" />
            </div>
                <div class="error" style="display:none;"></div>
                <button class="button blue">{$ns.lm->getPhrase(317)}</button>
        </div>
    </form>
</div>

<div class="pop_up_container cell_phone_number_pop_up hide" id="cell_phone_number_confirm">
    <div class="overlay"></div>
    <form action="" autocomplete="off" id="confirm_code_form">
        <div class="pop_up">
            <div class="close_button"></div>
            <div class="pop_up_title">{$ns.lm->getPhrase(447)}</div>
            <p>{$ns.lm->getPhrase(319)}</p>
            <div class="form-group">
                <input class="text" type="text" id="confirm_code" />
                <div class="error" style="display:none;"></div>
                <button class="button blue">{$ns.lm->getPhrase(50)}</button>
            </div>
            <p>{$ns.lm->getPhrase(361)} {$ns.pcstore_contact_number}</p>
        </div>
    </form>
</div>