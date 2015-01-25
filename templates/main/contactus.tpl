<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {if isset($ns.success_message)}
                        <div class="alert alert-success"><strong><span class="glyphicon glyphicon-send"></span> {$ns.success_message}</strong></div>	  
                    {/if}
                    {if isset($ns.error_message)}
                        <div class="alert alert-danger"><span class="glyphicon glyphicon-alert"></span><strong> {$ns.error_message}</strong></div>
                    {/if}
                </div>
                <form method="post" action="{$SITE_PATH}/dyn/main/do_contact_us" role="form">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="InputName">Your Name</label>
                            <div class="input-group">
                                <input type="text" required="" placeholder="Enter Name" id="InputName" name="name" class=" " value='{$ns.req.name|default:""}'>
                                <span class="input-group-addon"><i style="margin-top:-25px; margin-right:-5px;" class="glyphicon glyphicon-ok form-control-feedback"></i></span></div>
                        </div>
                        <div class="form-group">
                            <label for="InputEmail">Your Email</label>
                            <div class="input-group">
                                <input type="email" required="" placeholder="Enter Email" name="email" id="InputEmail" class=" " value='{$ns.req.email|default:""}'>
                                <span class="input-group-addon"><i style="margin-top:-25px; margin-right:-5px;" class="glyphicon glyphicon-ok form-control-feedback"></i></span></div>
                        </div>
                        <div class="form-group">
                            <label for="InputMessage">Message</label>
                            <div class="input-group">
                                <textarea required="" rows="5" class=" " id="InputMessage" name="msg">{$ns.req.msg|default:""}</textarea>
                                <span class="input-group-addon"><i style="margin-right:-5px;" class="glyphicon glyphicon-ok form-control-feedback"></i></span></div>
                        </div>
                        <input type="submit" class="btn btn-info pull-right" value="Submit" id="submit" name="submit">
                    </div>
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

    </div>
</div>
