<?php
/* Smarty version 3.1.30, created on 2017-01-06 14:52:52
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\goods\modules_goodssort_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f3ec4a79bf1_07218931',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd4824ef069618462accb70ec682f12822787a5e' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\goods\\modules_goodssort_index.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_586f3ec4a79bf1_07218931 (Smarty_Internal_Template $_smarty_tpl) {
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
<style type="text/css">
	.tabelTBL .level1{border-bottom:1px dashed #CCCCCC;}
</style>
</head>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="javascript:;">商品分类</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodssort/add" class="last">添加分类</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
			<form method="post" action="javascript:;" id="batch-form" enctype="multipart/form-data">
              <table class="tabelTB tableTB_Xtal mt10" id="search-list">
                <tr style="border-bottom:1px solid #CCD9E4;"><!--  表头  -->
                  <th width="10%">选择</th>
                  <th width="8%">ID</th>
                  <th width="44%">分类名称</th>
                  <th width="8%">排序</th>
                  <th width="10%">商品数量</th>
                  <th width="20%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sort_tree']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<tr class="<?php echo $_smarty_tpl->tpl_vars['l']->value['class'];?>
" style="display:<?php echo $_smarty_tpl->tpl_vars['l']->value['show_hide'];?>
" child_count="<?php echo $_smarty_tpl->tpl_vars['l']->value['child_count'];?>
">
					<td><input type="checkbox" name="sort[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
" /></td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
</td>
					<td class="tal"><div class="<?php echo $_smarty_tpl->tpl_vars['l']->value['flag'];?>
" style="margin-left:<?php echo $_smarty_tpl->tpl_vars['l']->value['margin_left'];?>
px"><?php echo $_smarty_tpl->tpl_vars['l']->value['sortname'];?>
</div></td>
					<td style="text-align:center"><input type="text" style="text-align:center;" class="Iw45" name="ordernum[<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
][<?php echo $_smarty_tpl->tpl_vars['l']->value['ordernum'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['ordernum'];?>
"></td>
					<td style="text-align:center"><?php echo $_smarty_tpl->tpl_vars['l']->value['goods_numbers'];?>
</td>
					<td style="text-align:center">
					<a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodssort/add/sortid/<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
">添加子分类</a> | 
					<?php if ($_smarty_tpl->tpl_vars['l']->value['isdefault'] == 1) {?><span style="color:#A5A5A5">修改</span><?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodssort/edit/sortid/<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
">修改</a><?php }?> | 
					<?php if ($_smarty_tpl->tpl_vars['l']->value['isdefault'] == 1) {?><span style="color:#A5A5A5">删除</span><?php } else { ?><a href="javascript:;" onclick="deleteSort('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodssort/del/sortid/<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
',<?php echo $_smarty_tpl->tpl_vars['l']->value['goods_numbers'];?>
)">删除</a><?php }?>
					</td>
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
              <input type="button" class="btn5" value="更新排序" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodssort/updateOrder" empty-tips="请选择要进行排序的记录！" is-selected="false" />
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
	function deleteSort (url,num)
	{
		
		var tip = (num == '0') ? '你确定删除吗？' : '此分类下存在商品，如删除分类所有商品将转移到默认分类下，确定删除？';
		//tip = '删除分类会将该分类下所有商品将转移到默认分类下，确定删除？';
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

	$(function()
	{
		//收起，折叠效果
		$("#search-list tr:gt(0)").find('td:eq(2)').bind('click',function()
		{
			var tr = $(this).parent('tr');//被点击的TR
			var c_index = tr.index();//被点击TR的索引号
			var c_child = parseInt(tr.attr('child_count'));//TR的子集个数
			if(c_child == '0') return;
			var div = $(this).find('div');//折叠符所在元素
			var s_class = div.attr('class');//折叠符所在元素last class 
			var n_class = (s_class == 'open') ? 'clos' : 'open';//折叠符所在元素new class 
			div.removeClass(s_class).addClass(n_class);//切换样式

			if (n_class == 'open')
				tr.attr('bgcolor','#FFF7F2');
			else
				tr.attr('bgcolor','#F7F7F7');

			for (var i=1;i<= c_child;i++)
			{
				var _tr = $("#search-list tr:eq("+(c_index+i)+")");
				var _div = _tr.find('td:eq(2)').find('div');
				var _s_class = _div.attr('class');
				if (n_class == 'open')
					_tr.show();
				else
					_tr.hide();
				if (_s_class != 'no')
					_div.removeClass().addClass(n_class);
			}
		});
	});
<?php echo '</script'; ?>
>
<?php }
}
