<div class="container_companies">

    <a class="button blue" href="{$SITE_PATH}/admin/companies/new">New Company</a>

    {if isset($ns.selectedCompanyDto)}
        <div class="admin_company_settings">
            <h1>{$ns.selectedCompanyDto->getName()}</h1>
            <form role="form" method="post" action="{$SITE_PATH}/dyn/company/do_update_profile" autocomplete="off">
                {if isset($ns.success_message)}
                    {$ns.success_message}
                {/if}
                {if isset($ns.error_message)}
                    {$ns.error_message}
                {/if}
                <label for="companyName">{$ns.lm->getPhrase(9)}</label>
                <input type="text"  id="companyName" name="name" placeholder="{$ns.lm->getPhrase(9)}" value="{$ns.selectedCompanyDto->getName()}">
                <label for="companyWebsite">{$ns.lm->getPhrase(11)}</label>
                <input type="url" id="companyWebsite" name="url" placeholder="{$ns.lm->getPhrase(11)}" value="{$ns.selectedCompanyDto->getUrl()}">
                <label for="companyDealersAccessKey">{$ns.lm->getPhrase(30)}</label>
                <input type="text" id="companyDealersAccessKey"  placeholder="{$ns.lm->getPhrase(30)}" name="access_key" value="{$ns.selectedCompanyDto->getAccessKey()}">
                <label for="companyPassword">{$ns.lm->getPhrase(4)}</label>
                <input type="text" id="companyDealersAccessKey"  placeholder="{$ns.lm->getPhrase(4)}" name="password" value="{$ns.selectedCompanyDto->getPassword()}">
                <label for="">Logo</label>
                <a id="upload_photo_button" class="button blue" href="javascript:void(0);">Select Logo...</a>
                {if isset($ns.hasLogo)}
                    <img id="logo_img" src="{$SITE_PATH}/images/big_logo/{$ns.selectedCompanyDto->getId()}/logo.png?{$smarty.now}" />
                {else}
                    <img id="logo_img" src="{$SITE_PATH}/img/camera_pic.png?{$smarty.now}" />
                {/if}
                <input type="hidden" id="change_company_logo" name="change_logo" value="0"/>
                <input type="hidden" name="company_id" value="{$ns.selectedCompanyDto->getId()}"/>
                <button type="submit" class="button blue" >Save</button>
            </form>
            <form id="logo_picture_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_logo" >        
                <input type="file" id="logo_picture" name="logo_picture" accept="image/*" style="display:none">
                <input type="hidden" name="company_id" value="{$ns.selectedCompanyDto->getId()}"/>
            </form>
            <iframe name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;"></iframe>

            <a class="button inline blue" href="{$SITE_PATH}/dyn/admin/do_change_company_hidden_block_attributes?company_id={$ns.selectedCompanyDto->getId()}&hidden={if $ns.selectedCompanyDto->getHidden()==1}0{else}1{/if}">{if $ns.selectedCompanyDto->getHidden()==1}Set Visible{else}Set Hidden{/if}</a>
            <a class="button inline blue" href="{$SITE_PATH}/dyn/admin/do_change_company_hidden_block_attributes?company_id={$ns.selectedCompanyDto->getId()}&blocked={if $ns.selectedCompanyDto->getBlocked()==1}0{else}1{/if}">{if $ns.selectedCompanyDto->getBlocked()==1}Unblock Company{else}Block Company{/if}</a>
            <a class="button inline blue" href="{$SITE_PATH}/dyn/admin/do_change_company_hidden_block_attributes?company_id={$ns.selectedCompanyDto->getId()}&passive={if $ns.selectedCompanyDto->getPassive()==1}0{else}1{/if}">{if $ns.selectedCompanyDto->getPassive()==1}Set Active{else}Set Passive{/if}</a>
        </div>
    {/if}


    <div class="table_striped admin_companies_list">
        <div class="table_header_group">
            <div class="table-row">
                <div class="table-cell">
                    Company logo
                </div>
                <div class="table-cell">
                    Company name
                </div>
            </div>
        </div>
        {foreach from=$ns.allCompaniesDtos item=companyDto}
            <a class="table-row" href="{$SITE_PATH}/admin/companies/{$companyDto->getId()}" style="{if isset($ns.selectedCompanyDto) && $ns.selectedCompanyDto->getId()==$companyDto->getId()}color:red{/if}">
                <span class="table-cell">
                    <img {if $companyDto->getPassive() == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/small_logo/{$companyDto->getId()}" alt="logo"/>
                </span>
                <span class="table-cell">
                    {$companyDto->getName()}
                </span>
            </a>
        {/foreach}
    </div>

</div>