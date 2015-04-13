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
        <form method="post" action="{$SITE_PATH}/dyn/main/do_contact_us" enctype="multipart/form-data" method="post" autocomplete="off">
            <div class="form-group">
                <label class="input_label label" for="InputName">{$ns.lm->getPhrase(74)}</label>
                <input type="text" required="" placeholder="Enter Name" id="InputName" name="name" class="text" value='{$ns.req.name|default:""}'>
            </div>
            <div class="form-group">
                <label class="input_label label" for="InputEmail">{$ns.lm->getPhrase(47)}</label>
                <input type="email" required="" placeholder="Enter Email" name="email" id="InputEmail" class="text" value='{$ns.req.email|default:""}'>
            </div>
            <div class="form-group">
                <label class="input_label label" for="InputMessage">{$ns.lm->getPhrase(465)}</label>
                <textarea required="" rows="5" class="text" id="InputMessage" name="msg">{$ns.req.msg|default:""}</textarea>
            </div>
            <div class="form-group">
                <label class="input_label label" for="attachment_file_input">{$ns.lm->getPhrase(680)}</label>
                <input id="attachment_file_input" name="attachment"  type="file" />
            </div>
            <input type="submit" class="button blue" value="Submit" id="submit" name="submit">
        </form>
        <hr class="featurette-divider hidden-lg">
        <div class="col-lg-5 col-md-push-1">
            <address>
                <p class="lead">
                    <a target="_blank" href="https://www.google.com/maps/dir//49+Komitas+Ave,+Yerevan+0014,+%D0%90%D1%80%D0%BC%D0%B5%D0%BD%D0%B8%D1%8F/@40.2062561,44.5183635,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x406abd35dfe155cd:0xe0e03bca043244e6!2m2!1d44.5157627!2d40.2070932">PCSTORE<br>
                        {$ns.lm->getPhrase(643)}</a><br>
                    {$ns.lm->getPhrase(12)}: <a href="tel:{$ns.lm->getCmsVar('pcstore_sales_phone_number1')}"> {$ns.lm->getCmsVar('pcstore_sales_phone_number1')}</a><br>
                    {$ns.lm->getPhrase(309)}:  <a href="tel:{$ns.lm->getCmsVar('pcstore_sales_phone_number')}">{$ns.lm->getCmsVar('pcstore_sales_phone_number')}</a>
                </p>
            </address>
        </div>
    </div>
</div>
