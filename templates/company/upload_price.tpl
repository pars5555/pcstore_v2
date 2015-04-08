<form class="upload_company_price" id="price_upload_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_price" autocomplete="off">
    <label class="input_label label" for="company_price_file_input">{$ns.lm->getPhrase(67)}:</label>
    <input class="text up_selected_file_name" id="up_selected_file_name" type="text" readonly="readonly" value="{$ns.lm->getPhrase(517)}"/>
    <input id="company_price_file_input" name="company_price"  type="file" style="display:none" />
    <input class="button blue select_price_btn glyphicon" type="button" id="select_price_file_button" value="" title="{$ns.lm->getPhrase(67)}"/>

    <input type="checkbox" name="merge_into_last_price" id ="merge_uploaded_price_into_last_price" value="1" />
    <label class="label" for="merge_uploaded_price_into_last_price">{$ns.lm->getPhrase(619)}: </label>
    <button class="button blue submit_upload_price" id="upload_company_price_button" title="{$ns.lm->getPhrase(95)}">{$ns.lm->getPhrase(95)} <span class="glyphicon"></span></button>
</form>
<iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;" ></iframe>

<a class="revert_last_com_price"  href="javascript:void(0);" id="revert_company_last_uploaded_price" company_id="{$ns.userId}" title="{$ns.lm->getPhrase(492)}"> 
    <span class="glyphicon"></span>

    <input class="f_revert_popup_title" value="{$ns.lm->getPhrase(483)}" type="hidden" />
    <input class="f_revert_popup_text" value="{$ns.lm->getPhrase(491)}" type="hidden" />
    <input class="f_revert_popup_yes" value="{$ns.lm->getPhrase(489)}" type="hidden" />
    <input class="f_revert_popup_cancel" value="{$ns.lm->getPhrase(49)}" type="hidden" />
</a>
<a class="last_com_price"  href="{$SITE_PATH}/price/last_price/{$ns.userId}" title="{$ns.lm->getPhrase(68)}"> 
    <span>{$ns.lm->getPhrase(68)}</span>
    <span class="glyphicon"></span>
</a>
<div class="clear"></div>
<table class="all_prices">
    <thead>
        <tr>
            {*            <th>{$ns.lm->getPhrase(60)}</th>*}
            <th>{$ns.lm->getPhrase(69)}</th>
            <th>{$ns.lm->getPhrase(70)}</th>

        </tr>
    </thead>
    <tbody>
        {foreach from=$ns.company_prices item=company_price name=cp}
            <tr>
                {*                <td># {$smarty.foreach.cp.index+1}</td>*}
                <td><a href="{$SITE_PATH}/price/zipped_price_unzipped/{$company_price->getId()}"> 
                        <img src = "{$SITE_PATH}/img/zip_file_download.png"  alt="zip"/> </a>
                </td>
                <td >{$company_price->getUploadDateTime()}</td>
            </tr>
        {/foreach}
    </tbody>
</table>

