<div class="container_newsletter">
    {if isset($ns.error_message)}
        {$ns.error_message}
    {/if}
    {if isset($ns.success_message)}
        {$ns.success_message}
    {/if}
    <div class="price_email_container">
        <label class="input_label label" for="price_email_body">{$ns.lm->getPhrase(465)}</label>
        <textarea name='price_email_body' type="text"  class="msgBodyTinyMCEEditor" id="sc_newsletter_html" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>
    </div>
    <div id="nl_newsletter_title"></div>
    <a  href="javascript:void(0);" style="float: right" id="admin_send_newsletter_btn">Send</a>
    <a  href="javascript:void(0);" style="float: right" id="admin_test_newsletter_btn">Test</a>
    <a  href="javascript:void(0);" id="admin_load_newsletter_btn">Load</a>
    <a  href="javascript:void(0);" id="admin_save_newsletter_btn">Save</a>
    <a  href="javascript:void(0);" id="admin_manage_newsletter_btn">Manage</a>

    <div class="pop_up_container hide">
        <div class="overlay"></div>
        <div class="pop_up"  id="save_load_manage_popups_container">
        </div>
    </div>
</div>