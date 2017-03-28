<?php
/* Smarty version 3.1.30, created on 2017-02-21 16:21:40
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\moreset\addstele.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58abf89434bf22_74271767',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70291f508a26c48d6adbf5dea20560d81ec69f3e' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\moreset\\addstele.html',
      1 => 1477637051,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58abf89434bf22_74271767 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>
$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:false,generalwordwide:true});
	
	$("#name").formValidator({empty:false,onshow:"请输入2-50字符",onfocus:"请输入2-50字符",oncorrect:"输入正确"})
	.inputValidator({min:2,max:50,onerror:"请输入2-50字符"});
    $("#content").formValidator({empty:false,onshow:"请输入2-500字符",onfocus:"请输入2-500字符",oncorrect:"输入正确"})
	.inputValidator({min:2,max:500,onerror:"请输入2-500字符"});
 });
<?php echo '</script'; ?>
>
<body>
	<div class="pubBox" >
		<div class="pubtabBox">
			<div class="TabBoxT">
				<dl class="navTab">     
                    <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/steleauthor" class="last">立碑人模板信息列表</a></dd>
                    <dt class="on"><a href="#">添加立碑人模板信息</a></dt>
				</dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/addstele' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>名称：</th>
									<td>
										<input type="text" value="" class="Iw290" name='name' id='name'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>
                                <tr><th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>内容：</th><td colspan="5"><textarea class="Iw450 Ih80" name="content" id="content"></textarea> &nbsp;&nbsp;<span id='contentTip'></span></td></tr>
								<tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：</th>
									<td>
										<input type="text" value="0" class="Iw290" name='listorder' id='listorder'/>&nbsp;<span id='memberTip'></span>
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
</body>
</html>
<?php }
}
