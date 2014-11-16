<?php /* Smarty version Smarty-3.1.11, created on 2014-11-15 17:24:00
         compiled from "D:\xampp\htdocs\pcstorev2\templates\main\util\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29307546753f0daa794-26702306%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c03ca744ed780b91382449df1532c18c806899e3' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pcstorev2\\templates\\main\\util\\footer.tpl',
      1 => 1416054629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29307546753f0daa794-26702306',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ns' => 0,
    'SITE_PATH' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_546753f0dd9591_87776538',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_546753f0dd9591_87776538')) {function content_546753f0dd9591_87776538($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['ns']->value['contentLoad']=="user_profile"||$_smarty_tpl->tpl_vars['ns']->value['contentLoad']=="company_profile"||$_smarty_tpl->tpl_vars['ns']->value['contentLoad']=="user_change_password"||$_smarty_tpl->tpl_vars['ns']->value['contentLoad']=="company_branches"||$_smarty_tpl->tpl_vars['ns']->value['contentLoad']=="company_smsconf"||$_smarty_tpl->tpl_vars['ns']->value['contentLoad']=="company_workingdays"){?>
<?php }else{ ?>
    <div style="clear:both;"></div>
    <div class="footer-wrapper">
        <div class="news-letter-wrapper">
            <div class="container">
                <div class="col-md-6">
                    <ul class="socialNetworks-linkes-pages">
                        <li>
                            <a href="https://www.facebook.com/pages/Pcstoream/101732636647846" target="_blank">
                                <div class="img facebook">

                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://plus.google.com/111993997426489489686" target="_blank">
                                <div class="img google">

                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/company/3743120" target="_blank">
                                <div class="img twitter">

                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                     <div id="newsletter_error_message"></div>
                     <div id="newsletter_success_message"></div>
                    <div class="input-group" style="margin: 5px 0px;">
                        <input id="newsLetterInp" name="" type="text" value="" class="form-control" placeholder="News letter" >
                        <div class="input-group-btn">
                            <button class="btn btn-default" id="newsletterSubscribeBtn"><i class="glyphicon  glyphicon-envelope"></i></button>
                        </div>
                        <div style="clear: both;"></div>
                    </div>                
                    <div style="display:none;" id="newsLetterAboveBlock" class="news-letter-below-block">
                        <p>Do you want to join us ? <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/signup">Create Account</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row nav-footer-content">
                <div class="col-md-4 text-center">
                    <h5>Make Money with Us<h5>
                            <a href="/aboutus">
                                <p>About PC Store</p>
                            </a>
                            <a href="/privatepolicy">
                                <p>Private Policy</p>
                            </a>
                            </div>
                            <div class="col-md-4 text-center">
                                <h5>Make Money with Us<h5>
                                        <a href="/signup">
                                            <p>Registration</p>
                                        </a>
                                        <a href="#">
                                            <p>Invite Friends</p>
                                        </a>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <h5>Let Us Help You<h5>
                                                    <a href="/contactus">
                                                        <p>Contact Us </p>
                                                    </a>
                                                    <a href="/help">
                                                        <p>Help</p>
                                                    </a>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                        <div  class="container">
                                                            <ul class="payments">
                                                                <li>
                                                                    <img  src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/cash_del_payment.png" />
                                                                </li>
                                                                <li>
                                                                    <img  src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/paypal_payment.png" />
                                                                </li>
                                                                <li>
                                                                    <img  src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/bank_wire_payment.png" />
                                                                </li>
                                                                <li>
                                                                    <img  src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/credit_payment.png" />
                                                                </li>
                                                                <li>
                                                                    <img  src="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/img/card_payment.png" />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                <?php }?>



<?php }} ?>