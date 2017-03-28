<?php
/* Smarty version 3.1.30, created on 2017-03-13 17:12:45
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\order\addSystemMessage.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c6628d361fa7_92485263',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d245c25e0cebec835f3436f239f9192278fb867' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\order\\addSystemMessage.html',
      1 => 1489396364,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58c6628d361fa7_92485263 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>
$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:false,generalwordwide:true});
	
	$("#name").formValidator({empty:false,onshow:"请输入2-50字符",onfocus:"请输入2-50字符",oncorrect:"输入正确"})
	.inputValidator({min:2,max:50,onerror:"请输入2-50字符"});

	$("#content").formValidator({empty:false,onshow:"请输入2-50字符",onfocus:"请输入2-50字符",oncorrect:"输入正确"})
			.inputValidator({min:2,max:50,onerror:"请输入2-50字符"});
 })
<?php echo '</script'; ?>
>
<body>
	<div class="pubBox" >
		<div class="pubtabBox">
			<div class="TabBoxT">
				<dl class="navTab">
					<dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/systemMessage">消息列表</a></dd>
					<dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/addSystemMessage"  class="last">添加消息</a></dt>
				</dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/addSystemMessage' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>标题：</th>
									<td>
										<input type="text" value="" class="Iw290" name='title' id='name'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>

								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>内容：</th>
									<td>
										<textarea name="content" id="content" cols="50" rows="10"></textarea>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>
                              
							</table>
							<div class="pubTabelBot"><input type="submit" name="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/systemMessage'"></div>
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
