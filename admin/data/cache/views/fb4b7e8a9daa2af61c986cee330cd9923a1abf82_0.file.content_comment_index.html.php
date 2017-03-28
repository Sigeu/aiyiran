<?php
/* Smarty version 3.1.30, created on 2017-01-06 16:50:36
  from "D:\xampp\htdocs\aiyiran\admin\template\content\comment\content_comment_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f5a5ce7a0a2_24683591',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fb4b7e8a9daa2af61c986cee330cd9923a1abf82' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\content\\comment\\content_comment_index.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_586f5a5ce7a0a2_24683591 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<!--  artdialog插件  -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/plugins/iframeTools.source.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 language="javascript"> 
<!-- 
function goCf(){
    window.location.href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/index/status/3" 
}
function goRf(){
	window.location.href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/index/is_reply/2" 
}
--> 
<?php echo '</script'; ?>
>

</head>
<body>


<form method="post" id="_C_F" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/index/status/3"><input type="hidden" name="status" value="3" /><input type="hidden" name="tab" value="2" /></form>
<form method="post" id="_R_F" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/index/is_reply/2"><input type="hidden" name="is_reply" value="2" /><input type="hidden" name="tab" value="3" /></form>
	<div class="pubBox">
		<div class="pubtabBox">
			<div class="TabBoxT">
			<dl class="navTab">
			<dt <?php if ($_smarty_tpl->tpl_vars['pflag']->value == 1) {?>class="on"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/index/tab/1">评论管理</a></dt>
            <dt <?php if ($_smarty_tpl->tpl_vars['pflag']->value == 2) {?>class="on"<?php }?>><a href="javascript:;" onclick="goCf()">审核评论</a></dt>
            <dt <?php if ($_smarty_tpl->tpl_vars['pflag']->value == 3) {?>class="on"<?php }?>><a href="javascript:;" onclick="goRf()">回复评论</a></dt>

			</dl>
			</div>
			<div class="TabBoxC">
				<div>
					<div class="pubTabelTot">
						<!--  搜索表单  -->
						<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/index<?php if ($_smarty_tpl->tpl_vars['pflag']->value == 1) {?>/tab/1<?php }
if ($_smarty_tpl->tpl_vars['pflag']->value == 2) {?>/status/<?php echo $_smarty_tpl->tpl_vars['search']->value['status'];
}
if ($_smarty_tpl->tpl_vars['pflag']->value == 3) {?>/is_reply/<?php echo $_smarty_tpl->tpl_vars['search']->value['is_reply'];
}?>">
							<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['title'];?>
" name='title' class="Iw215 text-tips" tips="请输入主题关键字">&nbsp;&nbsp;

							<select name="status">
								<option value="0">请选择审核状态</option>
								<option value="1" <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 1) {?>selected<?php }?>>审核通过</option>
								<option value="2" <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 2) {?>selected<?php }?>>审核不通过</option>
								<option value="3" <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 3) {?>selected<?php }?>>待审核</option>
							</select>

							<select name="is_reply">
								<option value="0">请选择回复状态</option>
								<option value="1" <?php if ($_smarty_tpl->tpl_vars['search']->value['is_reply'] == 1) {?>selected<?php }?>>已回复</option>
								<option value="2" <?php if ($_smarty_tpl->tpl_vars['search']->value['is_reply'] == 2) {?>selected<?php }?>>未回复</option>
							</select>
							<input type="submit" hidefocus="hide" value="搜 索" class="btn5">
						</form>
					</div>

					<!--  列表批量操作  -->
					<form method="post" id="list-form" action="javascript:;" enctype="multipart/form-data">
					<div class="pubTabel">
					<table class="tabelTB" id="search-list">
					<tr>
					<th width="5%">选择</th>
					<th width="35%">原文标题</th>
					<th width="10%">评论人</th>
					<th width="15%">评论时间</th>
					<th width="10%">评论状态</th>
					<th width="10%">回复状态</th>
					<th width="15%">操作</th>
					</tr>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['plist']->value['list'], 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>				
					<tr>
					<td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['comment_id'];?>
" name="id[]"/></td>
					<td><a href="/content/Content/index/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['art_id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['l']->value['title'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['l']->value['title'];?>
</a></td>
					<td><?php if ($_smarty_tpl->tpl_vars['l']->value['username']) {
echo $_smarty_tpl->tpl_vars['l']->value['username'];
} else { ?>未知<?php }?></td>
					<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['l']->value['comment_time'],"%Y-%m-%d %H:%M:%S");?>
</td>
					<td>
					<?php if ($_smarty_tpl->tpl_vars['l']->value['comment_status'] == 1) {?>审核通过<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['l']->value['comment_status'] == 2) {?>审核不通过<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['l']->value['comment_status'] == 3) {?>待审核<?php }?>
					</td>
					<td>
					<?php if ($_smarty_tpl->tpl_vars['l']->value['reply_isreply'] == 1) {?>已回复<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['l']->value['reply_isreply'] == 2) {?>未回复<?php }?>
					</td>
					<td><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/view/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['comment_id'];
if ($_smarty_tpl->tpl_vars['pflag']->value == 1) {?>/tab/1<?php }
if ($_smarty_tpl->tpl_vars['pflag']->value == 2) {?>/status/<?php echo $_smarty_tpl->tpl_vars['search']->value['status'];
}
if ($_smarty_tpl->tpl_vars['pflag']->value == 3) {?>/is_reply/<?php echo $_smarty_tpl->tpl_vars['search']->value['is_reply'];
}?>">查看</a> | <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/reply/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['comment_id'];
if ($_smarty_tpl->tpl_vars['pflag']->value == 1) {?>/tab/1<?php }
if ($_smarty_tpl->tpl_vars['pflag']->value == 2) {?>/status/<?php echo $_smarty_tpl->tpl_vars['search']->value['status'];
}
if ($_smarty_tpl->tpl_vars['pflag']->value == 3) {?>/is_reply/<?php echo $_smarty_tpl->tpl_vars['search']->value['is_reply'];
}?>">回复</a> | <a href="javascript:;" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/del/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['comment_id'];
if ($_smarty_tpl->tpl_vars['pflag']->value == 1) {?>/tab/1<?php }
if ($_smarty_tpl->tpl_vars['pflag']->value == 2) {?>/status/<?php echo $_smarty_tpl->tpl_vars['search']->value['status'];
}
if ($_smarty_tpl->tpl_vars['pflag']->value == 3) {?>/is_reply/<?php echo $_smarty_tpl->tpl_vars['search']->value['is_reply'];
}?>')">删除</a></td>
					</tr>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</table>
					</div>
					<div class="pubOperate"><span class="btn5">
					<label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/> 全选/反选</label>
					</span>
					<input type="button" class="btn5" value="审核通过" onclick="batchOperate(this)"  form-id="list-form" container-id="search-list" form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/passfail/s/1"  empty-tips="请选择要审核的信息！" confirm-tips="你确定要审核通过吗?"/>

					<input type="button" class="btn5" value="审核不通过" onclick="batchOperate(this)"  form-id="list-form" container-id="search-list" form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/passfail/s/2"  empty-tips="请选择要审核的信息！" confirm-tips="你确定要审核不通过吗?"/>

					<input type="button" class="btn5" value="删除" onclick="batchOperate(this)"  form-id="list-form"  container-id="search-list" form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/del"  empty-tips="请选择要删除的信息！" confirm-tips="你确定要删除?"/>
					</div>
					</form>
					<div class="pubTabelBot">
					<div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['plist']->value['pagestr'];?>
</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html><?php }
}
