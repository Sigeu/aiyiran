<?php
/* Smarty version 3.1.30, created on 2017-02-20 10:43:42
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\steleauthor.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58aa57dec4b5d9_36787213',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b37c091fd828f13fd3289f7a144041f6e62557b' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\steleauthor.html',
      1 => 1487558590,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58aa57dec4b5d9_36787213 (Smarty_Internal_Template $_smarty_tpl) {
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
                 <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/mshow/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">隐私管理</a></dt>
                 <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/eulogy/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">祭文悼词管理</a></dt>
                 <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/epitaph/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">墓志铭管理</a></dt>
				 <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/steleauthor/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">立碑人信息</a></dt>
                </dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/steleauthor/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;立碑人参考范例：</th>
									<td>
									<select name="epitaphDemo" id="epitaphDemo">
                                      <option value="">请选择</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['steleauthorDemo']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
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
                                <tr><th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;立碑人信息：</th><td colspan="3"><textarea class="Iw450 Ih80" name="steleauthor" id="steleauthor"><?php echo $_smarty_tpl->tpl_vars['info']->value['steleauthor'];?>
</textarea> &nbsp;&nbsp;</td></tr>
							    <input type="hidden" name="mid" value="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
"/>
                            </table>
							<div class="pubTabelBot"><input type="submit" name="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
memorial/hall/index'"></div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php echo '<script'; ?>
>
$(function(){
  $("#epitaphDemo").change(function(){
    if(this.value == '' || this.value == null) return;
    $("#steleauthor").val(this.value)
  })
})
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
