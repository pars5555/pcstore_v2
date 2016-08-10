
<div id="send_price_email_container" class="send_price_email_container">
    <div class="sender_details">
        <label class="input_label label" for="sender_email">{$ns.lm->getPhrase(614)}:</label>
        <input class="text sender_email" type="text" name='sender_email' type="text"  id="sender_email" value="{$ns.customer->getEmail()}" autocomplete="off"/>
        <input class="text" type="text" name='sender_name' type="text"  disabled id="sender_name" value="{$ns.customer->getName()}" />
    </div>
    <div style="clear:both"> </div> 
    <div class="dealer_emails">
        <label class="input_label label" for="dealer_emails_textarea">{$ns.lm->getPhrase(464)}:</label>
        <textarea class="text" name='dealer_emails' type="text" id="dealer_emails_textarea">{$ns.companyExProfileDto->getDealerEmails()}</textarea>                    
        <div class="dealers_count"><span id="total_price_email_recipients_number">{$ns.total_price_email_recipients_count}</span>{$ns.lm->getPhrase(613)}</div>
    </div>
    <div style="clear:both"> </div> 
    <div class="send_mail_title">
        <label class="input_label label" for="price_email_subject">{$ns.lm->getPhrase(463)}</label>
        <input class="text" type="text" id="price_email_subject" value="{$ns.companyExProfileDto->getPriceEmailSubject()}"/>
    </div>

    <div style="clear:both"> </div> 
    <div class="price_email_container">
        <label class="input_label label" for="price_email_body">{$ns.lm->getPhrase(465)}</label>
        <textarea name='price_email_body' type="text"  class="msgBodyTinyMCEEditor" id="price_email_body">{$ns.companyExProfileDto->getPriceEmailBody()}</textarea>
    </div>

    <div style="clear:both"> </div> 
    <a class="last_price_file" href="{$SITE_PATH}/price/last_price/{$ns.userId}">   
        <span class="glyphicon"></span>
    </a>
    <label for="attache_last_price">{$ns.lm->getPhrase(466)}:</label>			     
    <input id="attache_last_price" type="checkbox" checked autocomplete="off" />

    <div style="clear:both"> </div> 

    <div class="attach_more">
        <a class="attach_more_btn" id="company_attach_new_file_button" type="button" ><span class="glyphicon"></span><span>{$ns.lm->getPhrase(615)}</span></a>
        <form id="up_add_attachment_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_attachment">
            <input id="company_attach_file_input" name="attachment"  type="file" style="display:none" />
        </form>
        <iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;" ></iframe>
        <div class="attachment_element_container" id="company_email_attachments_container">
            <div class="attachment_element" id="attachment_element_hidden_div" style="display:none">
                <img style="max-width:32px;max-height:32px;vertical-align: middle"/>                               
                <label></label>
                <div class="up_delete_attachment f_up_delete_attachment" ><span class="glyphicon"></span></div>
            </div>
        </div>
    </div>
    <div style="clear:both"> </div> 
    <div class="upload_price_actions">
        <a class="button blue" id="save_price_email" >{$ns.lm->getPhrase(43)}</a>         
        <a class="button blue" id="send_price_email" >{$ns.lm->getPhrase(48)}</a>  
        <input id="error_send_price_email_title_text" type="hidden" value="{$ns.lm->getPhrase(583)}" />
        <input id="send_price_email_title_text" type="hidden" value="{$ns.lm->getPhrase(514)}" />
        <input id="send_price_email_send_text" type="hidden" value="{$ns.lm->getPhrase(573)}" />
        <input id="send_price_email_save_text" type="hidden" value="{$ns.lm->getPhrase(586)}" />
        <input id="send_price_email_done_btn" type="hidden" value="{$ns.lm->getPhrase(485)}" />
    </div>
</div>

