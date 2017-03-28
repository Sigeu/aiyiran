<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:12:24
  from "D:\WWW\jisi2\admin\template\memorial\cat\add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585385c86a8f83_39220548',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cca940eb185bee24cd2c52039e910b410b17c309' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\memorial\\cat\\add.html',
      1 => 1479696490,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_585385c86a8f83_39220548 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:false,generalwordwide:true});
	
	$("#name").formValidator({empty:false,onshow:"请输入2-50字符",onfocus:"请输入2-50字符",oncorrect:"输入正确"})
	.inputValidator({min:2,max:50,onerror:"请输入2-50字符"});
<?php echo '</script'; ?>
>
<body>
	<div class="pubBox" >
		<div class="pubtabBox">
			<div class="TabBoxT">
				<dl class="navTab">     
                    <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/index" class="last">纪念馆分类列表</a></dd>
                    <dt class="on"><a href="#">添加纪念馆分类</a></dt>
				</dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/add' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font> 分类名称：</th>
									<td>
										<input type="text" value="" class="Iw290" name='name' id='name'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>

								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font> 选择所属分类：</th>
									<td>
										<select name="pid">
										<option>请选择所属分类</option>
					  					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['catList']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['name'];?>
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
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：</th>
									<td>
										<input type="text" value="0" class="Iw290" name='sort' id='sort'/>&nbsp;<span id='memberTip'></span>
									</td>
								</tr>

							
							</table>
							<div class="pubTabelBot"><input type="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/index'"></div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
<?php }
}
