<?php
/* Smarty version 3.1.30, created on 2016-12-19 15:30:39
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\addhall.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58578c9f2e68f1_34662281',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '76284c043e7fbe5aca720895def5b5ce13152715' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\addhall.html',
      1 => 1480299947,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58578c9f2e68f1_34662281 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<body>
	<div class="pubBox" >
		<div class="pubtabBox">
			<div class="TabBoxT">
				<dl class="navTab">     
                    <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" class="last">纪念馆列表</a></dd>
                    <dt class="on"><a href="">添加纪念馆</a></dt>
			    </dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/addhall' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
                               <tr>
									<th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>头像：</th>
									<td>
										 <!--<p style="padding-bottom:5px;">
											<input onclick="uploadAccessory({'limit':'20','_switch':'accessory','self_id':'uploadButton','check_id':'isUpload'})" id="uploadButton" type="button" value="浏览上传" class="btn5" />
											<input type="hidden" id="isUpload" value=""/>
										</p>-->
                                        <div id="img-adta-0" style="display:none"></div>
                                        <img class="mt5" src="/admin/template/images/img_downl.png" id="img0" onclick="uploadAccessory({'upload_id':'0','limit':'2','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-0','img_id':'img0','hid_id':'hid0'})" width="110" height="86" style="cursor:pointer">
									</td>
								</tr>
								<tr>
									<th width="180px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>纪念馆名称：</th>
									<td>
										<input type="text" value="" class="Iw290" name='name' id='name'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>
       	                         <tr>
									<th width="180px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>逝者名称：</th>
									<td>
										<input type="text" value="" class="Iw290" name='personname' id='personname'/>&nbsp;<span id='personnameTip'></span>
									</td>
								</tr>
							    <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;与逝者关系：</th>
									<td>
									<select name="persontype">
                                     <option value="">请选择</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['person_type']->value, 'k', false, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value => $_smarty_tpl->tpl_vars['k']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
									</td>
								</tr>
                                
                                <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;纪念馆分类：</th>
									<td>
									<select name="catid">
                                     <option value="0">请选择</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cemetery']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
									</td>
								</tr>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;纪念馆状态：</th>
                                    <td>
                                    <select name="status">
                                        <option value="0">未审核</option>
                                        <option value="1">审核通过</option>
                                        <option value="2">审核失败</option>
                                    </select>
                                    </td>
                                <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;模板风格：</th>
									<td>
									<select name="style">
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['style']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
									</td>
								</tr>
  						      </table>
							<div class="pubTabelBot"><input type="submit" name="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/index'"></div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
 <?php echo '<script'; ?>
>
 /*
*  -------------------------------------------------
*   自定义上传方法
*  -------------------------------------------------
*/
var _acc_option=
{
	upload_id:'accessory_upload',
	title:'附件上传',
	return_id:'accessory',
	callFunName:'accessoryUpload',
	setting:'<?php echo $_smarty_tpl->tpl_vars['picsetting']->value;?>
',
	param:{}
};

function uploadAccessory (obj)
{	
	_acc_option.param = obj;
	MainOneUpload(_acc_option);//调用统一上传方法
}

 <?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
