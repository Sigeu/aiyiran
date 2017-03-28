<?php
/* Smarty version 3.1.30, created on 2017-01-06 15:14:42
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\cat\update.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f43e2804b92_83369300',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '18c6237b2e7b96c9ac557fdfd11972097c6f6b76' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\cat\\update.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_586f43e2804b92_83369300 (Smarty_Internal_Template $_smarty_tpl) {
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
/memorial/cat/index">纪念馆分类列表</a></dd>
					<dt class="on"><a href="javascript:;" class="last">编辑纪念馆分类</a></dt>
				</dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/update' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font> 网站名称：</th>
									<td>
										<input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['page'];?>
" />
										<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['id'];?>
" />
										<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['name'];?>
" class="Iw290" name='name' id='name'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>

								<tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font> 排序：</th>
									<td>
										<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['sort'];?>
" class="Iw290" name='sort' id='sort'/>&nbsp;<span id='sort_urlTip'></span>
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
<?php echo '<script'; ?>
>
$(function(){
    $.formValidator.initConfig({formid:"myform",autotip:false,generalwordwide:true});
    
    $("#name").formValidator({empty:false,onshow:"请输入2-50字符",onfocus:"请输入2-50字符",oncorrect:"输入正确"})
    .inputValidator({min:2,max:50,onerror:"请输入2-50字符"}).defaultPassed();
   



<?php echo '</script'; ?>
>
</html>
<?php }
}
