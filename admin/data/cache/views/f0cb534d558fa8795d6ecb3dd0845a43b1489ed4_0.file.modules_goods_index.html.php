<?php
/* Smarty version 3.1.30, created on 2016-12-29 16:08:12
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\goods\modules_goods_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5864c46c8e4391_40514807',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f0cb534d558fa8795d6ecb3dd0845a43b1489ed4' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\goods\\modules_goods_index.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5864c46c8e4391_40514807 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>商品展示</title>
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
</head>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">商品展示</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/add/categroyid/<?php echo $_smarty_tpl->tpl_vars['search']->value['categroy'];?>
" class="last">添加商品</a></dd>  
			<dd class="add"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/issue/column">发布栏目页</a></dd>
			<dd class="add"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/issue/content">发布内容页</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
			<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/index" enctype="multipart/form-data">
            <div class="pubTabelTot">
              <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
" class="Iw190 f999 text-tips" tips="请输入关键字" name="keywords">
              <select class="" name="categroy">
                <option value="">请选择栏目</option>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categroy']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['l']->value['model'] != 2) {?>disabled='true' style="color:#747474"<?php } else { ?>style="color:#1C1C1C"<?php }?> <?php if ($_smarty_tpl->tpl_vars['l']->value['id'] == $_smarty_tpl->tpl_vars['search']->value['categroy']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value['catname'];?>
</option>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </select>

              <select class="" name="sortid">
                <option value="">请选择分类</option>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sort']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
" <?php if ($_smarty_tpl->tpl_vars['l']->value['sortid'] == $_smarty_tpl->tpl_vars['search']->value['sortid']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value['sortname'];?>
</option>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </select>
			  <select name="by" class="">
				<option value="created" <?php if ($_smarty_tpl->tpl_vars['search']->value['by'] == 'created') {?>selected<?php }?>>按发布时间</option>
				<option value="goodsid" <?php if ($_smarty_tpl->tpl_vars['search']->value['by'] == 'goodsid') {?>selected<?php }?>>按信息ID</option>
				<option value="hits" <?php if ($_smarty_tpl->tpl_vars['search']->value['by'] == 'hits') {?>selected<?php }?>>按点击量</option>
				<option value="modification" <?php if ($_smarty_tpl->tpl_vars['search']->value['by'] == 'modification') {?>selected<?php }?>>按更新时间</option>
				<option value="sortnum" <?php if ($_smarty_tpl->tpl_vars['search']->value['by'] == 'sortnum') {?>selected<?php }?>>按排序值</option>
			  </select>
              <select class="Iw290 " style="width:100px;" name="orderby">
                <option value="desc" <?php if ($_smarty_tpl->tpl_vars['search']->value['orderby'] == 'desc') {?>selected<?php }?>>降序</option>
                <option value="asc"  <?php if ($_smarty_tpl->tpl_vars['search']->value['orderby'] == 'asc') {?>selected<?php }?>>升序</option>
              </select>
              <input type="submit" hidefocus="hide" value="搜 索" class="btn5">
            </div>
			</form>
			<form method="post" id="backup-form" action="">
            <div class="pubTabel">
              <table class="tabelTB tableTB_Xtal" id="search-list"> 
                <tr>
                  <th width="4%">选择</th>
                  <th width="6%">ID</th>
                  <th width="32%">商品名称</th>
                  <th width="10%">所属栏目</th>
                  <th width="10%">所属分类</th>
				  <th width="6%">点击量</th>
                  <th width="6%">排序</th>
                  <th width="13%">更新时间</th>
                  <th width="12%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['plist']->value['list'], 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
                <tr>
                  <td><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['goodsid'];?>
"/></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['l']->value['goodsid'];?>
</td>
                  <td><a href="<?php echo @constant('HOST_NAME');?>
index.php/goods/Goods/info/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['goodsid'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['l']->value['goodsname'];?>
" target="_blank"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['l']->value['goodsname'],18,"...",true);?>
</a>
				  <?php if ($_smarty_tpl->tpl_vars['l']->value['isbest'] == 1) {?><span class="f00">[精品]</span><?php }
if ($_smarty_tpl->tpl_vars['l']->value['isnew'] == 1) {?><span class="f00">[新品]</span><?php }
if ($_smarty_tpl->tpl_vars['l']->value['ishot'] == 1) {?><span class="f00">[热销]</span><?php }
if ($_smarty_tpl->tpl_vars['l']->value['isspecial'] == 1) {?><span class="f00">[特卖]</span><?php }?>
				  </td>
                  <td><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['l']->value['catname'],7,"...",true);?>
</td>                 
                  <td><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['l']->value['sortname'],7,"...",true);?>
</td>
				  <td><?php echo $_smarty_tpl->tpl_vars['l']->value['hits'];?>
</td>
                  <td><input type="text" style="text-align:center;" class="Iw45" name="sortnum[<?php echo $_smarty_tpl->tpl_vars['l']->value['goodsid'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['sortnum'];?>
"></td>
                  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['l']->value['modification'],"%Y-%m-%d %H:%M:%S");?>
</td>
                  <td><a href="<?php echo @constant('HOST_NAME');?>
index.php/goods/Goods/info/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['goodsid'];?>
/isadmin/1" target="_blank">预览</a> | <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/edit/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['goodsid'];?>
">修改</a> | 
				  <a href="javascript:;" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/del/id/<?php echo $_smarty_tpl->tpl_vars['l']->value['goodsid'];?>
','你确定删除该商品吗？')">删除</a>
				  </td>
                </tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
			</form>
            <div class="pubOperate"><span class="btn5" style="width:80px;"><label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/> 全选/反选</label></span>
              <input type="button" class="btn5" value="移动到分类" onclick="moveToSort()"/>
              <input type="button" class="btn5" value="更换属性" onclick="updateAttr()"/>
			  <input type="button" class="btn5" value="删除" onclick="batchOperate(this)" form-id="backup-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/del" empty-tips="请选择要进行删除的商品！" confirm-tips="你确定要删除吗？"/>
              <input type="button" is-selected="false" empty-tips="" form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/sortnum" container-id="search-list" form-id="backup-form" onclick="batchOperate(this)" value="更新排序" class="btn5">
            </div>
            <div class="pubTabelBot">
              <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['plist']->value['pagestr'];?>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
/**
 * 移动到分类
 */
function moveToSort ()
{
	$('#goodsid').val($.ext_checkSelected('search-list'));//给id几个输入框赋值
	
	//弹出移动到对话框
	var move = art.dialog.through(
	{
		content: document.getElementById('move_block'),//对话框内容来源
		     id: 'move_block',
		  title: '移动到分类',
		 button: 
			[
				{
					name: '确定',
					callback: function () 
					{
						var top = art.dialog.top;// 引用顶层页面window对象
						var sort_id = top.document.getElementById('sort').value;
						var goods_id = top.document.getElementById('goodsid').value;
						if(goods_id == '')
						{
							art.dialog.alert('请填写商品ID','warning');
							return false;
						}

						//给出数据请求提示
						var t1 = art.dialog.through({content:'正在请求数据，请稍后...',icon:'question',lock:true,fixed:true},function()
						{
							return true;
						});

						//请求后台
						$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/movetosort',{'goodsid':goods_id,'sortid':sort_id},function(d)
						{
							t1.close();//关闭提示框
							move.close();
							if (d == 'success' || d == 'fail')
							{
								location.reload();
							}
							else 
							{
                                d.replace('history.back()', '');
								art.dialog.tips(d);
                                location.href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/index";
							}										
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
}

/**
 * 跟换属性
 */
function updateAttr ()
{
	$('#goodsid_attr').val($.ext_checkSelected('search-list'));//给id几个输入框赋值
	//弹出移动到对话框
	var attr_dialog = art.dialog.through(
	{
		content: document.getElementById('attr_block'),//对话框内容来源
		     id: 'attr_block',
		  title: '更换属性',
		 button: 
			[
				{
					name: '确定',
					callback: function () 
					{
						var top = art.dialog.top;// 引用顶层页面window对象
						var attr = $(top.document).find(':checkbox');
						var _attr = new Array();
						var isbest = 2;
						var isnew = 2;
						var ishot = 2;
						var isspecial = 2;
						$.each(attr,function(i,n)
						{
							_n = $(n);
							_chk = _n.attr('checked');
							switch (_n.attr('name'))
							{
								case 'isbest':
									isbest = (_chk == 'checked') ? 1 : 2;
									break;
								case 'isnew':
									isnew = (_chk == 'checked') ? 1 : 2;
									break;
								case 'ishot':
									ishot = (_chk == 'checked') ? 1 : 2;
									break;
								case 'isspecial':
									isspecial = (_chk == 'checked') ? 1 : 2;
									break;
							}
						});
						var goods_id = top.document.getElementById('goodsid_attr').value;
						if(goods_id == '')
						{
							art.dialog.alert('请填写商品ID','warning');
							return false;
						}

						//给出数据请求提示
						var t1 = art.dialog.through({content:'正在请求数据，请稍后...',icon:'question',lock:true,fixed:true},function()
						{
							return true;
						});

						//请求后台
						$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/updateAttr',{'goodsid':goods_id,'isbest':isbest,'isnew':isnew,'ishot':ishot,'isspecial':isspecial},function(d)
						{
							t1.close();//关闭提示框
							attr_dialog.content(d).title('3秒后自动关闭').time(3);//给出提示，关闭主对话框
							location.reload();
							return false;
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
}
<?php echo '</script'; ?>
>

<div class="notif" id="move_block" style="display:none;">
	<div class="pubTabel">
		<table class="tabelTB tabelTB_X">
			<tr>
				<td style="padding-left:10px;">分类：</td>
				<td><select class="Iw290" id="sort" style="width:302px;">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sort']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['sortname'];?>
</option>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

				</select>&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">商品ID：</td>
				<td><input type="text" id="goodsid" value="" class="Iw290">&nbsp;&nbsp;&nbsp;</td>
			</tr>
		</table>
	</div>
</div>

<div class="notif" style="display:none;" id="attr_block">
	<div class="pubTabel">
		<table class="tabelTB tabelTB_X">
			<tr>
			<td style="padding-left:10px;">属性：</td>
			<td><span>
			<input type="checkbox" value="1" name="isbest"/>
			<label>精品</label>
			</span>&nbsp;&nbsp;<span>
			<input type="checkbox"  value="1" name="isnew"/>
			<label>新品</label>
			</span>&nbsp;&nbsp;<span>
			<input type="checkbox"  value="1" name="ishot"/>
			<label>热销</label>
			</span>&nbsp;&nbsp;<span>
			<input type="checkbox"  value="1" name="isspecial"/>
			<label>特卖</label>
			</span></td>
			</tr>
			<tr>
			<td style="padding-left:10px;">商品ID：</td>
			<td><input type="text" id="goodsid_attr" value="" class="Iw290"></td>
			</tr>
		</table>
	</div>
</div><?php }
}
