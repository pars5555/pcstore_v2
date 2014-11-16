<form id="price_upload_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_price" autocomplete="off">
    {$ns.lm->getPhrase(67)}:
    <input id="up_selected_file_name" type="text" readonly="readonly" value="{$ns.lm->getPhrase(517)}"/>
    <input id="company_price_file_input" name="company_price"  type="file" style="display:none" />
    <input type="button" id ="select_price_file_button" value="..."/>
    <label for="merge_uploaded_price_into_last_price">{$ns.lm->getPhrase(619)}: </label>
    <input type="checkbox" name="merge_into_last_price" id ="merge_uploaded_price_into_last_price" value="1" />
    <button id ="upload_company_price_button">{$ns.lm->getPhrase(95)}</button>
</form>
<iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;" ></iframe>

<a  href="{$SITE_PATH}/price/last_price/{$ns.userId}"> 
    {$ns.lm->getPhrase(68)}:
    <img src = "{$SITE_PATH}/img/document.png"  alt="document"/> 
</a>
<a  href="javascript:void(0);" id="revert_company_last_uploaded_price" company_id="{$ns.userId}"> 
    <div title="{$ns.lm->getPhrase(492)}">
        <img src = "{$SITE_PATH}/img/revert_48x48.png"  alt="revert"/> 				
    </div>
</a>
<div id="send_price_email_container">
    {$ns.lm->getPhrase(614)}
    <input type="text" name='sender_email' type="text"  id="sender_email" value="{$ns.customer->getEmail()}" />
    <input type="text" name='sender_name' type="text"  disabled id="sender_name" value="{$ns.customer->getName()}" />

    <div style="clear:both"> </div> 
    {$ns.lm->getPhrase(464)}
    <textarea name='dealer_emails' type="text" id="dealer_emails_textarea">{$ns.companyExProfileDto->getDealerEmails()}</textarea>                    
    <span id="total_price_email_recipients_number">{$ns.total_price_email_recipients_count}</span> {$ns.lm->getPhrase(613)}

    <div style="clear:both"> </div> 
    {$ns.lm->getPhrase(463)}
    <input type="text" id="price_email_subject" value="{$ns.companyExProfileDto->getPriceEmailSubject()}"/>

    <div style="clear:both"> </div> 
    {$ns.lm->getPhrase(465)}
    <textarea name='price_email_body' type="text"  class="msgBodyTinyMCEEditor" id="price_email_body">{$ns.companyExProfileDto->getPriceEmailBody()}</textarea>

    <div style="clear:both"> </div> 
    <a  href="{$SITE_PATH}/price/last_price/{$ns.userId}">        
        <img src = "{$SITE_PATH}/img/document.png"  alt="document"/> 
        {$ns.lm->getPhrase(466)}:				
    </a>


    <div id="company_email_attachments_container" style="margin-top:5px;padding:10px">
        <div id="attachment_element_hidden_div" style="clear:both;display: none">
            <img style="max-width:32px;max-height:32px;vertical-align: middle"/>                               
            <div class="up_delete_attachment f_up_delete_attachment" ></div>
        </div>
    </div>

    <div style="clear:both"> </div> 

    {$ns.lm->getPhrase(615)}
    <a id="company_attach_new_file_button" type="button" >...</a>
    <form id="up_add_attachment_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_attachment">
        <input id="company_attach_file_input" name="attachment"  type="file" style="display:none" />
    </form>

    <div style="clear:both"> </div> 

    <a id="save_price_email" >{$ns.lm->getPhrase(43)}</a>         
    <a id="send_price_email" >{$ns.lm->getPhrase(48)}</a>         
</div>

<table>
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
                <td>{$smarty.foreach.cp.index+1}</td>
                <td><a href="{$SITE_PATH}/price/zipped_price_unzipped/{$company_price->getId()}"> 
                        <img src = "{$SITE_PATH}/img/zip_file_download.png"  alt="zip"/> </a>
                </td>
                <td >{$company_price->getUploadDateTime()}</td>
            </tr>
        {/foreach}
    </tbody>
</table>

