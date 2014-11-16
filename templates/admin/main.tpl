<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file="$TEMPLATE_DIR/admin/util/headerControls.tpl"}
    </head>
    <body>
        <div class="wrapper">
            <input type="hidden" id="initialLoad" name="initialLoad" value="admin_main" />		
            <input type="hidden" id="contentLoad" value="{$ns.contentLoad}" />
            {include file="$TEMPLATE_DIR/admin/util/header.tpl"} 
            <div class="admin-panel-right-wrapper">
                {nest ns=content}
            </div>
            {include file="$TEMPLATE_DIR/admin/util/footer.tpl"} 
        </div>
    </body>
</html>