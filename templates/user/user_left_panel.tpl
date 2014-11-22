<div class="user-left-panel left-panel">
    	<!-- <div id="leftMenuBtn" class="left-menu-btn">  -->
    	<div class="left-panel_content">
    		<h1>Profile Settings</h1>
        <ul class="sidebar-nav">
            <li>
                <a href="{$SITE_PATH}/uprofile">{$ns.lm->getPhrase(94)}</a>
            </li>
            {if $ns.customer->getLoginType()=='pcstore'}
                <li>
                    <a href="{$SITE_PATH}/uchangepass">{$ns.lm->getPhrase(27)}</a>
                </li>
            {/if}
        </ul>
    </div>
</div>
