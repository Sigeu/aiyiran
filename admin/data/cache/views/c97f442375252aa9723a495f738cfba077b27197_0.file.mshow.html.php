<?php
/* Smarty version 3.1.30, created on 2017-02-20 11:21:29
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\mshow.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58aa60b9a28041_52640275',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c97f442375252aa9723a495f738cfba077b27197' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\mshow.html',
      1 => 1487560882,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58aa60b9a28041_52640275 (Smarty_Internal_Template $_smarty_tpl) {
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
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/info/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">逝者资料管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/biography/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">传记管理</a></dt>
                    <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/mshow/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">隐私管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/eulogy/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">祭文悼词管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/epitaph/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">墓志铭管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/steleauthor/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">立碑人信息</a></dt>
                </dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/mshow' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
            
							

								<tr>
									<th width="200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;查看权限：</th>
									<td>
                                     <span><input type="radio" name="isshow" value="1"<?php if ($_smarty_tpl->tpl_vars['info']->value['isshow'] == 1) {?>checked<?php }?> /><label>完全公开</label></span>
									 <span><input type="radio" name="isshow" value="2"<?php if ($_smarty_tpl->tpl_vars['info']->value['isshow'] == 2) {?>checked<?php }?> /><label>仅馆主可见</label></span>
									</td>
								</tr>
                                <input type="hidden" name="mid" value="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
"/>
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
