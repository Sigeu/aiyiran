<?php
/* Smarty version 3.1.30, created on 2017-01-06 14:52:58
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\goods\modules_goodstype_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f3eca8af1b5_04823256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd313a0f8c2e40202e5e29dc00058243452474a0' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\goods\\modules_goodstype_index.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_586f3eca8af1b5_04823256 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleX.css" rel="stylesheet" type="text/css"/>
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
            <dt class="on"><a href="javascript:;">商品属性</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodstype/add" class="last">添加属性</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
			<form method="post" action="javascript:;" id="batch-form" enctype="multipart/form-data">
              <table class="tabelTB tableTB_Xtal mt10" id="search-list">
                <tr style="border-bottom:1px solid #CCD9E4;"><!--  表头  -->
                  <th width="10%">选择</th>
                  <th width="40%">属性名称</th>
                  <th width="14%">商品数量</th>
                  <th width="16%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['plist']->value['list'], 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<tr class="level2">
					<td><input type="checkbox" name="typeid[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['typeid'];?>
" /></td>
					<td style="text-align:center"><?php echo $_smarty_tpl->tpl_vars['l']->value['typename'];?>
</td>
					<td style="text-align:center"><?php echo $_smarty_tpl->tpl_vars['l']->value['attr_number'];?>
</td>
					<td style="text-align:center"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodsfield/index/typeid/<?php echo $_smarty_tpl->tpl_vars['l']->value['typeid'];?>
">字段管理</a> | <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodstype/edit/typeid/<?php echo $_smarty_tpl->tpl_vars['l']->value['typeid'];?>
">修改</a> | 
					<a href="javascript:;" onclick="deleteType('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodstype/del/typeid/<?php echo $_smarty_tpl->tpl_vars['l']->value['typeid'];?>
',<?php echo $_smarty_tpl->tpl_vars['l']->value['attr_number'];?>
)">删除</a></td>
				</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
			</form>
            </div>
            <div class="pubTabelBot pubTabelBot_X" style="text-align:left;"><span class="btn5" style="width:80px;">
              <label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/>全选/反选</label></span>
              <input type="button" class="btn5" value="删除"
			  onclick="bacchDelete(this)"
			  form-id="batch-form"
			  container-id="search-list"
			  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodstype/del"
			  empty-tips="请选择要删除的记录！"
			  confirm-tips="删除商品属性会使相关商品属性为空，你确定要删除吗？"/>
            </div>
          </div>
        </div>
		<div class="pubTabelBot">
		<div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['plist']->value['pagestr'];?>
</div>
		</div>
      </div>
    </div>
    <div class="clearfix"></div>
</body>
</html>

<?php echo '<script'; ?>
 type="text/javascript">
function deleteType (url,num)
{
	var tip = (num == '0') ? '确定删除？' : '有商品正在使用此属性，您确定要删除？';
	var throughBox = art.dialog.through;
	throughBox({content: tip,icon:'question',lock:true,fixed:true},function()
	{
		window.location.href=url;
	},
	function()
	{
		//art.dialog.tips('你取消了操作');
	});
}

//属性批量删除
function bacchDelete (obj)
{
	var _obj = $(obj);
	var checked = $('#'+_obj.attr('container-id')+' input:checkbox:checked');  //选中的复选框数量
	if (!checked.length)
	{
		art.dialog.alert('请选择要删除的记录！','warning');
		return false;
	}
	var ids = new Array();
	$.each(checked,function(i,n)
	{
		ids.push($(n).val());
	});
	$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodstype/ajaxcheck',{'ids':ids.join(',')},function(d)
	{
		if (d > 0)
			var confirm_tips = '有商品正在使用此属性，您确定要删除？';
		else 
			var confirm_tips = '确定删除？';

		var throughBox = art.dialog.through;
		throughBox({content: confirm_tips,lock:true,fixed:true,icon:'question'},function()
		{
			$('#'+_obj.attr('form-id')).attr('action',_obj.attr('form-action')).submit();
			return true;
		},
		function()
		{
			//art.dialog.tips('你取消了操作');
		});
	});
}
<?php echo '</script'; ?>
><?php }
}
