<header id="headerWrapper" class="navbar navbar-inverse hero" role="banner">
    <nav id="navMenu" class="navMenu" role="navigation">
        <ul class="navMenuList">
            {if $ns.contentLoad != "main_buildpc"}
                <li>
                    <a class="navMenu_item"  href="{$SITE_PATH}/buildpc"> {$ns.lm->getPhrase(226)} </a>
                </li>
            {/if}
            <li class="dropdown f_dropdown">
                <a id="lang_menu_btn" class="dropdown-toggle navMenu_item" href="javascript:void(0);">Languages</a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:void(0);" class="mainSetLanguage" lang="en"> <img src="{$SITE_PATH}/img/en_s.png" alt="">English</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="mainSetLanguage" lang="am"> <img src="{$SITE_PATH}/img/am_s.png" alt="">Armenian</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="mainSetLanguage" lang="ru"> <img src="{$SITE_PATH}/img/ru_s.png" alt="">Russian</a>
                    </li>
                </ul>
            </li>
            {if $ns.userLevel === $ns.userGroupsGuest}
                <li >
                    <a class="f_myModal_toggle navMenu_item" href="javascript:void(0);"> Sign in / Register </a>
                </li>
            {else}
                <li>
                    <a class="navMenu_item" href="{$SITE_PATH}/companies">{$ns.lm->getPhrase(494)}</a>
                </li>
                {if $ns.userLevel !== $ns.userGroupsAdmin}
                    <li>
                        <a class="navMenu_item" href="{$SITE_PATH}/cart"> {$ns.lm->getPhrase(278)} <span class="glyphicon"></span></a>
                    </li>
                {else}
                    <li>
                        <a class="navMenu_item" href="{$SITE_PATH}/admin" target="_blank">{$ns.lm->getPhrase(496)}</a>
                    </li>
                {/if}
                <li class="dropdown f_dropdown">
                    <a id="user_menu_btn" class="dropdown-toggle navMenu_item" href="javascript:void(0);"> {$ns.customer->getName()}
                        {if $ns.userLevel === $ns.userGroupsUser}
                            ({$ns.lm->getPhrase(434)}: {$ns.customer->getPoints()} Դր.)
                        {/if}</a>
                    <ul class="dropdown-menu">
                        {if $ns.userLevel === $ns.userGroupsUser}
                            <li>
                                <a href="{$SITE_PATH}/uprofile">{$ns.lm->getPhrase(94)}</a>
                            </li>
                            <li>
                                <a href="{$SITE_PATH}/uinvite">invite</a>
                            </li>
                        {/if}
                        {if $ns.userLevel === $ns.userGroupsCompany}
                            <li>
                                <a href="{$SITE_PATH}/cprofile">{$ns.lm->getPhrase(94)}</a>
                            </li>
                            <li>
                                <a href="{$SITE_PATH}/uploadprice">{$ns.lm->getPhrase(95)}</a>
                            </li>
                        {/if}
                        {if $ns.userLevel === $ns.userGroupsServiceCompany}
                            <li>
                                <a href="{$SITE_PATH}/scprofile">{$ns.lm->getPhrase(94)}</a>
                            </li>
                        {/if}
                        {if $ns.userLevel === $ns.userGroupsCompany}
                            <li>
                                <a href="{$SITE_PATH}/dealers">{$ns.lm->getPhrase(495)}</a>
                            </li>
                        {/if}
                        {if $ns.userLevel === $ns.userGroupsServiceCompany}
                            <li>
                                <a href="{$SITE_PATH}/scdealers">{$ns.lm->getPhrase(495)}</a>
                            </li>
                        {/if}
                        {if $ns.userLevel != $ns.userGroupsAdmin}
                            <li>
                                <a href="{$SITE_PATH}/orders">{$ns.lm->getPhrase(142)}</a>
                            </li>
                        {/if}
                        <li>
                            <a id="mainLogoutBtn" href="{$SITE_PATH}/dyn/main/do_logout">{$ns.lm->getPhrase(65)}</a>
                        </li>
                    </ul>
                </li>


                {*<li class="rel-block dropdown">
                <a class="dropdown-toggle glyphicon" href="javascript:void(0)"></a>
                <div class="dropdown-menu search_block">
                <div class="top-arrow"></div>
                <div class="input-group search_container">
                <form method="GET" action="{$SITE_PATH}" autocomplete="off">
                <input type="text" id="srch-term" name="st" placeholder="{$ns.lm->getPhrase(91)}" class="search_text form-control">
                <button type="submit" class="search_btn">
                <span class="glyphicon"></span>
                </button>
                </form>
                </div>
                </div>
                </li>*}

                {* Notifications Container *}

                <li class="notification f_dropdown" id="notification">
                    {*                    <span id="new_nots_count" class="new_nots_count">new</span>*}
                    <a id="notificationBtn" class="dropdown-toggle navMenu_item" href="javascript:void(0);">
                    </a>
                    <ul style="display: none;" id="notificationListWrapper" class="dropdown-menu nofitication-list-wrapper">
                        <li class="no_notifications">You have not notifications!</li>
                    </ul>
                </li>

                {* Notification Example *}

                <ul id="notification_example" class="hidden">
                    <li class="notification_block f_notification_block">
                        <a class="not_link f_not_link" href="javascript:void(0);">
                            <span class="nb_item not_icon f_not_icon">
                                <img src="" alt="">
                            </span>  
                            <span class="nb_item">
                                <span class="not_title f_not_title">

                                </span>  
                                <span class="not_date f_not_date">

                                </span>  
                            </span>  
                        </a>
                    </li>
                </ul>

            {/if}
            <li class="clear"></li>
        </ul>
        <div class="clear"></div>
    </nav>
    <div class="header_content">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a  href="{$SITE_PATH}" class="site_logo"> <img src="{$SITE_PATH}/img/pcstore_logo.png" alt=""> </a>
        <div class="search_block">
            <div class="search_container">
                <form action="{$SITE_PATH}" id="search_text_form" autocomplete="off" method="get">
                    <input type="text" id="srch-term" name="st" placeholder="{$ns.lm->getPhrase(91)}" class="search_text" value="{$ns.req.st|default:''}">
                    <button type="submit" class="search_btn">
                        
                    </button>
                    {if isset($ns.req.cid)}
                        <input type="hidden" name="cid" value="{$ns.req.cid}"/>
                    {/if}
                    {if $ns.contentLoad == "main_home"}
                        <input type="hidden" id="sort_by_input" name="s" value=""/>
                        <input type="hidden" id="selected_company_id_input" name='sci' value=""/>
                    {/if}
                </form>
            </div>
        </div>

    </div>
</header>
{if $ns.userLevel === $ns.userGroupsGuest}
    <div id="loginDialog"></div>
    <!-- Modal -->
    <div  class="modal myModal hide" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="overlay"></div>
        <div class="modal-content f_modal_content">
            <button class="close_button"></button>
            <div class="modal-body">
                <form class="modal_cols login-wrapper" id="mainLoginForm" role="form" autocomplete="off" method="POST" action="{$SITE_PATH}/dyn/main/do_login">
                    <div class="login-wrapper">
                        <h4 class="title">Sign in with your existing account</h4>
                        <div class="form-group">
                            <label class="input_label" for="mainLoginEmail">{$ns.lm->getPhrase(21)}</label>
                            <input name="email" type="email" class="  text" id="mainLoginEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label class="input_label" for="mainLoginPassword">{$ns.lm->getPhrase(4)}</label>
                            <input name="password" type="password" class="  text" id="mainLoginPassword" placeholder="{$ns.lm->getPhrase(4)}">
                            <a id="forgot_pass" class="forget_pass" href="#" data-toggle="modal" data-target="#forgotModal" >Forgot Your Password?</a>
                        </div>
                        <div style="color:#de4c34;" class="error"></div>
                        <div class="login-buttons">
                            <input id="mainLoginBtn" type="submit" class="login_button blue button" value="{$ns.lm->getPhrase(1)}"/>
                        </div>
                    </div>
                </form>
                <div class="modal_cols">
                    <div class="social-network-wrapper">
                        <h4 class="title">Sign in with your social network</h4>
                        <div class="social-network">
                            <a class="facebook" href="javascript:void(0);" id="facebookLoginBtn" > <img src="{$SITE_PATH}/img/facebook.png" alt=""/> sign in with facebook </a>
                            <a class="linkedin" id="linkedinLoginBtn" href="javascript:void(0);"> <img src="{$SITE_PATH}/img/linkedin.png" alt="" /> sign in with linkedin </a>
                            <a class="google" id="googleLoginBtnid" href="javascript:void(0);"> <img src="{$SITE_PATH}/img/googleplus.png" alt="" /> sign in with google </a>
                        </div>
                    </div>
                </div>
                <div class="modal_cols create-account-wrapper">
                    <h4 class="title">Create your own account</h4>
                    <p>
                        It's fast, easy and personalized!
                    </p>
                    <ul>
                        <li>
                            Save billing & shipping info for Express Checkout
                        </li>
                        <li>
                            Follow favorite brands & hosts
                        </li>
                        <li>
                            Get product tips & extras
                        </li>
                        <li>
                            Customize settings & track purchases
                        </li>
                    </ul>
                    <div class="create-account-wrapper">
                        <a href="{$SITE_PATH}/signup" class="registration blue button">{$ns.lm->getPhrase(5)}</a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div  class="modal forgotModal hide" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="overlay"></div>
        <div class="modal-content">
            <button class="close_button"></button>
            <div class="modal-body">
                <div class="form-group">
                    <div id="forgotPasswordErrorMessage" calss="error"></div>
                    <div id="forgotPasswordSuccessMessage" calss="success"></div>
                    <label class="input_label" for="email">Your Email Address</label>
                    <form id="forgotPasswordForm" autocomplete="off">
                        <input name="email" type="email" class="  text" id="forgotPasswordEmailInput" placeholder="Enter email">
                        <button class="send_pass button blue" id="forgotPasswordBtn">
                            Send
                        </button>
                        <p>
                            we'll send you email with your password
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}

<div id="mainPopup" class="pop_up_container main_pop_up">
    <div class="overlay"></div>
    <div class="pop_up">
        <div class="close_button"></div>
        <h3 class="pop_up_title f_pop_up_title"></h3>
        <div class="pop_up_content f_pop_up_content">

        </div>
        <div class="f_pop_up_button button blue"></div>
    </div>
</div>

<div class="main_loader hidden" id="main_loader"></div>