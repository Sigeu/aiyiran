<?php
/* Smarty version 3.1.30, created on 2017-03-07 16:45:59
  from "D:\xampp\htdocs\aiyiran\admin\template\content\modelmanage\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58be7347dbf922_64621414',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2dd4a5476547924ec7d830406b059027fff8935b' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\content\\modelmanage\\index.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58be7347dbf922_64621414 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>模型管理</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
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
<style type="text/css">
	.mydisable{color:#868686}
</style>
<?php echo '<script'; ?>
>
function id_name(obj)
{
	var _obj = $(obj);
	var mychecked = _obj.attr('checked');
	var this_state = mychecked == undefined ? false : true;  
	_obj.siblings(".tablename").attr('checked',this_state);
	_obj.siblings(".type").attr('checked',this_state);
}
<?php echo '</script'; ?>
>
</head>
<body>
<div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">模型列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['addUrl'];?>
" class="last">添加模型</a></dd>
          </dl>
        </div>
        <form action="" method='post' id='myForm'>
        <div class="TabBoxC">
          <div>
            <div class="pubTabelTot">
            </div>
            <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="5%">选择</th>
                  <th width="5%">ID</th>
                  <th width="15%">模型名称</th>
                  <th width="15%">模型表键名</th>
                  <th width="15%">状态</th>
                  <th width="15%">类型</th>
                  <th>操作</th>
                  <th>内容</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['modellist']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td> <input type="checkbox" name='tablename[]' value='<?php echo $_smarty_tpl->tpl_vars['item']->value['tablename'];?>
' style="display:none" class='tablename'/><!-- 名字 -->
                  <input type="checkbox" name='type[]' value='<?php echo $_smarty_tpl->tpl_vars['item']->value['type'];?>
' style="display:none" class='type'/><!-- 类型  -->
                  <input type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' name='id[]' onclick="javascript:id_name(this)"/></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['name'],7,"..",true);?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['item']->value['tablename'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['tablename'],20,"...",true);?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['flag'] == 1) {?>开启<?php } else { ?>关闭<?php }?></td>  
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['type'] == 1) {?>系统模型<?php } else { ?>自定义模型<?php }?></td>  
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['id'] != 2) {?><a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['filedUrl'];?>
/modelid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">字段管理</a><?php } else { ?>
				  <a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['sxUrl'];?>
">属性管理</a>
				  <?php }?> | <a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['updateUrl'];?>
/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">修改</a> | <?php if ($_smarty_tpl->tpl_vars['item']->value['id'] != 2) {?><a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['copyUrl'];?>
/modelid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">复制</a><?php } else { ?>
				  <span  class="mydisable">复制</span>
				  <?php }?> | <a href="#" <?php if ($_smarty_tpl->tpl_vars['item']->value['flag'] == 2) {?>onclick="operateOne('<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['setflagUrl'];?>
/flag/1/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
','确定开启?')"<?php }?>><span <?php if ($_smarty_tpl->tpl_vars['item']->value['flag'] == 1) {?>class="mydisable"<?php }?>>开启</span></a> | <a href="#"  <?php if ($_smarty_tpl->tpl_vars['item']->value['flag'] == 1) {?>onclick="operateOne('<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['setflagUrl'];?>
/flag/2/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
','确定关闭?')"<?php } else { ?>onclick="javascript:return false;"<?php }?>><span <?php if ($_smarty_tpl->tpl_vars['item']->value['flag'] == 2) {?>class="mydisable"<?php }?>>关闭</span></a> | <?php if ($_smarty_tpl->tpl_vars['item']->value['type'] != 1) {?><a  style="cursor:pointer" onclick="javascript:operateOne('<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['delUrl'];?>
/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/tablename/<?php echo $_smarty_tpl->tpl_vars['item']->value['tablename'];?>
/type/<?php echo $_smarty_tpl->tpl_vars['item']->value['type'];?>
','确定删除？');">删除</a><?php } else { ?><span class="mydisable">删除</span><?php }?></td>
				  <?php if ($_smarty_tpl->tpl_vars['item']->value['id'] != 2) {?>
                  <td><a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['ContentIndexUrl'];?>
/addparameter/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">管理内容</a></td>
				  <?php } else { ?>
				  <td><span  class="mydisable">管理内容</span></td>
				  <?php }?>
                </tr>
                 <?php
}
} else {
?>

             	<tr><td colspan=8>暂无模型！</td></tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>

            </div>
            <div class="pubOperate"><span class="btn5"><label>
              <input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/> 全选/反选
              </label></span> 
              <input type="button" class="btn5" value="开启" onclick="batchOperate(this)" container-id="search-list" form-id="myForm" form-action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['setflagUrl'];?>
/flag/1"  empty-tips="请选择要开启的模型！" confirm-tips="确定开启?"/>
              <input type="button" class="btn5" value="关闭" onclick="batchOperate(this)" container-id="search-list" form-id="myForm" form-action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['setflagUrl'];?>
/flag/2"  empty-tips="请选择要关闭的模型！" confirm-tips="确定关闭?"/>
              <input type="button" class="btn5" value="删除" onclick="batchOperate(this)" container-id="search-list" form-id="myForm" form-action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['delUrl'];?>
"             empty-tips="请选择要删除的模型！" confirm-tips="确定删除?"/>
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
</body>
</html><?php }
}
