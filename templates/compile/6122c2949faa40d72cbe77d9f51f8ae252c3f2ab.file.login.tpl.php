<?php /* Smarty version Smarty-3.1.11, created on 2014-11-16 11:59:22
         compiled from "D:\xampp\htdocs\pcstorev2\templates\admin\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2955468595a0ee488-72985161%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6122c2949faa40d72cbe77d9f51f8ae252c3f2ab' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pcstorev2\\templates\\admin\\login.tpl',
      1 => 1416124758,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2955468595a0ee488-72985161',
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
  'unifunc' => 'content_5468595a13c686_89503886',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5468595a13c686_89503886')) {function content_5468595a13c686_89503886($_smarty_tpl) {?><form method="POST" action="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/dyn/admin/do_login">
    <span>Username:</span><input  type="text" name="username"/>
    <span>Password:</span><input type="password" name="password"/>  
    <?php if (isset($_smarty_tpl->tpl_vars['ns']->value['error_message'])){?>
            <?php echo $_smarty_tpl->tpl_vars['ns']->value['error_message'];?>

    <?php }?>  
    <input class="white-button" type="submit" />    
</form><?php }} ?>