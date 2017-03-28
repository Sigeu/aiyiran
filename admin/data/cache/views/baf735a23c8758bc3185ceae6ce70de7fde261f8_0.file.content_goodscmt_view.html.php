<?php
/* Smarty version 3.1.30, created on 2017-02-07 10:35:00
  from "D:\xampp\htdocs\aiyiran\admin\template\content\goodscmt\content_goodscmt_view.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_589932544b49f1_92860338',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'baf735a23c8758bc3185ceae6ce70de7fde261f8' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\content\\goodscmt\\content_goodscmt_view.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_589932544b49f1_92860338 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/goodscmt/view">
<div class="pubBox">
  <div class="pubtabBox">
	<div class="TabBoxT">
	  <dl class="navTab">
		<dt class="on"><a href="#">评论管理</a></dt>
		<dd class="right">
		<div class="pageGo">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ln']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
		<?php if ($_smarty_tpl->tpl_vars['l']->value['id']) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/goodscmt/view/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['text'];?>
</a>
		<?php } else { ?><a href="JavaScript:;"><?php echo $_smarty_tpl->tpl_vars['l']->value['text'];?>
</a><?php }?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</div>
		</dd>
	  </dl>
	 <div class="clearfix"></div>
	</div>
	<div class="TabBoxC">
	  <div>
		<div class="pubTabel">
		  <table class="tabelLR">
			<tr>
			  <th width="120px">&nbsp; 原文标题：</th>
			  <td><?php echo $_smarty_tpl->tpl_vars['info']->value['title'];?>
</td>
			</tr>
			<tr>
			  <th>&nbsp; 审核状态：</th>
			  <td>
			  <?php if ($_smarty_tpl->tpl_vars['info']->value['comment_status'] == 1) {?>审核通过
			  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['comment_status'] == 2) {?>审核不通过
			  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['comment_status'] == 3) {?>待审核
			  <?php }?>
			  </td>
			</tr>
			<tr>
			  <th>&nbsp; 评论人：</th>
			  <td><?php if ($_smarty_tpl->tpl_vars['info']->value['username']) {
echo $_smarty_tpl->tpl_vars['info']->value['username'];
} else { ?>未知<?php }?></td>
			</tr>
			<tr>
			  <th>&nbsp; 评论时间：</th>
			  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['info']->value['comment_time'],"%Y-%m-%d %H:%M:%S");?>
</td>
			</tr>
			<tr>
			  <th valign="top">&nbsp; 评论内容：</th>
			  <td><textarea class="Iw450 Ih80"><?php echo $_smarty_tpl->tpl_vars['info']->value['comment_content'];?>
</textarea></td>
			</tr>
			<tr>
			  <th valign="top">&nbsp; 管理员回复：</th>
			  <td><textarea class="Iw450 Ih80" name="reply_content"><?php echo $_smarty_tpl->tpl_vars['info']->value['reply_content'];?>
</textarea></td>
			</tr>
		  </table>
		</div>
		<div class="pubTabelBot">
			<input type="hidden" name="comment_id" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['comment_id'];?>
" />
			<input type="hidden" name="comment_status" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['comment_status'];?>
" id="status"/>
			<?php if ($_smarty_tpl->tpl_vars['info']->value['comment_status'] == 3) {?>
			<input type="button" hidefocus="hide" value="审核通过" onclick="checkPass()" class="btn1">
			<input type="button" hidefocus="hide" value="审核不通过" onclick="checkFail()" class="btn2">
			<?php } else { ?>
			<input type="button" value="返回" onclick="javascript:location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/goodscmt/index<?php if ($_smarty_tpl->tpl_vars['pflag']->value == 1) {?>/tab/1<?php }
if ($_smarty_tpl->tpl_vars['pflag']->value == 2) {?>/status/<?php echo $_smarty_tpl->tpl_vars['search']->value['status'];
}
if ($_smarty_tpl->tpl_vars['pflag']->value == 3) {?>/is_reply/<?php echo $_smarty_tpl->tpl_vars['search']->value['is_reply'];
}?>';" class="btn2">
			<?php }?>
		  </div>
	  </div>
	</div>
  </div>
</div>
</form>
<div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
//审核通过
function checkPass ()
{
	art.dialog.through({content: '您确定通过此评论吗？',icon:'question',lock:true,fixed:true},function()
	{
		$('#status').val(1);
		$('form').submit();
	},
	function()
	{
		
	});
}

//审核不通过
function checkFail ()
{
	art.dialog.through({content: '您确定审核不通过此评论吗？',icon:'question',lock:true,fixed:true},function()
	{
		$('#status').val(2);
		$('form').submit();
	},
	function()
	{
		
	});
}
<?php echo '</script'; ?>
><?php }
}
