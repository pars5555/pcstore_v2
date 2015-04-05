<div class="container">
    <div class="contact_us_wrapper">
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
        <form method="post" action="{$SITE_PATH}/dyn/main/do_contact_us" role="form">
            <div class="form-group">
                <label class="input_label label" for="exampleInputEmail1">First Name</label>
                <input type="text" class="text" required="" placeholder="First Name" name="first_name" value="{$ns.req.first_name|default:''}">
            </div>
            <div class="form-group">
                <label class="input_label label" for="InputName">Your Name</label>
                <input type="text" required="" placeholder="Enter Name" id="InputName" name="name" class="text" value='{$ns.req.name|default:""}'>
            </div>
            <div class="form-group">
                <label class="input_label label" for="InputEmail">Your Email</label>
                <input type="email" required="" placeholder="Enter Email" name="email" id="InputEmail" class="text" value='{$ns.req.email|default:""}'>
            </div>
            <div class="form-group">
                <label class="input_label label" for="InputMessage">Message</label>
                <textarea required="" rows="5" class="text" id="InputMessage" name="msg">{$ns.req.msg|default:""}</textarea>
            </div>
            <input type="submit" class="button blue" value="Submit" id="submit" name="submit">
        </form>
        <hr class="featurette-divider hidden-lg">
        <div class="col-lg-5 col-md-push-1">
            <address>
                <h3>Office Location</h3>
                <p class="lead">
                    <a target="_blank" href="https://www.google.com/maps/dir//49+Komitas+Ave,+Yerevan+0014,+%D0%90%D1%80%D0%BC%D0%B5%D0%BD%D0%B8%D1%8F/@40.2062561,44.5183635,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x406abd35dfe155cd:0xe0e03bca043244e6!2m2!1d44.5157627!2d40.2070932">PC STORE<br>
                        {$ns.lm->getPhrase(643)}</a><br>
                        {$ns.lm->getPhrase(12)}: <a href="tel:{$ns.lm->getCmsVar('pcstore_sales_phone_number1')}"> {$ns.lm->getCmsVar('pcstore_sales_phone_number1')}</a><br>
                    {$ns.lm->getPhrase(309)}:  <a href="tel:{$ns.lm->getCmsVar('pcstore_sales_phone_number')}">{$ns.lm->getCmsVar('pcstore_sales_phone_number')}</a>
                </p>
            </address>
        </div>
    </div>
</div>
