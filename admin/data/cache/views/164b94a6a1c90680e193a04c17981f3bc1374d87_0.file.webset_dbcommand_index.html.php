<?php
/* Smarty version 3.1.30, created on 2017-02-08 15:55:17
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\dbm\webset_dbcommand_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_589acee5cf1b57_55387085',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '164b94a6a1c90680e193a04c17981f3bc1374d87' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\dbm\\webset_dbcommand_index.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589acee5cf1b57_55387085 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>数据库备份还原</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleL.css" rel="stylesheet" type="text/css"/>
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
</head>
<body>
<div class="pubBox">
		<div class="pubtabBox">
			<div class="TabBoxT">
					<dl class="navTab">
						<dt class="on"><a href="#">SQL命令执行器</a></dt>	
					</dl>
			</div>
			<div class="TabBoxC">
				<div >
                    <div class="pubTabel">
                            <table class="tabelLR">
                              <tr>
                                <th width="145px"  style="vertical-align:top"> 操作数据表：</th>
                                <td>
								<form method="post" action="javascript:;" id="table-form">
                                	<input class="Iw215 text-tips" tips="请输入要搜索的系统表名"  type="text" name="search_name" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['name'];?>
"/>  <input class="btn5" type="button" value="搜  索" hideFocus="hide" onclick="batchOperate(6)"/><br/><br />
                                    <div class="linebkL">
                                        <select multiple="multiple" name="name[]" style="width:296px;height:130px;">
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['table_info']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['Name'];?>
" <?php if (in_array($_smarty_tpl->tpl_vars['l']->value['Name'],$_smarty_tpl->tpl_vars['table']->value)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value['Name'];?>
</option>
											<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                        </select>   
                                    </div>    
                                    <div class="linebkL dkForiptL" style="vertical-align:top;">
                                        <input class="btn5" type="button" value="优化选中表" hideFocus="hide" onclick="batchOperate(1)"/>
                                        <input class="btn5" type="button" value="优化全部表" hideFocus="hide" onclick="batchOperate(2)"/><br/>
                                        <input class="btn5" type="button" value="修复选中表" hideFocus="hide" onclick="batchOperate(3)"/>
                                        <input class="btn5" type="button" value="修复全部表" hideFocus="hide" onclick="batchOperate(4)"/><br/> 
                                        <input class="btn5" type="button" value="查看表结构" hideFocus="hide" onclick="batchOperate(5)"/> 
                                    </div> 
                                </td>
                              </tr>
                              <tr>
                                <th style="vertical-align:top"><font>*</font> 结果信息：</th>
                                <td>
								<textarea style="width:558px;height:105px;"><?php echo $_smarty_tpl->tpl_vars['result']->value;
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['res']->value, 'l', false, NULL, 'myinfo', array (
  'first' => true,
  'total' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_myinfo']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_myinfo']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_myinfo']->value['index'];
if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_myinfo']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_myinfo']->value['first'] : null)) {?>共<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_myinfo']->value['total']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_myinfo']->value['total'] : null);?>
条记录<?php }
echo $_smarty_tpl->tpl_vars['br']->value;?>
----------------------------<?php echo $_smarty_tpl->tpl_vars['br']->value;
echo $_smarty_tpl->tpl_vars['br']->value;
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['l']->value, 'r', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['r']->value) {
echo $_smarty_tpl->tpl_vars['k']->value;?>
：<?php echo $_smarty_tpl->tpl_vars['r']->value;
echo $_smarty_tpl->tpl_vars['br']->value;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</textarea><br /></td>
                              </tr>                             
                             <tr>
                                <th style="vertical-align:top"><font>*</font> 运行SQL命令：</th>
                                <td><textarea style="width:558px;height:105px;" name="sql" id="sql"><?php echo $_smarty_tpl->tpl_vars['sql']->value;?>
</textarea><br />友情提示： <br />1、命令行只接受简单的查询语句！复杂操作请登录数据库管理客户端！ <br />2、SQL语句请用分号结束！<br />3、查询语句只能查看100条数据！</td>
                              </tr>         
                            </table> 
							</form>
							 <div class="sql_subL">
                            	 <input class="btn5" type="button" value="单行命令" hideFocus="hide" onclick="batchOperate(7)"/>
                                 <input class="btn5" type="button" value="多行命令" hideFocus="hide" onclick="batchOperate(8)"/>
                            </div>  
                    </div>
				</div>		
			</div>
		</div>
    </div>
    <div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
function batchOperate (action)
{
	var selected_number = $('#table-form select option:selected').length;
	var text;
	var baseurl = "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbcommand/";
	switch (action)
	{
		case 1:
			text = '优化';
			$('#table-form').attr('action',baseurl+'optimize');
			break;
		case 2:
			text = '优化';
			$('#table-form').attr('action',baseurl+'optimizeall');
			break;
		case 3:
			text = '修复';
			$('#table-form').attr('action',baseurl+'repair');
			break;
		case 4:
			text = '修复';
			$('#table-form').attr('action',baseurl+'repairall');
			break;
		case 5:
			text = '查看';
			$('#table-form').attr('action',baseurl+'structure');
			break;
		case 6:
			$('#table-form').attr('action',baseurl+'index');
			break;
		case 7:
			$('#table-form').attr('action',baseurl+'single');
			break;
		case 8:
			$('#table-form').attr('action',baseurl+'many');
			break;
	}
	//点击搜索
	if (action == 6 || action == 7 || action == 8)
	{
		if((action == 7 || action == 8) && $.trim($('#sql').val()) == '') 
		{
			art.dialog.alert('请输入sql命令！', 'warning');
			return false;
		}
		$('#table-form').submit();
			return false;
	}
	//点击其他操作
	if (!selected_number && (action == 1 || action == 3 || action == 5))
	{
		art.dialog.alert('请选择要'+text+'的表！', 'warning');
		return false;
	}
	else 
	{
		if (action == 5)
		{
			$('#table-form').submit();
				return false;
		}
		art.dialog.confirm('你确定要'+text+'吗？', function()
		{
			$('#table-form').submit();
			this.content('正在请求数据，请稍后...');
			return false;
		},
		function()
		{
			//art.dialog.tips('你取消了操作！');
		});
	}
}
<?php echo '</script'; ?>
><?php }
}
