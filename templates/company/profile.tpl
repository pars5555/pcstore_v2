<div class="company-profile-wrapper profile-wrapper container row">
    {include file="$TEMPLATE_DIR/company/company_left_panel.tpl"}
    <div class="profile-content row container">
        <div class="current-user-info col-md-8">
            <form role="form" method="post" action="{$SITE_PATH}/dyn/company/do_update_profile" autocomplete="off">
                {if isset($ns.success_message)}
                    <div class="alert alert-success">
                        <strong><span class="glyphicon"></span> {$ns.success_message}</strong>
                    </div>
                {/if}
                {if isset($ns.error_message)}
                    <div class="alert alert-danger">
                        <span class="glyphicon"></span><strong> {$ns.error_message}</strong>
                    </div>
                {/if}
                <div class="form-group">
                    <label for="companyName">{$ns.lm->getPhrase(9)}</label>
                    <input type="text" class="form-control" id="companyName" name="name" placeholder="{$ns.lm->getPhrase(9)}" value="{$ns.customer->getName()}">
                </div>
                <div class="form-group">
                    <label for="companyWebsite">{$ns.lm->getPhrase(11)}</label>
                    <input type="url" class="form-control" id="companyWebsite" name="url" placeholder="{$ns.lm->getPhrase(11)}" value="{$ns.customer->getUrl()}">
                </div>
                <div class="form-group">
                    <label for="companyDealersAccessKey">{$ns.lm->getPhrase(30)}</label>
                    <input type="text" class="form-control" id="companyDealersAccessKey"  placeholder="{$ns.lm->getPhrase(30)}" name="access_key" value="{$ns.customer->getAccessKey()}">
                </div>
                <div class="form-group">
                    <label for="">Company Logo</label>
                    <a class="btn btn-default btn-primary " id="upload_photo_button" href="javascript:void(0);">Select Logo...</a>
                    {if isset($ns.hasLogo)}
                        <img id="logo_img" src="{$SITE_PATH}/images/big_logo/{$ns.customer->getId()}/logo.png?{$smarty.now}" />
                    {else}
                        <img id="logo_img" src="{$SITE_PATH}/img/camera_pic.png?{$smarty.now}" />
                    {/if}
                    <input type="hidden" id="change_company_logo" name="change_logo" value="0"/>
                </div>
                <button type="submit" class="btn btn-default btn-primary center-block">Submit</button>
            </form>
            <form id="logo_picture_form" target="upload_target" enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/company/do_upload_logo" >        
                <input type="file" id="logo_picture" name="logo_picture" accept="image/*" style="display:none">
            </form>
            <iframe name="upload_target" style="width:0;height:0;border:0px solid #fff;display: none;"></iframe>
        </div>
    </div>
</div>
