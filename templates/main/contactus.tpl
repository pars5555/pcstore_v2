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
                <p class="lead"><a target="_blank" href="https://www.google.com/maps/preview?ie=UTF-8&amp;q=The+Pentagon&amp;fb=1&amp;gl=us&amp;hq=1400+Defense+Pentagon+Washington,+DC+20301-1400&amp;cid=12647181945379443503&amp;ei=qmYfU4H8LoL2oATa0IHIBg&amp;ved=0CKwBEPwSMAo&amp;safe=on">PC STORE<br>
                        {$ns.lm->getPhrase(643)}</a><br>
                    {$ns.lm->getPhrase(12)}: {$ns.lm->getCmsVar('pcstore_sales_phone_number1')}<br>
                    {$ns.lm->getPhrase(309)}: {$ns.lm->getCmsVar('pcstore_sales_phone_number')}</p>
            </address>
        </div>
    </div>
</div>
