<div class="company-profile-wrapper profile-wrapper">
	<div class="profile-main-content">
    {include file="$TEMPLATE_DIR/servicecompany/left_panel.tpl"}
    <div class="profile-content">
        <div class="current-user-info">
            <form role="form" method="post" action="{$SITE_PATH}/dyn/servicecompany/do_update_profile" autocomplete="off">
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
                <div class="form-group">
                    <label class="input_label" for="companyName">{$ns.lm->getPhrase(9)}</label>
                    <input type="text" class="  text" id="companyName" name="name" placeholder="{$ns.lm->getPhrase(9)}" value="{$ns.customer->getName()}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="companyWebsite">{$ns.lm->getPhrase(11)}</label>
                    <input type="url" class="  text" id="companyWebsite" name="url" placeholder="{$ns.lm->getPhrase(11)}" value="{$ns.customer->getUrl()}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="companyDealersAccessKey">{$ns.lm->getPhrase(30)}</label>
                    <input type="text" class="  text" id="companyDealersAccessKey"  placeholder="{$ns.lm->getPhrase(30)}" name="access_key" value="{$ns.customer->getAccessKey()}">
                </div>
                <div class="form-group" style="text-align: center">
                    <label class="input_label" for="change_logo">{$ns.lm->getPhrase(42)}</label>
                    <a class="button blue chang_pic" id="upload_photo_button" href="javascript:void(0);">Select Logo...</a>
                    {if isset($ns.hasLogo)}
                        <img id="logo_img" class="profile_pic" src="{$SITE_PATH}/images/service_big_logo/{$ns.customer->getId()}/logo.png?{$smarty.now}" />
                    {else}
                        <img id="logo_img" class="profile_pic" src="{$SITE_PATH}/img/camera_pic.png?{$smarty.now}" />
                    {/if}
                    <input type="hidden" id="change_company_logo" name="change_logo" value="0"/>
                </div>
                <button type="submit" class="profile_save_btn button blue">{$ns.lm->getPhrase(43)}</button>
            </form>
            <form id="logo_picture_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/servicecompany/do_upload_logo" >        
                <input type="file" id="logo_picture" name="logo_picture" accept="image/*" style="display:none">
            </form>
            <iframe name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;"></iframe>
        </div>
    </div>
    </div>
</div>
