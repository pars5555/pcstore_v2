<?php /* Smarty version Smarty-3.1.11, created on 2014-11-15 17:24:00
         compiled from "D:\xampp\htdocs\pcstorev2\templates\main\util\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16223546753f07fd570-43981116%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39bd033c4e95f8c8096b06e85d1a1220d3b684b2' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pcstorev2\\templates\\main\\util\\header.tpl',
      1 => 1416054629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16223546753f07fd570-43981116',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SITE_PATH' => 0,
    'ns' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_546753f090ec77_10263023',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_546753f090ec77_10263023')) {function content_546753f090ec77_10263023($_smarty_tpl) {?><header id="headerWrapper" class="navbar navbar-inverse hero" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a  href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
" class="site_logo"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/logo_pcstore.png" alt=""> </a>
        </div>
        <nav id="navMenu" class="navMenu" role="navigation">
            <ul class="navMenuList">
                <?php if ($_smarty_tpl->tpl_vars['ns']->value['contentLoad']!="main_buildpc"){?>
                    <li>
                        <a  href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/buildpc"> <?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(226);?>
 </a>
                    </li>
                <?php }?>
                <li class="dropdown">
                    <a class="f_drop_down_btn dropdown-toggle" href="javascript:void(0);">Languages<span class="caret"></span></a>
                    <ul style="display:none;" role="menu" class="f_drop_down_menu dropdown-menu">
                        <li>
                            <a href="javascript:void(0);" class="mainSetLanguage" lang="en">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/en_s.png" alt="">English</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="mainSetLanguage" lang="am">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/am_s.png" alt="">Armenian</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="mainSetLanguage" lang="ru">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/ru_s.png" alt="">Russian</a>
                        </li>
                    </ul>
                </li>
                <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsGuest']){?>
                    <li >
                        <a class="f_myModal_toggle" href="javascript:void(0);"> Sign in / Register </a>
                    </li>
                <?php }else{ ?>
                    <li>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/companies"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(494);?>
</a>
                    </li>

                    <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']!==$_smarty_tpl->tpl_vars['ns']->value['userGroupsAdmin']){?>
                        <li>
                            <a  href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/cart"> <?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(278);?>
 <i class="glyphicon glyphicon-shopping-cart"></i> </a>
                        </li>
                    <?php }else{ ?>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(496);?>
</a>
                        </li>  
                    <?php }?>
                    <li class="dropdown">
                        <a class="f_drop_down_btn dropdown-toggle" href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['ns']->value['customer']->getName();?>

                            <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsUser']){?>
                                (<?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(434);?>
: <?php echo $_smarty_tpl->tpl_vars['ns']->value['customer']->getPoints();?>
 Դր.)
                            <?php }?> <i class="glyphicon glyphicon-user"></i><span class="caret"></span> </a>
                        <ul role="menu" class="f_drop_down_menu dropdown-menu">
                            <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsUser']){?>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/uprofile"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(94);?>
</a>
                                </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsCompany']){?>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/cprofile"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(94);?>
</a>
                                </li>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/uploadprice"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(95);?>
</a>
                                </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsServiceCompany']){?>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/scprofile"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(94);?>
</a>
                                </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsCompany']||$_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsServiceCompany']){?>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/dealers"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(495);?>
</a>
                                </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']!=$_smarty_tpl->tpl_vars['ns']->value['userGroupsAdmin']){?>
                                <li>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/orders"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(142);?>
</a>
                                </li>
                            <?php }?>
                            <li>
                                <a id="mainLogoutBtn" href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/dyn/main/do_logout"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(65);?>
</a>
                            </li>
                        </ul>
                    </li>
                    <li class="rel-block">
                        <a class="f_drop_down_btn" href="javascript:void(0)"> <i class="glyphicon glyphicon-search"></i> </a>
                        <div style="display:none;" class="f_drop_down_menu search-wrapper-pop-up-menu">
                            <div class="top-arrow"></div>
                            <div style="width:85%;" class="input-group">
                                <form method="GET" action="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
" autocomplete="off">
                                    <input type="text" id="srch-term" name="st" placeholder="<?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(91);?>
" class=" ">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default">
                                            <i class="glyphicon  glyphicon-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="notification" style="position:relative;display: none">
                        <a id="notificationBtn" class="f_drop_down_btn" href="javascript:void(0);">
                            <i style="margin-left:5px;" class="glyphicon glyphicon-bell"></i> 
                        </a>
                        <ul style="display: none; position: absolute;" id="notificationListWrapper" class="f_drop_down_menu nofitication-list-wrapper"></ul>
                    </li>

                    <li id="notificationRowTemplate" class="current-notif-wrapper container-fluid" style="display: none">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/%url%">
                            <div class="col-md-10">
                                <div class="current-notif-desc">
                                    <p>%title%</p>
                                </div>
                                <p class="notif-date">%date%</p>
                            </div>
                            <div class="col-md-2">%icon%</div> 
                        </a>
                    </li>
                <?php }?>
            </ul>
        </nav>
        <div class="clear"></div>
    </div>
</header>
<?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsGuest']){?>
    <div id="loginDialog"></div>
    <!-- Modal -->
    <div  class="modal myModal" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-content">
            <button id="close_button" class="close_button"></button>
            <div class="modal-body">
                <form class="modal_cols login-wrapper" id="mainLoginForm" role="form" autocomplete="off" method="POST" action="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/dyn/main/do_login">
                    <div class="login-wrapper">
                        <h4 class="title">Sign in with your existing account</h4>
                        <div class="form-group">
                            <label for="mainLoginEmail"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(21);?>
</label>
                            <input name="email" type="email" class=" " id="mainLoginEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="mainLoginPassword"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(4);?>
</label>
                            <input name="password" type="password" class=" " id="mainLoginPassword" placeholder="<?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(4);?>
">
                            <a id="forgot_pass" class="forget_pass" href="#" data-toggle="modal" data-target="#forgotModal" >Forgot Your Password?</a>
                        </div>
                        <div style="color:#de4c34;" class="error"></div>
                        <div class="login-buttons">
                            <input id="mainLoginBtn" type="submit" class="login_button" value="<?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(1);?>
"/>
                        </div>
                    </div>
                </form>
                <div class="modal_cols">
                    <div class="social-network-wrapper">
                        <h4 class="title">Sign in with your social network</h4>
                        <div class="social-network">
                            <a class="facebook" href="javascript:void(0);" id="facebookLoginBtn" > <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/facebook.png" alt=""/> sign in with facebook </a>
                            <a class="linkedin" id="linkedinLoginBtn" href="javascript:void(0);"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/linkedin.png" alt="" /> sign in with linkedin </a>
                            <a class="google" id="googleLoginBtnid" href="javascript:void(0);"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/googleplus.png" alt="" /> sign in with google </a>
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
                        <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/signup" class="registration"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(5);?>
</a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="modal-footer"></div>
    </div>
    <div  class="modal forgotModal" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-content">
            <button id="close_button" class="close_button"></button>
            <div class="modal-body">
                <div class="form-group">
                    <div id="forgotPasswordErrorMessage"></div>
                    <div id="forgotPasswordSuccessMessage"></div>
                    <label for="email">Your Email Address</label>
                    <form id="forgotPasswordForm" autocomplete="off">
                        <input name="email" type="email" class=" " id="forgotPasswordEmailInput" placeholder="Enter email">
                        <button class="send_pass" id="forgotPasswordBtn">
                            Send
                        </button>
                        <p>we'll send you email with your password</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<?php }} ?>