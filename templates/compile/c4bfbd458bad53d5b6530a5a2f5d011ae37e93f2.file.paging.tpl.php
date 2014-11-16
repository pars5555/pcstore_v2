<?php /* Smarty version Smarty-3.1.11, created on 2014-11-15 17:24:00
         compiled from "D:\xampp\htdocs\pcstorev2\templates\main\paging.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14858546753f0cc0196-03150838%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4bfbd458bad53d5b6530a5a2f5d011ae37e93f2' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pcstorev2\\templates\\main\\paging.tpl',
      1 => 1416054629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14858546753f0cc0196-03150838',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ns' => 0,
    'SITE_PATH' => 0,
    'pg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_546753f0d83690_28723860',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_546753f0d83690_28723860')) {function content_546753f0d83690_28723860($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['ns']->value['pageCount']>1){?>
	<div class="navigation_pagination pull-right" id="f_pageingBox">
		<div id="pageBox" class="pagination">

			<?php if ($_smarty_tpl->tpl_vars['ns']->value['page']>1){?>	
				<?php $_smarty_tpl->tpl_vars["pg"] = new Smarty_variable($_smarty_tpl->tpl_vars['ns']->value['page']-1, null, 0);?>				
				<a id="f_prev" 	 rel="prev"		   
                                   href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('pg'=>$_smarty_tpl->tpl_vars['pg']->value));?>
"  class="prev-btn navbutton"><i class="glyphicon glyphicon-chevron-left"></i></a>
			<?php }else{ ?>
				<span class="prev-btn disabled"><i class="glyphicon glyphicon-chevron-left"></i></span>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['ns']->value['pStart']+1>1){?>
				<a class="f_pagenum current-page-number" id="tplPage_1" href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('pg'=>1));?>
">1</a>
				<?php if ($_smarty_tpl->tpl_vars['ns']->value['pStart']+1>2){?>
					<span>...</span>
				<?php }?>
			<?php }?>

			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pages'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['name'] = 'pages';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ns']->value['pEnd']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = (int)$_smarty_tpl->tpl_vars['ns']->value['pStart'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total']);
?>
				<?php $_smarty_tpl->tpl_vars["pg"] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['pages']['index']+1, null, 0);?>				
				<?php if ($_smarty_tpl->tpl_vars['ns']->value['page']!=$_smarty_tpl->tpl_vars['pg']->value){?>		
					
					<a class="f_pagenum current-page-number" id="tplPage_<?php echo $_smarty_tpl->tpl_vars['pg']->value;?>
"
					   href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('pg'=>$_smarty_tpl->tpl_vars['pg']->value));?>
"><?php echo $_smarty_tpl->tpl_vars['pg']->value;?>
</a>
				<?php }else{ ?>
					<span class="current current-page-number"><?php echo $_smarty_tpl->tpl_vars['pg']->value;?>
</span>
				<?php }?>
			<?php endfor; endif; ?>

			<?php if ($_smarty_tpl->tpl_vars['ns']->value['pageCount']>$_smarty_tpl->tpl_vars['ns']->value['pEnd']){?>
				<?php if ($_smarty_tpl->tpl_vars['ns']->value['pageCount']>$_smarty_tpl->tpl_vars['ns']->value['pEnd']+1){?>
					<span >...</span>
				<?php }?>
				<a class="f_pagenum current-page-number" id="tplPage_<?php echo $_smarty_tpl->tpl_vars['ns']->value['pageCount'];?>
"
				    href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('pg'=>$_smarty_tpl->tpl_vars['ns']->value['pageCount']));?>
"><?php echo $_smarty_tpl->tpl_vars['ns']->value['pageCount'];?>
</a>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['ns']->value['page']==$_smarty_tpl->tpl_vars['ns']->value['pageCount']){?>
				<span class="next-btn disabled"><i class="glyphicon glyphicon-chevron-right"></i></span>
			<?php }else{ ?>
				<?php $_smarty_tpl->tpl_vars["pg"] = new Smarty_variable($_smarty_tpl->tpl_vars['ns']->value['page']+1, null, 0);?>				
				<a id="f_next"  rel="next"
				   href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('pg'=>$_smarty_tpl->tpl_vars['pg']->value));?>
"
				   class="next-btn navbutton"><i class="glyphicon glyphicon-chevron-right"></i></a>
			<?php }?>
		</div>
		<input type="hidden" id="f_curPage" value="<?php echo $_smarty_tpl->tpl_vars['ns']->value['page'];?>
">
		<input type="hidden" id="f_pageCount" value="<?php echo $_smarty_tpl->tpl_vars['ns']->value['pageCount'];?>
">
	</div>
<?php }?><?php }} ?>