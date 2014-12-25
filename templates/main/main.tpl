<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file="$TEMPLATE_DIR/main/util/headerControls.tpl"}
    </head>    
    <body>
        <div id="fb-root"></div>
        {include file="$TEMPLATE_DIR/main/util/header.tpl"}       
        <div class="wrapper">
            {nest ns=content} 
        </div>
        {include file="$TEMPLATE_DIR/main/util/footer.tpl"}
        <input type="hidden" id="initialLoad" name="initialLoad" value="main" />
        <input type="hidden" id="contentLoad" value="{$ns.contentLoad}" />	
    </body>
</html>