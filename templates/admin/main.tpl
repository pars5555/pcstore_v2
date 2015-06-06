<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file="$TEMPLATE_DIR/admin/util/headerControls.tpl"}
    </head>
    <body class="ctl_{$ns.contentLoad}">
        {include file="$TEMPLATE_DIR/admin/util/header.tpl"} 
        <div class="wrapper">
            <input type="hidden" id="initialLoad" name="initialLoad" value="admin_main" />		
            <input type="hidden" id="contentLoad" value="{$ns.contentLoad}" />
            <div class="admin-panel-right-wrapper">
                {include file="$TEMPLATE_DIR/admin/main_content.tpl"} 
            </div>
        </div>
        {include file="$TEMPLATE_DIR/admin/util/footer.tpl"} 
    </body>
</html>