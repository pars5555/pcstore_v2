<header id="headerWrapper" class="navbar navbar-inverse hero" role="banner">
    <nav id="navMenu" class="navMenu" role="navigation">
        <ul class="navMenuList">
            {if $ns.userLevel === $ns.userGroupsAdmin}
                <li>
                    <input type="checkbox" id="chat_on_off"/>
                </li>
            {/if}
            {if $ns.contentLoad != "main_buildpc"}
                <li>
                    <a class="navMenu_item"  href="{$SITE_PATH}/buildpc"> {$ns.lm->getPhrase(226)} </a>
                </li>
            {/if}
            <li class="dropdown f_dropdown">
                <a id="lang_menu_btn" class="dropdown_toggle f_dropdown_toggle navMenu_item" href="javascript:void(0);">Languages</a>
                <ul class="dropdown_menu f_dropdown_menu">
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
                    <a id="user_menu_btn" class="dropdown_toggle f_dropdown_toggle navMenu_item" href="javascript:void(0);">
                        {$ns.customer->getName()}
                        {if $ns.userLevel === $ns.userGroupsUser}
                            ({$ns.lm->getPhrase(434)}: {$ns.customer->getPoints()} Դր.)
                        {/if}
                    </a>
                    <ul class="dropdown_menu f_dropdown_menu">
                        {if $ns.userLevel === $ns.userGroupsUser}
                            <li>
                                <a href="{$SITE_PATH}/uprofile">{$ns.lm->getPhrase(94)}</a>
                            </li>
                            <li>
                                <a href="{$SITE_PATH}/uinvite">{$ns.lm->getPhrase(139)}</a>
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
                <a class="dropdown_toggle f_dropdown_toggle glyphicon" href="javascript:void(0)"></a>
                <div class="dropdown_menu f_dropdown_menu search_block">
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
                    <a id="notificationBtn" class="dropdown_toggle f_dropdown_toggle navMenu_item" href="javascript:void(0);">
                    </a>
                    <ul style="display: none;" id="notificationListWrapper" class="dropdown_menu f_dropdown_menu nofitication-list-wrapper">
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



                    {if $ns.contentLoad == "main_home"}
                        {if isset($ns.req.cid)}
                            <input type="hidden" name="cid" value="{$ns.req.cid}"/>
                        {/if}
                        {if isset($ns.req.scpids)}
                            <input type="hidden" name="scpids" value="{$ns.req.scpids}"/>
                        {/if}
                        {if isset($ns.req.sci)}
                            <input type="hidden" id="selected_company_id_input" name='sci' value="{$ns.req.sci}"/>
                        {/if}
                        {if isset($ns.req.s)}
                            <input type="hidden" id="sort_by_input" name="s" value="{$ns.req.s}"/>
                        {/if}
                        {if isset($ns.req.shv)}
                        <input type="hidden" id="show_only_vat_items_checkbox" name='shv' value="{$ns.req.shv}"/>
                        {/if}
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
                            <label class="input_label label" for="mainLoginEmail">{$ns.lm->getPhrase(21)}</label>
                            <input name="email" type="email" class="  text" id="mainLoginEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label class="input_label label" for="mainLoginPassword">{$ns.lm->getPhrase(4)}</label>
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
                    <div class="social-login-wrapper">
                        <h4 class="title">Sign in with your social network</h4>
                        <div class="social-login">
                            <a class="facebook social-login-link" href="javascript:void(0);" id="facebookLoginBtn" > <img src="{$SITE_PATH}/img/facebook.png" alt=""/> sign in with facebook </a>
                            <a class="linkedin social-login-link" id="linkedinLoginBtn" href="javascript:void(0);"> <img src="{$SITE_PATH}/img/linkedin.png" alt="" /> sign in with linkedin </a>
                            <div class="google social-login-link" id="googleLoginBtn" > <img src="{$SITE_PATH}/img/googleplus.png" alt="" /> sign in with google </div>
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
        <div class="modal-content f_modal_content">
            <button class="close_button"></button>
            <div class="modal-body">
                <div class="form-group">
                    <div id="forgotPasswordErrorMessage" class="error"></div>
                    <div id="forgotPasswordSuccessMessage" class="success"></div>
                    <label class="input_label label" for="email">Your Email Address</label>
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
        <div class="f_pop_up_confirm_btn button blue"></div>
        <div class="f_pop_up_cancel_btn button blue"></div>
    </div>
</div>

<input id="main_popup_default_title" type="hidden" value="{$ns.lm->getPhrase(463)}" />
<input id="main_popup_default_content" type="hidden" value="{$ns.lm->getPhrase(374)}" />
<input id="main_popup_default_confirm_btn" type="hidden" value="{$ns.lm->getPhrase(485)}" />
<input id="main_popup_default_cancel_btn" type="hidden" value="{$ns.lm->getPhrase(49)}" />

<div class="main_loader hidden" id="main_loader"></div>