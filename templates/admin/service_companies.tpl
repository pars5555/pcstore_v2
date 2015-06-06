<div class="container_service_companies">

    <a href="{$SITE_PATH}/admin/scompanies/new">New Company</a>

    {foreach from=$ns.allCompaniesDtos item=companyDto}
        <a href="{$SITE_PATH}/admin/scompanies/{$companyDto->getId()}" style="{if isset($ns.selectedCompanyDto) && $ns.selectedCompanyDto->getId()==$companyDto->getId()}color:red{/if}">
            <img {if $companyDto->getPassive() == 1} class="grayscale"{/if} src="{$SITE_PATH}/images/sc_small_logo/{$companyDto->getId()}" alt="logo"/>
            {$companyDto->getName()}
        </a>
    {/foreach}

    {if isset($ns.selectedCompanyDto)}
        <h1>{$ns.selectedCompanyDto->getName()}</h1>
        <form role="form" method="post" action="{$SITE_PATH}/dyn/servicecompany/do_update_profile" autocomplete="off">
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
            <label for="companyPassword">{$ns.lm->getPhrase(4)}</label>
            <input type="text" id="companyDealersAccessKey"  placeholder="{$ns.lm->getPhrase(4)}" name="password" value="{$ns.selectedCompanyDto->getPassword()}">
            <label for="">Logo</label>
            <a id="upload_photo_button" href="javascript:void(0);">Select Logo...</a>
            {if isset($ns.hasLogo)}
                <img id="logo_img" src="{$SITE_PATH}/images/sc_big_logo/{$ns.selectedCompanyDto->getId()}/logo.png?{$smarty.now}" />
            {else}
                <img id="logo_img" src="{$SITE_PATH}/img/camera_pic.png?{$smarty.now}" />
            {/if}
            <input type="hidden" id="change_company_logo" name="change_logo" value="0"/>
            <input type="hidden" name="company_id" value="{$ns.selectedCompanyDto->getId()}"/>
            <button type="submit" >Save</button>
        </form>
        <form id="logo_picture_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/servicecompany/do_upload_logo" >        
            <input type="file" id="logo_picture" name="logo_picture" accept="image/*" style="display:none">
            <input type="hidden" name="company_id" value="{$ns.selectedCompanyDto->getId()}"/>
        </form>
        <iframe name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;"></iframe>

        <a href="{$SITE_PATH}/dyn/admin/do_change_service_company_block_has_price_attributes?company_id={$ns.selectedCompanyDto->getId()}&has_price={if $ns.selectedCompanyDto->getHasPrice()==1}0{else}1{/if}">{if $ns.selectedCompanyDto->getHasPrice()==1}Set Has Not Price{else}Set Has Price{/if}</a>
        <a href="{$SITE_PATH}/dyn/admin/do_change_service_company_block_has_price_attributes?company_id={$ns.selectedCompanyDto->getId()}&blocked={if $ns.selectedCompanyDto->getBlocked()==1}0{else}1{/if}">{if $ns.selectedCompanyDto->getBlocked()==1}Unblock Company{else}Block Company{/if}</a>
    {/if}
</div>