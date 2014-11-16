<?php /* Smarty version Smarty-3.1.11, created on 2014-11-16 12:04:07
         compiled from "D:\xampp\htdocs\pcstorev2\templates\admin\left_panel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:426354685a7730ba11-90534619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a40a1688dba34a6b93c587fe35d03af9a6a54df9' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pcstorev2\\templates\\admin\\left_panel.tpl',
      1 => 1416054629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '426354685a7730ba11-90534619',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SITE_PATH' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_54685a77351f20_36522643',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54685a77351f20_36522643')) {function content_54685a77351f20_36522643($_smarty_tpl) {?><ul>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/home">
        <li>home</li>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/users">
        <li>users</li>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/admins">
        <li>admins</li>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/companies">
        <li>companies</li>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/scompanies">
        <li>service companies</li>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/uploadprice">
        <li>price upload</li>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/items">
        <li>items</li>
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/admin/categories">
        <li>categories</li>
    </a>
</ul><?php }} ?>