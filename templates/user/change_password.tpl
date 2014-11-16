<div class="user-profile-wrapper profile-wrapper container row">
    {include file="$TEMPLATE_DIR/user/user_left_panel.tpl"}
    <div class="profile-content row container">
        <div class="current-user-info col-md-8">
            <form role="form" method="post" action="{$SITE_PATH}/dyn/user/do_change_password" autocomplete="off">
            	{if isset($ns.success_message)}
                    <div class="alert alert-success">
                        <strong><span class="glyphicon glyphicon-send"></span> {$ns.success_message}</strong>
                    </div>
                {/if}
                {if isset($ns.error_message)}
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-alert"></span><strong> {$ns.error_message}</strong>
                    </div>
                {/if}
                <div class="form-group">
                    <label for="password">{$ns.lm->getPhrase(4)}</label>
                    <input type="password" class="form-control"  name= "password" id="password" placeholder="{$ns.lm->getPhrase(4)}">
                </div>
                <div class="form-group">
                    <label for="new_password">{$ns.lm->getPhrase(28)}</label>
                    <input type="password" class="form-control"  name= "new_password" id="new_password" placeholder="{$ns.lm->getPhrase(28)}">
                </div>
                <div class="form-group">
                    <label for="repeat_new_password">{$ns.lm->getPhrase(29)}</label>
                    <input type="password" class="form-control"  name= "repeat_new_password" id="repeat_new_password" placeholder="{$ns.lm->getPhrase(29)}">
                </div>
                
                <button style="width:100%;" class="btn btn-default btn-primary center-block">{$ns.lm->getPhrase(4)}</button>
            </form>
        </div>
    </div>
</div>
