<?php
/* Smarty version 3.1.30, created on 2016-12-29 16:07:30
  from "D:\xampp\htdocs\aiyiran\admin\template\members\regist\regist_list.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5864c442146073_56259288',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44962b8c132d322367421c75ffc68b8d0ce8bd1d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\members\\regist\\regist_list.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5864c442146073_56259288 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
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
            <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/regist/index">协议列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/regist/addregist" class='last'>添加协议</a></dd>
          </dl>

        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
            <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/regist/delete" method='get' id="batch-form">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="10%">协议名称</th>
                  <th width="12%">状态</th>
                  <th width="24%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td><input type="checkbox" name='id[]' value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"/></td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['name'],10,'...',true);?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['iseffect'] == 1) {?>开启<?php } else { ?>关闭<?php }?></td>                 
                  <td>
                     <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/Regist/editorRegist/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/name/<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
">修改</a> | 
                     <a 
                     <?php if ($_smarty_tpl->tpl_vars['item']->value['iseffect'] == 1) {?>
                         style='color:#ccc;text-decoration:none;'
                     <?php } else { ?>
                          href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/Regist/openOrClose/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/state/1" 
                     <?php }?>
                    
                     >开启</a> | 
                     <a 
                     <?php if ($_smarty_tpl->tpl_vars['item']->value['iseffect'] == 2) {?>
                      style='color:#ccc;text-decoration:none;'
                     <?php } else { ?>
                      href ="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/Regist/openOrClose/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/state/2"
                     <?php }?>
                      >关闭</a> | 
                     <a href="#" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/Regist/delete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/name/<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
','确认删除？')">删除</a>
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
/members/Regist/openOrClose/state/1" empty-tips="请选择要开启的协议" confirm-tips="确定要开启吗？"/>
              <input type="button" class="btn5" value="关闭"  onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/Regist/openOrClose/state/2" empty-tips="请选择要关闭的协议" confirm-tips="确定要关闭吗？"/>
              <input type="button" class="btn5" value="删除"  class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/regist/delete" empty-tips="请选择要删除的协议" confirm-tips="确认删除？"/>
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
