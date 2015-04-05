<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file="$TEMPLATE_DIR/main/util/headerControls.tpl"}
    </head>    
    <body class="ctl_{$ns.contentLoad}">
        {include file="$TEMPLATE_DIR/main/util/header.tpl"}       
        <div class="wrapper {if $ns.contentLoad == 'main_home'}listing-{$ns.listing_cols}-col-wrapper{/if}">
                {nest ns=content} 
        </div>
        {include file="$TEMPLATE_DIR/main/util/footer.tpl"}
        <a style="visibility: hidden;position: fixed" href="https://plus.google.com/111746961998922666341" rel="publisher">Google+</a>
        <div id="fb-root"></div>
        <input type="hidden" id="initialLoad" name="initialLoad" value="main" />
        <input type="hidden" id="contentLoad" value="{$ns.contentLoad}" />	
    </body>
</html>