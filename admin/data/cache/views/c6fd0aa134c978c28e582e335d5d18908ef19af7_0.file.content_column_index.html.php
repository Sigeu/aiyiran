<?php
/* Smarty version 3.1.30, created on 2016-12-19 12:03:20
  from "D:\xampp\htdocs\aiyiran\admin\template\content\column\content_column_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58575c08e09a92_19077460',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c6fd0aa134c978c28e582e335d5d18908ef19af7' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\content\\column\\content_column_index.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58575c08e09a92_19077460 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>广告模块-商品分类</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
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
	.tabelTBL .level1{border-bottom-style:dashed;border-bottom-color:#CCC;border-bottom-width:1px;}
</style>
</head>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="javascript:;">栏目列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/add" class="last">添加栏目</a></dd>
			<?php if (in_array('103',$_smarty_tpl->tpl_vars['mypermissionid']->value) || ($_smarty_tpl->tpl_vars['roleid']->value == 1)) {?>
			<dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/batch" class="last">批量增加栏目</a></dd>
			<?php } else { ?>
			<dd><a href="javascript:alert('对不起，您没有该权限')" class="last">批量增加栏目</a></dd>
			<?php }?>
			<dd class="add"><a href="javascript:;" onclick="updateColumnCache()">更新栏目缓存</a></dd>
			<dd class="add"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/issue/column">发布栏目页</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
			<form method="post" action="javascript:;" id="batch-form" enctype="multipart/form-data">
              <table class="tabelTB tableTB_Xtal mt10" id="search-list">
                <tr style="border-bottom:1px solid #CCD9E4;"><!--  表头  -->
                  <th width="5%">选择</th>
                  <th width="8%">ID</th>
                  <th width="31%">栏目名称</th>
                  <th width="11%">模型</th>
                  <th width="9%">排序</th>
                  <th width="7%">信息数量</th>
                  <th width="29%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cat_tree']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<tr class="<?php echo $_smarty_tpl->tpl_vars['l']->value['class'];?>
" style="display:<?php echo $_smarty_tpl->tpl_vars['l']->value['show_hide'];?>
" child_count="<?php echo $_smarty_tpl->tpl_vars['l']->value['child_count'];?>
">
					<td><input type="checkbox" name="column[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" /></td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
</td>
					<td class="tal"><div class="<?php echo $_smarty_tpl->tpl_vars['l']->value['flag'];?>
" style="margin-left:<?php echo $_smarty_tpl->tpl_vars['l']->value['margin_left'];?>
px"><?php echo $_smarty_tpl->tpl_vars['l']->value['catname'];?>
</div></td>
					<td>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['model']->value, 'm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['m']->value) {
?>
						<?php if ($_smarty_tpl->tpl_vars['m']->value['id'] == $_smarty_tpl->tpl_vars['l']->value['model']) {
echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['m']->value['name'],8,"...",true);
}?>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</td>
					<td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['ordernum'];?>
" name="ordernum[<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
]" class="Iw45" style="text-align:center;"></td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['cont_num'];?>
</td>
					<td><a href="<?php echo @constant('HOST_NAME');?>
index.php/category/Category/index/cid/<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['l']->value['catname'];?>
" target="_blank">预览</a> | <a href="<?php echo @constant('HOST_NAME');?>
admin/<?php if ($_smarty_tpl->tpl_vars['l']->value['model'] == 2) {?>modules/goods/index/categroy<?php } else { ?>content/Content/index/categoryid<?php }?>/<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
">内容</a> | <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/add/catid/<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
">添加子分类</a> | <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/edit/catid/<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
">修改</a> | <a href="javascript:;" onclick="deleteColumn('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/del/catid/<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
',<?php echo $_smarty_tpl->tpl_vars['l']->value['cont_num'];?>
)">删除</a> | <a href="javascript:;" onclick="moveToCatgory(<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
)">移动</a></td>
				</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
			</form>
            </div>
            <div class="pubTabelBot pubTabelBot_X" style="text-align:left;">
			
				<span class="btn5" style="width:80px;"><label>
					<input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/>全选/反选
				</label></span>
              <input type="button" class="btn5" value="更新排序" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/updateOrder" empty-tips="请选择要进行排序的记录！" is-selected="false" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
</body>
</html>

<div class="notif" id="move_block" style="display:none;">
	<div class="pubTabel">
		<table class="tabelTB tabelTB_X">
			<tr>
				<td style="padding-left:10px;">栏目：</td>
				<td><select class="Iw290" id="catrgory" style="width:302px;">
				<option value="0">顶级栏目</option>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cat_temp']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['catname'];?>
</option>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

				</select>&nbsp;&nbsp;&nbsp;</td>
			</tr>
		</table>
	</div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">	
	function moveToCatgory (id)
	{
        var hasper = <?php echo $_smarty_tpl->tpl_vars['hasper']->value;?>
;
        if(!hasper)
        {
          alert("对不起,你没有操作权限");
        } else {
            art.dialog.open('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/moveto/cid/'+id, 
            {
                id: 'move_dialog',
                fixed: true,
                width:400,
                title:'移动分类',
                height:'auto'
            });
        }
	}

	//返回父页面
	function backParent ()
	{
		window.parent.$("#rightMain").attr('src','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/remind/tpl');
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

function deleteColumn (url,num)
{
	var tip = (num == '0') ? '你确定删除吗？' : '删除的栏目下有内容，请先删除栏目下的内容再删除栏目';
	var throughBox = art.dialog.through;
	throughBox({content: tip,icon:'question',lock:true,fixed:true},function()
	{
		if(num == '0')
			window.location.href=url;
		else
			return true;
	},
	function()
	{
		//art.dialog.tips('你取消了操作');
	});
}

function updateColumnCache ()
{
	$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/updatecache',{},function()
	{
		art.dialog.alert('更新栏目缓存成功');
	});
}

/*function moveToCatgory (id)
{
	//弹出移动到对话框
	var move = art.dialog.through(
	{
		content: document.getElementById('move_block'),//对话框内容来源
		     id: 'move_block',
		  title: '移动到栏目',
		 button: 
			[
				{
					name: '确定',
					callback: function () 
					{
						var top = art.dialog.top;// 引用顶层页面window对象
						var pid = top.document.getElementById('catrgory').value;

						//给出数据请求提示
						var t1 = art.dialog.through({content:'正在请求数据，请稍后...',icon:'question',lock:true,fixed:true},function()
						{
							return true;
						});
						//请求后台
						$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/moveto',{'id':id,'pid':pid},function(d)
						{
							t1.close();//关闭提示框
							move.close();
							if(d == 'success')
								location.reload();
							else if(d == 'fail')
							    art.dialog.tips('移动失败，不能选择本身和本身的子集作为父集');
							else 
								art.dialog.tips(d);
							return true;
						});
						return false;
					},
					focus: true
				},
				{
					name: '取消',
					callback: function () 
					{
						return true;
					}
				}
			]
	});
}*/
<?php echo '</script'; ?>
>
<?php }
}
