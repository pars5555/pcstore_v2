<div class="container">
        <div class="sign_up_wrapper">
            <form role="form" method="post" action="{$SITE_PATH}/dyn/main/do_signup" autocomplete="off">
                {if isset($ns.success_message)}
                    <div class="alert alert-success">
                        <strong class="success"> {$ns.success_message}</strong>
                    </div>
                {/if}
                {if isset($ns.error_message)}
                    <div class="alert alert-danger">
                        <strong class="error"> {$ns.error_message}</strong>
                    </div>
                {/if}
                <h4 class="title">Create account</h4>
                <div class="form-group">
                    <label class="input_label" for="sign_up_first_name_input">First Name</label>
                    <input required="" id="sign_up_first_name_input" type="text" class="text" placeholder="First Name" name="first_name" value="{$ns.req.first_name|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="sign_up_last_name_input">Last Name</label>
                    <input required="" id="sign_up_last_name_input" type="text" class="text" placeholder="Last Name" name="last_name" value="{$ns.req.last_name|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="sign_up_phone_input">Phone</label>
                    <input id="sign_up_phone_input" type="text" class="text" placeholder="Phone" name="phone"  value="{$ns.req.phone|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="sign_up_email_address_input">Email address</label>
                    <input required="" id="sign_up_email_address_input" type="email" placeholder="Enter email" class="text" name="email"  value="{$ns.req.email|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="sign_up_password_input">Password</label>
                    <input required="" id="sign_up_password_input" type="password" placeholder="Password" class="text" name="password"  value="{$ns.req.password|default:''}">
                </div>
                <div class="form-group">
                    <label class="input_label" for="sign_up_confirm_password_input">Confirm Password</label>
                    <input required="" id="sign_up_confirm_password_input" type="password" placeholder="Password" class="text" name="repeat_password"  value="{$ns.req.repeat_password|default:''}">
                </div>
                <div class="login-buttons">
                    <input class="button blue" type="submit" value="{$ns.lm->getPhrase(78)}"/>
                </div>
            </form>
        </div>
</div>