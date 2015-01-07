<form class="upload_company_price" id="price_upload_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_price" autocomplete="off">
    <label class="input_label" for="company_price_file_input">{$ns.lm->getPhrase(67)}:</label>
    <input class="text up_selected_file_name" id="up_selected_file_name" type="text" disabled="" readonly="readonly" value="{$ns.lm->getPhrase(517)}"/>
    <input id="company_price_file_input" name="company_price"  type="file" style="display:none" />
    <input class="button blue select_price_btn glyphicon" type="button" id="select_price_file_button" value="" title="{$ns.lm->getPhrase(67)}"/>

    <input type="checkbox" name="merge_into_last_price" id ="merge_uploaded_price_into_last_price" value="1" />
    <label for="merge_uploaded_price_into_last_price">{$ns.lm->getPhrase(619)}: </label>
    <button class="button blue submit_upload_price" id="upload_company_price_button" title="{$ns.lm->getPhrase(95)}">{$ns.lm->getPhrase(95)} <span class="glyphicon"></span></button>
</form>
<iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;" ></iframe>

<a class="revert_last_com_price"  href="javascript:void(0);" id="revert_company_last_uploaded_price" company_id="{$ns.userId}" title="{$ns.lm->getPhrase(492)}"> 
    <span class="glyphicon"></span>
</a>
<a class="last_com_price"  href="{$SITE_PATH}/price/last_price/{$ns.userId}" title="{$ns.lm->getPhrase(68)}"> 
    <span>{$ns.lm->getPhrase(68)}</span>
    <span class="glyphicon"></span>
</a>
<div class="clear"></div>
<div id="send_price_email_container">
    <div class="sender_details">
        <label class="input_label" for="sender_email">{$ns.lm->getPhrase(614)}:</label>
        <input class="text sender_email" type="text" name='sender_email' type="text"  id="sender_email" value="{$ns.customer->getEmail()}" />
        <input class="text" type="text" name='sender_name' type="text"  disabled id="sender_name" value="{$ns.customer->getName()}" />
    </div>
    <div style="clear:both"> </div> 
    <div class="dealer_emails">
        <label class="input_label" for="dealer_emails_textarea">{$ns.lm->getPhrase(464)}:</label>
        <textarea class="text" name='dealer_emails' type="text" id="dealer_emails_textarea">{$ns.companyExProfileDto->getDealerEmails()}</textarea>                    
        <div class="dealers_count"><span id="total_price_email_recipients_number">{$ns.total_price_email_recipients_count}</span>{$ns.lm->getPhrase(613)}</div>
    </div>
    <div style="clear:both"> </div> 
    <div class="send_mail_title">
        <label class="input_label" for="price_email_subject">{$ns.lm->getPhrase(463)}</label>
        <input class="text" type="text" id="price_email_subject" value="{$ns.companyExProfileDto->getPriceEmailSubject()}"/>
    </div>

    <div style="clear:both"> </div> 
    <div class="price_email_container">
        <label class="input_label" for="price_email_body">{$ns.lm->getPhrase(465)}</label>
        <textarea name='price_email_body' type="text"  class="msgBodyTinyMCEEditor" id="price_email_body">{$ns.companyExProfileDto->getPriceEmailBody()}</textarea>
    </div>

    <div style="clear:both"> </div> 
    <a class="last_price_file" href="{$SITE_PATH}/price/last_price/{$ns.userId}">   
        <span class="glyphicon"></span>
        <span>{$ns.lm->getPhrase(466)}:</span>			     
    </a>

    <div style="clear:both"> </div> 

    <div class="attach_more">
        <a class="attach_more_btn" id="company_attach_new_file_button" type="button" ><span class="glyphicon"></span><span>{$ns.lm->getPhrase(615)}</span></a>
        <form id="up_add_attachment_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_attachment">
            <input id="company_attach_file_input" name="attachment"  type="file" style="display:none" />
        </form>
        <div class="attachment_element_container" id="company_email_attachments_container">
            <div class="attachment_element" id="attachment_element_hidden_div" style="display:none">
                <img style="max-width:32px;max-height:32px;vertical-align: middle"/>                               
                <div class="up_delete_attachment f_up_delete_attachment" ><span class="glyphicon"></span></div>
            </div>
        </div>
    </div>
    <div style="clear:both"> </div> 
    <div class="upload_price_actions">
        <a class="button blue" id="save_price_email" >{$ns.lm->getPhrase(43)}</a>         
        <a class="button blue" id="send_price_email" >{$ns.lm->getPhrase(48)}</a>     
    </div>
</div>

    <table class="all_prices">
    <thead>
        <tr>
            <th>{$ns.lm->getPhrase(60)}</th>
            <th>{$ns.lm->getPhrase(69)}</th>
            <th>{$ns.lm->getPhrase(70)}</th>

        </tr>
    </thead>
    <tbody>
        {foreach from=$ns.company_prices item=company_price name=cp}
            <tr>
                <td># {$smarty.foreach.cp.index+1}</td>
                <td><a href="{$SITE_PATH}/price/zipped_price_unzipped/{$company_price->getId()}"> 
                        <img src = "{$SITE_PATH}/img/zip_file_download.png"  alt="zip"/> </a>
                </td>
                <td >{$company_price->getUploadDateTime()}</td>
            </tr>
        {/foreach}
    </tbody>
</table>

