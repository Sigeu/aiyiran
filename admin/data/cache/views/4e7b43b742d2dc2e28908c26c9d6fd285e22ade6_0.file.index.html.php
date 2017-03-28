<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:08:12
  from "D:\WWW\jisi2\admin\template\content\article\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585384cc06ed91_89275841',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e7b43b742d2dc2e28908c26c9d6fd285e22ade6' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\content\\article\\index.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585384cc06ed91_89275841 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\WWW\\jisi2\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\WWW\\jisi2\\vendor\\smarty\\plugins\\modifier.date_format.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>内容列表</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleL.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleX.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
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
>
 function id_cid(obj)
 {
	 
 	var _obj = $(obj);
 	var mychecked = _obj.attr('checked');
 	var this_state = mychecked == undefined ? false : true;  
 	_obj.siblings(".cid").attr('checked',this_state);
 	_obj.siblings(".mid").attr('checked',this_state);
 }
 <?php echo '</script'; ?>
>
</head>
<body>
<div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">文章列表</a></dt>
			<dd><a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['addUrl'];?>
/categoryid/<?php echo $_smarty_tpl->tpl_vars['search']->value['categoryid'];?>
" class="last">添加文章</a></dd>
			<dd class="add"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/issue/content">发布内容页</a></dd>
          </dl>
        </div>
        <form method='get' action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['indexUrl'];?>
" id='myForm'>
        <div class="TabBoxC">
          <div>
            <div class="pubTabelTot">
              <input type="text" name='keywords' <?php if ($_smarty_tpl->tpl_vars['search']->value['keywords']) {?> value="<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
" <?php } else { ?>value="请输入关键字"<?php }?>  class="Iw215 text-tips" tips="请输入关键字" >
              <select class="Iw290" style="width:110px;"  name='categoryid'>
                <option value="">请选择栏目</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categoryList']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['search']->value['categoryid'] == $_smarty_tpl->tpl_vars['item']->value['id']) {?>selected<?php }
if (!$_smarty_tpl->tpl_vars['item']->value['flag']) {?>disabled<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['catname'];?>
</option>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </select>
              <select class="Iw290" style="width:140px;" id='order'  name='order'>
			    <option value="publishtime" <?php if ($_smarty_tpl->tpl_vars['search']->value['order'] == 'publishtime') {?>selected<?php }?>>按发布时间</option>
                <option value="id"  <?php if ($_smarty_tpl->tpl_vars['search']->value['order'] == 'id') {?>selected<?php }?>>按信息ID</option>
				<option value="updatetime" <?php if ($_smarty_tpl->tpl_vars['search']->value['order'] == 'updatetime') {?>selected<?php }?>>按更新时间</option>
                <option value="hits" <?php if ($_smarty_tpl->tpl_vars['search']->value['order'] == 'hits') {?>selected<?php }?>>按点击量</option>
                <option value="sortnum" <?php if ($_smarty_tpl->tpl_vars['search']->value['order'] == 'sortnum') {?>selected<?php }?>>按排序值</option>
                </select>
                <select class="Iw290" style="width:110px;" id='desc' name='desc'>
                <option value="1" <?php if ($_smarty_tpl->tpl_vars['search']->value['desc'] == 1) {?>selected<?php }?>>降序</option>
                <option value="2" <?php if ($_smarty_tpl->tpl_vars['search']->value['desc'] == 2) {?>selected<?php }?>>升序</option>
                </select>
              <input type="button" hidefocus="hide" value="搜 索" class="btn5" onclick='formSubmit();'>
            </div>
            <div class="pubTabel">
              <table class="tabelTB"  id="search-list">
                <tr >
                  <th width="6%">选择</th>
                  <th width="6%">ID</th>
                  <th width="22%">内容标题</th>
                  <th width="12%">所属栏目</th>
                  <th width="8%">排序</th>
                  <th width="8%">点击量</th>
                  <th width="10%">发布人</th>
                  <th width="10%">更新时间</th>
                  <th width="14%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td><input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' onclick="javascript:id_cid(this)" name='id[]'/><input type="checkbox" style="display:none" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['cid'];?>
' class='cid' name='cid[]'/><input type="checkbox" style="display:none"  onclick="javascript:id_cid(this)" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['model'];?>
' class='mid' name='mid[]'/></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['title'],15,"...",true);?>
</td>
				  <td title="<?php echo $_smarty_tpl->tpl_vars['item']->value['catname'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['catname'],8,"...",true);?>
</td>
                  <td><input type="text" style="text-align:center;" class="Iw45" name="orderby[<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['sortnum'];?>
"></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['hits'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['publishuser'];?>
</td>
                  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['updatetime'],'%Y-%m-%d');?>
</td>
                  <td><a target="__blank" href="/content/Content/index/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/isadmin/1">预览</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['updateUrl'];?>
/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/cid/<?php echo $_smarty_tpl->tpl_vars['item']->value['cid'];?>
/keywords/<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
/categoryid/<?php echo $_smarty_tpl->tpl_vars['search']->value['categoryid'];?>
/order/<?php echo $_smarty_tpl->tpl_vars['search']->value['order'];?>
/desc/<?php echo $_smarty_tpl->tpl_vars['search']->value['desc'];?>
">修改</a> | 
                  <a  style="cursor:pointer" onclick="javascript:operateOne('<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['delUrl'];?>
/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/cid/<?php echo $_smarty_tpl->tpl_vars['item']->value['cid'];?>
/keywords/<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
/categoryid/<?php echo $_smarty_tpl->tpl_vars['search']->value['categoryid'];?>
/order/<?php echo $_smarty_tpl->tpl_vars['search']->value['order'];?>
/desc/<?php echo $_smarty_tpl->tpl_vars['search']->value['desc'];?>
/mid/<?php echo $_smarty_tpl->tpl_vars['item']->value['model'];?>
','确定删除？')">删除</a></td>
                </tr>
                <?php
}
} else {
?>

             	<tr><td colspan=8>暂无内容！</td></tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate"><span class="btn5"><label>
             <input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/> 全选/反选
              </label></span> 
              <input type="button" class="btn5" value="移动到 &gt;"  onclick="moveArticle(this)" container-id="search-list" form-id="myForm" form-action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['moveUrl'];?>
/keywords/<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
/categoryid/<?php echo $_smarty_tpl->tpl_vars['search']->value['categoryid'];?>
/order/<?php echo $_smarty_tpl->tpl_vars['search']->value['order'];?>
/desc/<?php echo $_smarty_tpl->tpl_vars['search']->value['desc'];?>
"   empty-tips="请选择要移动的内容！"/>
			  <input type="button" class="btn5" value="删除" onclick="batchOperate(this)" container-id="search-list" form-id="myForm" form-action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['delUrl'];?>
/keywords/<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
/categoryid/<?php echo $_smarty_tpl->tpl_vars['search']->value['categoryid'];?>
/order/<?php echo $_smarty_tpl->tpl_vars['search']->value['order'];?>
/desc/<?php echo $_smarty_tpl->tpl_vars['search']->value['desc'];?>
"   empty-tips="请选择要删除的内容！" confirm-tips="确定删除?"/>
               <input type="button" is-selected="false" empty-tips="" form-action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['updateorderUrl'];?>
/keywords/<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
/categoryid/<?php echo $_smarty_tpl->tpl_vars['search']->value['categoryid'];?>
/order/<?php echo $_smarty_tpl->tpl_vars['search']->value['order'];?>
/desc/<?php echo $_smarty_tpl->tpl_vars['search']->value['desc'];?>
" container-id="search-list" form-id="myForm" onclick="batchOperate(this)" value="更新排序" class="btn5">
            </div>
            <div class="pubTabelBot">
              <div class="pageGo"> <?php echo $_smarty_tpl->tpl_vars['pagestr']->value;?>
</div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    
 
    <?php echo '<script'; ?>
>
function moveArticle (obj)
{
	
	var hasper = <?php echo $_smarty_tpl->tpl_vars['hasper']->value;?>
;
	if(!hasper)
    {
	  alert("对不起,你没有操作权限");
    }
	else
	{
		var _obj = $(obj);
		var options = {
		"form_id":_obj.attr('form-id'),
		"container_id":_obj.attr('container-id'),
		"form_action":_obj.attr('form-action'),
		"empty_tips":_obj.attr('empty-tips')
		};
		var checked_number = $('#'+options.container_id+' input:checkbox:checked').length;  //选中的复选框数量
		if (!checked_number && options.container_id)
		{
			art.dialog.alert(options.empty_tips,'warning');
			return false;
		}
		else 
		{
			art.dialog.open('<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['moveHtmlUrl'];?>
',{
				title:'移动文章',
				id:'moveCategory',
				width:'500px',
				height:'100px',
				lock:true,
				ok:function(){     	
					var iframe = this.iframe.contentWindow;
					var moveCategoryId = iframe.document.getElementById('moveCategoryId').value;
					if(moveCategoryId)
					{
						var url = options.form_action+'/moveCategoryId/'+moveCategoryId;
						$('#'+options.form_id).attr('action',url);
						$('#'+options.form_id).submit();
					}
					window.top.art.dialog({id:'moveCategory'}).close();
				},
				cancel:function(){
				window.top.art.dialog({id:'moveCategory'}).close();
				}
			});
		}
	}
}
<?php echo '</script'; ?>
>
</body>

</html>
<?php }
}
