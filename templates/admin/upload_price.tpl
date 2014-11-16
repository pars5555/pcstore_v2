{include file="$TEMPLATE_DIR/admin/left_panel.tpl"} 

{foreach from=$ns.allCompaniesDtos item=companyDto}
    <a href="{$SITE_PATH}/admin/uploadprice/{$companyDto->getId()}" style="{if isset($ns.selectedCompanyDto) && $ns.selectedCompanyDto->getId()==$companyDto->getId()}color:red{/if}">
        <img {if $companyDto->getPassive() == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/small_logo/{$companyDto->getId()}" alt="logo"/>
        {$companyDto->getName()}
    </a>
{/foreach}


{if isset($ns.selectedCompanyDto)}
    <h1>{$ns.selectedCompanyDto->getName()}</h1>
    <form id="price_upload_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_price" autocomplete="off">
        {$ns.lm->getPhrase(67)}:
        <input id="up_selected_file_name" type="text" readonly="readonly" value="{$ns.lm->getPhrase(517)}"/>
        <input id="company_price_file_input" name="company_price"  type="file" style="display:none" />
        <input type="button" id ="select_price_file_button" value="..."/>
        <label for="merge_uploaded_price_into_last_price">{$ns.lm->getPhrase(619)}: </label>
        <input type="checkbox" name="merge_into_last_price" id ="merge_uploaded_price_into_last_price" value="1" />
        <button id ="upload_company_price_button">{$ns.lm->getPhrase(95)}</button>
        <input type="hidden" name="company_id" value="{$ns.selectedCompanyDto->getId()}"/>
    </form>
    <iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;" ></iframe>

    <a  href="{$SITE_PATH}/price/last_price/{$ns.selectedCompanyDto->getId()}"> 
        {$ns.lm->getPhrase(68)}:
        <img src = "{$SITE_PATH}/img/document.png"  alt="document"/> 
    </a>
    <a  href="javascript:void(0);" id="revert_company_last_uploaded_price" company_id="{$ns.selectedCompanyDto->getId()}"> 
        <div title="{$ns.lm->getPhrase(492)}">
            <img src = "{$SITE_PATH}/img/revert_48x48.png"  alt="revert"/> 				
        </div>
    </a>



    <table>
        <thead>
            <tr>
                <th>{$ns.lm->getPhrase(60)}</th>
                <th>{$ns.lm->getPhrase(69)}</th>
                <th>{$ns.lm->getPhrase(70)}</th>
                <th>delete</th>

            </tr>
        </thead>
        <tbody>
            {foreach from=$ns.company_prices item=company_price name=cp}
                <tr>
                    <td>{$smarty.foreach.cp.index+1}</td>
                    <td><a href="{$SITE_PATH}/price/zipped_price_unzipped/{$company_price->getId()}"> 
                            <img src = "{$SITE_PATH}/img/zip_file_download.png"  alt="zip"/> </a>
                    </td>
                    <td>{$company_price->getUploadDateTime()}</td>
                    <th><a href="{$SITE_PATH}/dyn/admin/do_remove_company_price?price_id={$company_price->getId()}">delete</a></th>
                </tr>
            {/foreach}
        </tbody>
    </table>


{/if}