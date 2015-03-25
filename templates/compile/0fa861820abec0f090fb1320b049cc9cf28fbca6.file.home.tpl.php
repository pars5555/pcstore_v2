<?php /* Smarty version Smarty-3.1.11, created on 2014-11-15 17:24:00
         compiled from "D:\xampp\htdocs\pcstorev2\templates\main\home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7596546753f0935d74-11902633%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0fa861820abec0f090fb1320b049cc9cf28fbca6' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pcstorev2\\templates\\main\\home.tpl',
      1 => 1416054629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7596546753f0935d74-11902633',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SITE_PATH' => 0,
    'ns' => 0,
    'value' => 0,
    'key' => 0,
    'index' => 0,
    'parent_category_dto' => 0,
    'property_view' => 0,
    'tree_days_ago' => 0,
    'item' => 0,
    'count' => 0,
    'brand' => 0,
    'new_item' => 0,
    'price_in_amd' => 0,
    'vat_price_in_amd' => 0,
    'list_price_discount' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_546753f0bf8e07_57958672',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_546753f0bf8e07_57958672')) {function content_546753f0bf8e07_57958672($_smarty_tpl) {?><?php if (!is_callable('smarty_function_nest')) include 'D:/xampp/htdocs/pcstorev2/classes/lib/smarty/plugins\\function.nest.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:/xampp/htdocs/pcstorev2/classes/lib/smarty/plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_math')) include 'D:/xampp/htdocs/pcstorev2/classes/lib/smarty/plugins\\function.math.php';
?><div class="home_page_main_wrapper">
	
	<!--========================== Top Container ===============================-->
	    
    <div  class="main-top-container container">
        	<div class="search_block">
            <div class="search_container">
                    <form role="search" action="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
" id="search_text_form" autocomplete="off" method="get" >
                        <input type="text" id="srch-term" name="st" placeholder="<?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(91);?>
" class="search_text" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ns']->value['req']['st'])===null||$tmp==='' ? '' : $tmp);?>
">
                            <button type="submit" class="search_btn"></button>
                        <?php if (isset($_smarty_tpl->tpl_vars['ns']->value['req']['cid'])){?>
                            <input type="hidden" name="cid" value="<?php echo $_smarty_tpl->tpl_vars['ns']->value['req']['cid'];?>
"/>
                        <?php }?>
                        <input type="hidden" name="s" value="<?php echo $_smarty_tpl->tpl_vars['ns']->value['selected_sort_by_value'];?>
"/>
                        
                    </form>
                    <div class="clear"></div>
                    </div>
            </div>
            <div class="filter_container">
                <h3>Filter</h3> 
                <div class="col-sm-4 col-md-4">
                    <div class="from-group">
                        <label>
                            Sort By Price
                        </label>
                        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ns']->value['sort_by_values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                            </br>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('s'=>$_smarty_tpl->tpl_vars['value']->value));?>
" 
                               <?php if ($_smarty_tpl->tpl_vars['ns']->value['selected_sort_by_value']==$_smarty_tpl->tpl_vars['value']->value){?>style="color:red"<?php }?>><?php echo $_smarty_tpl->tpl_vars['ns']->value['sort_by_display_names'][$_smarty_tpl->tpl_vars['key']->value];?>
</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <?php if ((count($_smarty_tpl->tpl_vars['ns']->value['companiesIds'])>1)){?>
                            <label for="selected_company_id"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(66);?>
: </label>
                        <?php }?>
                        <select class=" " name='sci' id='selected_company_id'  style="<?php if (!(count($_smarty_tpl->tpl_vars['ns']->value['companiesIds'])>1)){?>display:none;<?php }?>">
                            <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ns']->value['companiesIds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                                <?php if (($_smarty_tpl->tpl_vars['key']->value==0)){?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['ns']->value['selectedCompanyId']==0){?>selected="selected"<?php }?> class="translatable_element" phrase_id="153"><?php echo $_smarty_tpl->tpl_vars['ns']->value['companiesNames'][$_smarty_tpl->tpl_vars['key']->value];?>
</option>
                                <?php }else{ ?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['ns']->value['selectedCompanyId']==$_smarty_tpl->tpl_vars['value']->value){?>selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['ns']->value['companiesNames'][$_smarty_tpl->tpl_vars['key']->value];?>
</option>
                                <?php }?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    
                </div>
            </div>       

            <?php echo smarty_function_nest(array('ns'=>'paging'),$_smarty_tpl);?>

            <div class="clear"></div>
    </div>
	

	
	<!--========================== Product Container ===============================-->
	   
    <div class="home_page_inner_container">
    	
    		<!--========================== Left Panel ===============================-->
	
    <div id="mainLeftPanel"  class="main-page-left-panel">

        <?php if ($_smarty_tpl->tpl_vars['ns']->value['category_id']>0){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('cid'=>0,'scpids'=>null));?>
"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(130);?>
</a>

            <?php $_smarty_tpl->tpl_vars["index"] = new Smarty_variable(0, null, 0);?>
            <?php if (isset($_smarty_tpl->tpl_vars['ns']->value['category_path'])){?>		
                <?php  $_smarty_tpl->tpl_vars['parent_category_dto'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['parent_category_dto']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ns']->value['category_path']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['parent_category_dto']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['parent_category_dto']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fi']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['parent_category_dto']->key => $_smarty_tpl->tpl_vars['parent_category_dto']->value){
$_smarty_tpl->tpl_vars['parent_category_dto']->_loop = true;
 $_smarty_tpl->tpl_vars['parent_category_dto']->iteration++;
 $_smarty_tpl->tpl_vars['parent_category_dto']->last = $_smarty_tpl->tpl_vars['parent_category_dto']->iteration === $_smarty_tpl->tpl_vars['parent_category_dto']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fi']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fi']['last'] = $_smarty_tpl->tpl_vars['parent_category_dto']->last;
?>			
                    <?php $_smarty_tpl->tpl_vars["index"] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['foreach']['fi']['index'], null, 0);?>
                    <div style="margin: 5px 0 5px <?php echo $_smarty_tpl->tpl_vars['index']->value*15+30;?>
px" >
                        <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemSearchManager']->getUrlParams(array('cid'=>$_smarty_tpl->tpl_vars['parent_category_dto']->value->getId(),'scpids'=>null));?>
" ><?php echo $_smarty_tpl->tpl_vars['parent_category_dto']->value->getDisplayName();?>
</a>
                    </div>
                <?php } ?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['ns']->value['category_id']>0){?>	
                <?php $_smarty_tpl->tpl_vars["index"] = new Smarty_variable($_smarty_tpl->tpl_vars['index']->value+1, null, 0);?>
                <div style="padding-left: <?php echo $_smarty_tpl->tpl_vars['index']->value*15+30;?>
px;" >
                    <?php echo $_smarty_tpl->tpl_vars['ns']->value['category_dto']->getDisplayName();?>

                </div>	
            <?php }?>
        <?php }?>



        <?php if (isset($_smarty_tpl->tpl_vars['ns']->value['itemsCategoryMenuView'])){?>
            <?php echo $_smarty_tpl->tpl_vars['ns']->value['itemsCategoryMenuView']->display(false);?>

        <?php }?>
        <?php if (($_smarty_tpl->tpl_vars['ns']->value['properties_views']&&count($_smarty_tpl->tpl_vars['ns']->value['properties_views'])>0)){?>

            <?php  $_smarty_tpl->tpl_vars['property_view'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['property_view']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ns']->value['properties_views']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['property_view']->key => $_smarty_tpl->tpl_vars['property_view']->value){
$_smarty_tpl->tpl_vars['property_view']->_loop = true;
?>
                <?php echo $_smarty_tpl->tpl_vars['property_view']->value->display();?>

            <?php } ?>	

        <?php }?>
        
    </div>
    	
            <?php $_smarty_tpl->tpl_vars["count"] = new Smarty_variable(1, null, 0);?>	
        <?php if (count($_smarty_tpl->tpl_vars['ns']->value['foundItems'])>0){?>
            <?php $_smarty_tpl->tpl_vars["tree_days_ago"] = new Smarty_variable(strtotime('-3 day'), null, 0);?>
            <?php $_smarty_tpl->tpl_vars["tree_days_ago"] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->tpl_vars['tree_days_ago']->value,"%Y-%m-%d %H:%M:%S"), null, 0);?>				
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ns']->value['foundItems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fi']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fi']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fi']['last'] = $_smarty_tpl->tpl_vars['item']->last;
?>
                <?php $_smarty_tpl->tpl_vars["brand"] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value->getBrand(), null, 0);?>
                <?php if ($_smarty_tpl->tpl_vars['item']->value->getCreatedDate()>$_smarty_tpl->tpl_vars['tree_days_ago']->value){?>
                    <?php $_smarty_tpl->tpl_vars["new_item"] = new Smarty_variable(true, null, 0);?>			
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars["new_item"] = new Smarty_variable(false, null, 0);?>			
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['count']->value==1){?>
                <div class="products_row">
                <?php }?>
                <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->tpl_vars['count']->value+1, null, 0);?>
                   
                <div class="product-wrapper">
                    <div class="product_inner">
                            <a class="" href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/item/<?php echo $_smarty_tpl->tpl_vars['item']->value->getId();?>
"><h4 class="product-title"><?php echo $_smarty_tpl->tpl_vars['item']->value->getDisplayName();?>
<span><?php if (!empty($_smarty_tpl->tpl_vars['brand']->value)){?> by <?php echo $_smarty_tpl->tpl_vars['brand']->value;?>
<?php }?></span> </h4></a>
                            <div class="product-img" style="background-image:url('')">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['ns']->value['itemManager']->getItemImageURL($_smarty_tpl->tpl_vars['item']->value->getId(),$_smarty_tpl->tpl_vars['item']->value->getCategoriesIds(),'150_150',1);?>
" />
                                <?php if ($_smarty_tpl->tpl_vars['new_item']->value==true){?>
                                    NEW ITEM!!!
                                <?php }?>
                            </div>
                            <div class="product-price">
                                <?php if ($_smarty_tpl->tpl_vars['item']->value->getIsDealerOfThisCompany()!=1){?>
                                    <p><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(588);?>
: <span><?php echo number_format($_smarty_tpl->tpl_vars['item']->value->getListPriceAmd());?>
 Դր.</span></p>
                                <?php }?>
                                <p><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(88);?>
: <span>
                                        <?php if ($_smarty_tpl->tpl_vars['item']->value->getIsDealerOfThisCompany()==1){?>
                                            <?php if ($_smarty_tpl->tpl_vars['item']->value->getDealerPriceAmd()>0){?>
                                                <?php echo number_format($_smarty_tpl->tpl_vars['item']->value->getDealerPriceAmd());?>
 Դր.
                                            <?php }else{ ?>
                                                $<?php echo number_format($_smarty_tpl->tpl_vars['item']->value->getDealerPrice(),1);?>

                                            <?php }?>  
                                        <?php }else{ ?>
                                            <?php $_smarty_tpl->tpl_vars["price_in_amd"] = new Smarty_variable($_smarty_tpl->tpl_vars['ns']->value['itemManager']->exchangeFromUsdToAMD($_smarty_tpl->tpl_vars['item']->value->getCustomerItemPrice()), null, 0);?>
                                            <?php echo number_format($_smarty_tpl->tpl_vars['price_in_amd']->value);?>
 Դր.
                                        <?php }?>                                        
                                    </span>
                                </p>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value->getVatPrice()>0){?>
                                    <p><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(488);?>
: <span>
                                            <?php if ($_smarty_tpl->tpl_vars['item']->value->getIsDealerOfThisCompany()==1){?>
                                                <?php if ($_smarty_tpl->tpl_vars['item']->value->getVatPriceAmd()>0){?>
                                                    (<?php echo number_format($_smarty_tpl->tpl_vars['item']->value->getVatPriceAmd());?>
 Դր.)
                                                <?php }else{ ?>
                                                    ($<?php echo number_format($_smarty_tpl->tpl_vars['item']->value->getVatPrice(),1);?>
)
                                                <?php }?>
                                            <?php }else{ ?>
                                                <?php $_smarty_tpl->tpl_vars["vat_price_in_amd"] = new Smarty_variable($_smarty_tpl->tpl_vars['ns']->value['itemManager']->exchangeFromUsdToAMD($_smarty_tpl->tpl_vars['item']->value->getCustomerVatItemPrice()), null, 0);?>
                                                (<?php echo number_format($_smarty_tpl->tpl_vars['vat_price_in_amd']->value);?>
 Դր.)
                                            <?php }?>
                                        </span>
                                    </p>
                                <?php }?>                                        
                                <?php if ($_smarty_tpl->tpl_vars['item']->value->getIsDealerOfThisCompany()!=1){?>
                                    <?php echo smarty_function_math(array('equation'=>"100-x*100/y",'x'=>$_smarty_tpl->tpl_vars['price_in_amd']->value,'y'=>$_smarty_tpl->tpl_vars['item']->value->getListPriceAmd(),'assign'=>"list_price_discount"),$_smarty_tpl);?>

                                    <p><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(589);?>
: 
                                        <span><?php echo number_format(($_smarty_tpl->tpl_vars['item']->value->getListPriceAmd()-$_smarty_tpl->tpl_vars['price_in_amd']->value));?>
 (<?php echo number_format($_smarty_tpl->tpl_vars['list_price_discount']->value);?>
%)</span>
                                    </p>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value->getUpdatedDate()&&$_smarty_tpl->tpl_vars['item']->value->getUpdatedDate()!="0000-00-00 00:00:00"){?>
                                    <p><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(453);?>
:<span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value->getUpdatedDate(),"%d/%m/%Y");?>
</span></p>
                                <?php }?>
                            </div>
                        <div class="button-wrapper">
                            <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']===$_smarty_tpl->tpl_vars['ns']->value['userGroupsGuest']){?>  
                                <a data-toggle="modal" data-target="#myModal" href="#" class='btn btn-default btn-primary pull-right'><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(85);?>
</a>
                            <?php }else{ ?>
                                <?php if (!(smarty_modifier_date_format(time(),"%Y-%m-%d")>$_smarty_tpl->tpl_vars['item']->value->getItemAvailableTillDate())){?>			
                                    <?php if ($_smarty_tpl->tpl_vars['ns']->value['userLevel']==$_smarty_tpl->tpl_vars['ns']->value['userGroupsUser']&&!$_smarty_tpl->tpl_vars['item']->value->getIsDealerOfThisCompany()){?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_PATH']->value;?>
/dyn/user/do_add_to_cart?item_id=<?php echo $_smarty_tpl->tpl_vars['item']->value->getId();?>
" class="btn btn-default btn-primary pull-right" title="<?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(284);?>
"><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(284);?>
</a>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        </div>
                    </div>

               </div>
                <?php if ($_smarty_tpl->tpl_vars['count']->value==4){?>
                </div>
                <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable(1, null, 0);?>
                <?php }?>
				<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['fi']['last']){?> </div> <?php }?>
            <?php } ?>
            <?php echo smarty_function_nest(array('ns'=>'paging'),$_smarty_tpl);?>

        <?php }else{ ?>
            <div style="text-align: center">
                <h1><?php echo $_smarty_tpl->tpl_vars['ns']->value['lm']->getPhrase(117);?>
</h1>
            </div>
        <?php }?>
    </div>
    <div class="clear"></div>
</div>
<?php }} ?>