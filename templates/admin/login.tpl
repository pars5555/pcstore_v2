<form method="POST" action="{$SITE_PATH}/dyn/admin/do_login">
    <span>Username:</span><input  type="text" name="username"/>
    <span>Password:</span><input type="password" name="password"/>  
    {if isset($ns.error_message)}
            {$ns.error_message}
    {/if}  
    <input class="white-button" type="submit" />    
</form>