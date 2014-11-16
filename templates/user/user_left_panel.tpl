<div class="user-left-panel left-panel">
    <div id="sidebar-wrapper">
    	<div id="leftMenuBtn" class="left-menu-btn">
    	</div>
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
