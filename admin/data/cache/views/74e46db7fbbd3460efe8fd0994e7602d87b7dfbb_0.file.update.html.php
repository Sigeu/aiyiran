<?php
/* Smarty version 3.1.30, created on 2016-12-19 16:18:14
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\moreset\update.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585797c61715d8_82604104',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '74e46db7fbbd3460efe8fd0994e7602d87b7dfbb' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\moreset\\update.html',
      1 => 1476411550,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_585797c61715d8_82604104 (Smarty_Internal_Template $_smarty_tpl) {
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
/memorial/moreset/index" class="last">墓铭志列表列表</a></dd>
                  
                    <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/add" class="last">添加墓铭志</a></dd>
				</dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/update' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font> 名称：</th>
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
                                  <th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;内容：</th>
                                  <td colspan="5"><textarea class="Iw450 Ih80" name="content" id="content"><?php echo $_smarty_tpl->tpl_vars['infor']->value['content'];?>
</textarea> &nbsp;&nbsp;</td>
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
/memorial/moreset/index'"></div>
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
