<div class="user-left-panel left-panel">
    	<!-- <div id="leftMenuBtn" class="left-menu-btn">  -->
    	<div class="left-panel_content">
    		<h1>Profile Settings</h1>
        <ul class="sidebar-nav">
            <li>
                <a href="{$SITE_PATH}/uprofile">
                	<span class="cat_name">{$ns.lm->getPhrase(94)}</span>
                </a>
            </li>
            {if $ns.customer->getLoginType()=='pcstore'}
                <li>
                    <a href="{$SITE_PATH}/uchangepass">
                    	<span class="cat_name">{$ns.lm->getPhrase(27)}</span>
                    </a>
                </li>
            {/if}
        </ul>
    </div>
</div>
