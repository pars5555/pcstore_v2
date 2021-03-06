<header id="headerWrapper" class="navbar">
    <nav id="navMenu" class="navMenu" role="navigation">
        <div class="navMenu_inner">
            <input type="hidden" id="server_ip_address" value="{$ns.server_ip_address}"/>
            <div class="left-panel-btn f_side_panel_btn" data-side-panel="categories-panel">
                <span class="fontAwesome"></span>
                <span>{if $ns.contentLoad=="main_home"}{$ns.lm->getPhrase(105)}{else}Profile Settings{/if}</span>
            </div>
            <div class="build_pc_components_btn f_side_panel_btn" data-side-panel="pc-components">
                <span class="fontAwesome"></span>
                <span>PC Components</span>
            </div>
            <div class="pcc_total_calculation_btn f_side_panel_btn" data-side-panel="pcc-total-calculation">
                <span class="fontAwesome"></span>
                <span>Your PC</span>
            </div>
            <div class="payment_type_btn f_side_panel_btn" data-side-panel="payment-type">
                <span class="fontAwesome"></span>
                <span>{$ns.lm->getPhrase(367)}</span>
            </div>
            <div class="navMenuContainer f_side_panel" data-side-panel="nav-menu" data-side-position="right">
                <ul class="navMenuList">

                    {if $ns.userLevel === $ns.userGroupsAdmin}
                        <li>
                            <input type="checkbox" id="admin_chat_on_off"/>
                        </li>
                    {/if}

                    {*}
                    {if $ns.contentLoad != "main_buildpc"}
                    <li>
                    <a class="navMenu_item"  href="{$SITE_PATH}/buildpc"> {$ns.lm->getPhrase(226)} </a>
                    </li>
                    {/if}
                    {*}

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
                                        <a href="{$SITE_PATH}/uploadprice">{$ns.lm->getPhrase(90)}</a>
                                    </li>
                                    <li>
                                        <a href="{$SITE_PATH}/sendpriceemail">{$ns.lm->getPhrase(679)}</a>
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

                        {* Notifications Container *}
                        <li class="notification f_dropdown" id="notification">
                            <a id="notificationBtn" class="dropdown_toggle f_dropdown_toggle navMenu_item" href="javascript:void(0);">
                                <span>Notifications</span>
                                <span class="icon glyphicon"></span>
                            </a>
                            <ul style="display: none;" id="notificationListWrapper" class="dropdown_menu f_dropdown_menu nofitication-list-wrapper">
                                <li class="no_notifications">You have not notifications!</li>
                            </ul>
                        </li>
                    {/if}
                </ul>
            </div>
            <div class="nav_menu_btn f_side_panel_btn" data-side-panel="nav-menu">
                <span>Menu</span>
                <span class="fontAwesome"></span>
            </div>
            <div class="clear"></div>
        </div>
    </nav>

    <div class="header_content_container">

        <div class="header_content_table">

            <div class="header_content">
                {**************************** CONTACT ********************************}
                <div class="contact_info {if $ns.userLevel === $ns.userGroupsCompany && $ns.customer->getHasLocalWebsite()}has_company_shop{/if}">

                    {if $ns.userLevel === $ns.userGroupsCompany && $ns.customer->getHasLocalWebsite()}
                        <a class="company_shop" href="http://{$ns.customer->getShortName()}.pc.am" target="_blank" title="Company shop">
                            <img src="{$SITE_PATH}/images/big_logo/{$ns.userId}" alt="Company shop">
                        </a>
                    {/if}

                    <div class="contact_info_inner">
                        <div class="contact_info_item">
                            <span class="fontAwesome"></span>
                            <a class="contact_link" href="tel:{$ns.lm->getCmsVar('pcstore_sales_phone_number1')}"> {$ns.lm->getCmsVar('pcstore_sales_phone_number1')}</a>
                        </div>
                        <div class="contact_info_item">
                            <span class="fontAwesome"></span>
                            <a class="contact_link" href="tel:{$ns.lm->getCmsVar('pcstore_sales_phone_number')}">{$ns.lm->getCmsVar('pcstore_sales_phone_number')}</a>
                        </div>
                        <div class="contact_info_item">
                            <span class="fontAwesome"></span>
                            <a class="contact_link" href="{$SITE_PATH}/contactus">contactus@pcstore.am</a>
                        </div>

                        {*}
                        <div class="contact_info_item">
                        <span class="fontAwesome"></span>
                        <a class="contact_link" target="_blank" href="https://www.google.com/maps/dir//49+Komitas+Ave,+Yerevan+0014,+%D0%90%D1%80%D0%BC%D0%B5%D0%BD%D0%B8%D1%8F/@40.2062561,44.5183635,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x406abd35dfe155cd:0xe0e03bca043244e6!2m2!1d44.5157627!2d40.2070932">{$ns.lm->getPhrase(13)}</a>
                        </div>
                        {*}

                    </div>
                </div>

                <div class="header_content_inner">
                    {**************************** LOGO ********************************}

                    <a  href="{$SITE_PATH}" class="site_logo">
                        <img src="{$SITE_PATH}/img/pcstore_logo_small.png" alt="">
                    </a>

                    {**************************** BUILD PC ********************************}
                    <div class="build_pc_animation build_pc_animation_top">
                        <a class="build_pc_link f_build_pc_link" href="{$SITE_PATH}/buildpc">
                            {*}
                            <object class="build_pc_obj">
                            <param name="movie" value="{$SITE_PATH}/img/buildpc/buildpc.swf">
                            <param name="wmode" value="transparent" />
                            <embed class="build_pc_obj" wmode=transparent allowfullscreen="true" allowscriptaccess="always" src="{$SITE_PATH}/img/buildpc/buildpc.swf"></embed>
                            </object>
                            {*}
                            <img class="build_pc_obj build_pc_img" src="{$SITE_PATH}/img/buildpc/buildpc.jpg">
                        </a>
                    </div> 

                    <div class="search_block">
                        {**************************** SEARCH ********************************}
                        <div class="search_container">
                            <form action="{$SITE_PATH}" id="search_text_form" autocomplete="off" method="get">
                                <input type="search" id="srch-term" name="st" placeholder="{$ns.lm->getPhrase(91)}" class="search_text" value="{$ns.req.st|default:''}">
                                <button type="submit" class="search_btn">
                                    
                                </button>

                                {if $ns.contentLoad == "main_home"}
                                    <input type="hidden" name="cid" value="{$ns.req.cid|default:''}"/>
                                    <input type="hidden" name="scpids" value="{$ns.req.scpids|default:''}"/>
                                    <input type="hidden" id="selected_company_id_input" name='sci' value="{$ns.req.sci|default:''}"/>
                                    <input type="hidden" id="sort_by_input" name="s" value="{$ns.req.s|default:''}"/>
                                    <input type="hidden" id="show_only_vat_items_checkbox" name='shv' value="{$ns.req.shv|default:''}"/>
                                    <input type="hidden" id="listing_cols_select" name="cols" />
                                {/if}
                            </form>
                        </div>
                    </div>


                </div>
            </div>

            {**************************** BUILD PC ********************************}
            <div class="build_pc_animation">
                <a class="build_pc_link f_build_pc_link" href="{$SITE_PATH}/buildpc">
                    {*}
                    <object class="build_pc_obj">
                    <param name="movie" value="{$SITE_PATH}/img/buildpc/buildpc.swf">
                    <param name="wmode" value="transparent" />
                    <embed class="build_pc_obj" wmode=transparent allowfullscreen="true" allowscriptaccess="always" src="{$SITE_PATH}/img/buildpc/buildpc.swf"></embed>
                    </object>
                    {*}
                    <img class="build_pc_obj build_pc_img" src="{$SITE_PATH}/img/buildpc/buildpc.jpg">
                </a>
            </div> 

        </div>
    </div>

</header>
<section>

    <div id="scroll_page_top" class="scroll_page_top fontAwesome"></div>

    {*************************************************************************************************}
    {*                                                                                               *}
    {*                                  LOGIN REGISTRATION DIALOG                                    *}
    {*                                                                                               *}
    {*************************************************************************************************}

    {if $ns.userLevel === $ns.userGroupsGuest}
        <!-- Modal -->
        <div  class="modal myModal hide" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="overlay"></div>
            <div class="modal-content f_modal_content">
                <button class="close_button"></button>
                <div class="modal-body">
                    <form class="modal_cols login-wrapper" id="mainLoginForm" role="form" autocomplete="off" method="POST" action="{$SITE_PATH}/dyn/main/do_login">
                        <div class="login-wrapper">
                            <h4 class="title">{$ns.lm->getPhrase(660)}</h4>
                            <div class="form-group">
                                <label class="input_label label" for="mainLoginEmail">{$ns.lm->getPhrase(21)}</label>
                                <input name="email" type="email" class="  text" id="mainLoginEmail" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label class="input_label label" for="mainLoginPassword">{$ns.lm->getPhrase(4)}</label>
                                <input name="password" type="password" class="  text" id="mainLoginPassword" placeholder="{$ns.lm->getPhrase(4)}">
                                <a id="forgot_pass" class="forget_pass" href="javascript:void(0);" data-toggle="modal" data-target="#forgotModal" >{$ns.lm->getPhrase(6)}</a>
                            </div>
                            <div style="color:#de4c34;" class="error"></div>
                            <div class="login-buttons">
                                <input id="mainLoginBtn" type="submit" class="login_button blue button" value="{$ns.lm->getPhrase(1)}"/>
                            </div>
                        </div>
                    </form>
                    <div class="modal_cols">
                        <div class="social-login-wrapper">
                            <h4 class="title">{$ns.lm->getPhrase(661)}</h4>
                            <div class="social-login">
                                <a class="facebook social-login-link" href="javascript:void(0);" id="facebookLoginBtn" > <img src="{$SITE_PATH}/img/facebook.png" alt=""/> sign in with facebook </a>
                                <a class="linkedin social-login-link" id="linkedinLoginBtn" href="javascript:void(0);"> <img src="{$SITE_PATH}/img/linkedin.png" alt="" /> sign in with linkedin </a>
                                <div class="google social-login-link" id="googleLoginBtn" > <img src="{$SITE_PATH}/img/googleplus.png" alt="" /> sign in with google </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal_cols create-account-wrapper">
                        <h4 class="title">{$ns.lm->getPhrase(662)}</h4>
                        <p>
                            {$ns.lm->getPhrase(663)}
                        </p>
                        <ul>
                            <li>
                                {$ns.lm->getPhrase(664)}
                            </li>
                            <li>
                                {$ns.lm->getPhrase(665)}
                            </li>
                            <li>
                                {$ns.lm->getPhrase(666)}
                            </li>
                            <li>
                                {$ns.lm->getPhrase(667)}
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

        {*************************************************************************************************}
        {*                                                                                               *}
        {*                                       FORGOT PASSWORD                                         *}
        {*                                                                                               *}
        {*************************************************************************************************}       


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
    {if $ns.userLevel === $ns.userGroupsAdmin}
        <div  class="pop_up_container main_pop_up adminItemCategoriesPopup" id="adminItemCategoriesPopup" >
            <div class="overlay"></div>
            <div class="pop_up">
                <div class="close_button"></div>
                <h3 class="pop_up_title f_pop_up_title">{$ns.lm->getPhrase(105)}</h3>
                <div id="adminItemCategoriesPopupBody" class="pop_up_content f_pop_up_content">

                </div>
            </div>
        </div>

        <div  class="pop_up_container main_pop_up adminItemPicturesPopup" id="adminItemPicturesPopup" >
            <div class="overlay"></div>
            <div class="pop_up">
                <div class="close_button"></div>
                <h3 class="pop_up_title f_pop_up_title">{$ns.lm->getPhrase(108)}</h3>
                <div id="adminItemPicturesPopupBody" class="pop_up_content f_pop_up_content">

                </div>
            </div>
        </div>
    {/if}

    {*************************************************************************************************}
    {*                                                                                               *}
    {*                                           MAIN POPUP                                          *}
    {*                                                                                               *}
    {*************************************************************************************************}

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
    <div class="hidden" id="mainPopupSettings">
        <input class="f_main_popup_default_title" type="hidden" value="{$ns.lm->getPhrase(483)}" />
        <input class="f_main_popup_default_content" type="hidden" value="{$ns.lm->getPhrase(374)}" />
        <input class="f_main_popup_default_confirm_btn" type="hidden" value="{$ns.lm->getPhrase(485)}" />
        <input class="f_main_popup_default_cancel_btn" type="hidden" value="{$ns.lm->getPhrase(49)}" />
    </div>

    <div class="main_loader hidden" id="main_loader"></div>

    {if isset($ns.signup_message)}
        <input id="signup_activation_message" type="hidden" value="{$ns.lm->getPhrase(522)}" />
    {/if}
    {if isset($ns.signup_activation_done)}
        <input id="signup_activation_done" type="hidden" value="Already activated" />
    {/if}
</section>