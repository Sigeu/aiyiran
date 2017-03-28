<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:07:48
  from "D:\WWW\jisi2\admin\template\members\form\form_list.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585384b4a0a781_42858362',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '31b8b8c7e51e1c7a2b7d28a777afcb3c6cce6642' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\members\\form\\form_list.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585384b4a0a781_42858362 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\WWW\\jisi2\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>留言板分类</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
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
            <dt class="on"><a href="#">表单列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/form/addForm" class='last'>添加表单</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <form action="" method='get' id="batch-form">
            <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="15%">选择</th>
                  <th width="10%">ID</th>
                  <th width="30%">会员注册表单名</th>
                  <th width="15%">状态</th>
                  <th width="30%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td><input type="checkbox" name='id[]' value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"/></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['name'],10,'...',true);?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['state'] == 2) {?>开启<?php } else { ?>关闭<?php }?></td>                 
                  <td>
                     <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/message/field/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/flag/2">字段管理</a> | 
                     <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/form/editForm/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">修改</a>| 
                     <a href="#"
					 onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/form/copyForm/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
','确定复制表单吗？')"
					 >复制</a>|
                     <a href="#" 
                     <?php if ($_smarty_tpl->tpl_vars['item']->value['def'] == 1) {?>
                      style="color:#ccc;text-decoration:none;"
                      <?php } else { ?>
                      onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/form/delete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
','确认删除？')"
                     <?php }?>
                     >删除</a>
                 </td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate"><span class="btn5" style="width:80px;"><label><input type="checkbox" class="Check-All-Toggle" container-id="search-list"  /> 全选/反选</label></span>
              <input type="button" class="btn5" value="开启"  onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/form/Opera/sate/2" empty-tips="请选择要开启的表单" confirm-tips="确定要开启吗？"/>
              <input type="button" class="btn5" value="关闭"  onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/form/Opera/sate/1" empty-tips="请选择要关闭的表单" confirm-tips="确定要关闭吗？"/>
              <input type="button" class="btn5" value="删除"  class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/form/delete" empty-tips="请选择要删除的表单" confirm-tips="确认删除？"/>
            </div>
            <div class="pubTabelBot">
            </div> 
            </form>
          </div>  
        </div>
      </div>
    </div>   
</body>
</html>
<?php }
}
