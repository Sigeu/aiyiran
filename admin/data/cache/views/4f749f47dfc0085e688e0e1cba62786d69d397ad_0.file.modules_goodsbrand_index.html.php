<?php
/* Smarty version 3.1.30, created on 2017-01-06 14:52:51
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\goods\modules_goodsbrand_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f3ec3b9a722_50571895',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4f749f47dfc0085e688e0e1cba62786d69d397ad' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\goods\\modules_goodsbrand_index.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_586f3ec3b9a722_50571895 (Smarty_Internal_Template $_smarty_tpl) {
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
            <dt class="on"><a href="javascript:;">商品品牌</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodsbrand/add" class="last">添加品牌</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
			<form method="post" action="javascript:;" id="batch-form" enctype="multipart/form-data">
              <table class="tabelTB tableTB_Xtal mt10" id="search-list">
                <tr style="border-bottom:1px solid #CCD9E4;"><!--  表头  -->
                  <th width="10%">选择</th>
                  <th width="40%">品牌名称</th>
                  <th width="14%">商品数量</th>
                  <th width="16%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['plist']->value['list'], 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<tr class="level2">
					<td><input type="checkbox" name="brandid[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['brandid'];?>
" /></td>
					<td style="text-align:center"><?php echo $_smarty_tpl->tpl_vars['l']->value['brandname'];?>
</td>
					<td style="text-align:center"><?php echo $_smarty_tpl->tpl_vars['l']->value['goods_numbers'];?>
</td>
					<td style="text-align:center"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodsbrand/edit/brandid/<?php echo $_smarty_tpl->tpl_vars['l']->value['brandid'];?>
">修改</a> | 
					<a href="javascript:;" onclick="deleteBrand('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodsbrand/del/brandid/<?php echo $_smarty_tpl->tpl_vars['l']->value['brandid'];?>
/bname/<?php echo $_smarty_tpl->tpl_vars['l']->value['brandname'];?>
',<?php echo $_smarty_tpl->tpl_vars['l']->value['goods_numbers'];?>
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
              <label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/>
              全选/反选</label>
              </span>
              <input type="button" class="btn5" value="删除" onclick="bacchDelete(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodsbrand/del" empty-tips="请选择要删除的记录！" confirm-tips="品牌下存在商品时，如删除品牌原有商品品牌为空，确定删除？"/>
            </div>
			<div class="pubTabelBot">
			<div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['plist']->value['pagestr'];?>
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
function deleteBrand (url,num)
{
	var tip = (num == '0') ? '你确定删除吗？' : '此品牌下存在商品，如删除品牌原有商品品牌为空，确定删除？';
	var throughBox = art.dialog.through;
	throughBox({content: tip,icon:'question',lock:true,fixed:true},function()
	{
		window.location.href=url;
		if(request_state)
			this.content('正在请求数据，请稍后...');
		else
			this.close();
		return false;
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
/modules/goodsbrand/ajaxcheck',{'ids':ids.join(',')},function(d)
	{
		if (d > 0)
			var confirm_tips = '此品牌下存在商品，如删除品牌原有商品品牌为空，确定删除？';
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
>
<?php }
}
