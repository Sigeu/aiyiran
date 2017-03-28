<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:07:42
  from "D:\WWW\jisi2\admin\template\members\group\group_list.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585384ae3d6078_80357855',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '38ebe73adf19b68592c56f8508bcbc1de9bc5928' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\members\\group\\group_list.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585384ae3d6078_80357855 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\WWW\\jisi2\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title></title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/My97DatePicker/WdatePicker.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/plugins/iframeTools.source.js"><?php echo '</script'; ?>
>
<style type="text/css">
 #gray{color:#ccc;text-decoration:none;}
</style>
</head>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/index">分组列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/add" class="last">添加分组</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <form action="" method="post" id='myForm' name="myForm">
            <div class="pubTabelTot tabelLR"><strong>[温馨提示]：</strong><span style='color:#999999'>当会员组下已经存在会员级别和会员信息时，此会员组不能删除</span></div>
            <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="10%">ID</th>
                  <th width="20%">会员组</th>
                  <th width="10%">会员数量</th>
                  <th width="10%">状态</th>
                  <th width="30%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groupList']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td><input type="checkbox"  name="groupid[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"  /></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['item']->value['groupname'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['groupname'],"10","...",'utf8');?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['membernum'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['status']->value[$_smarty_tpl->tpl_vars['item']->value['status']];?>
</td> 
                  <td><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/edit/groupid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">修改</a> | 
                  <a href="#" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/delete/groupid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
','没有会员和级别时才能删除，确定删除？');">删除</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/isable/state/1/groupid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" id="<?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 1) {?>gray<?php }?>" >开启</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/isable/state/2/groupid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" id="<?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 2) {?>gray<?php }?>">关闭</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index/groupid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">查看组内会员</a></td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                
              </table>                
            </div>
            <div class="pubOperate">
            
              <span class="btn5" style="width:80px;">
                <label>
                    <input type="checkbox" class="Check-All-Toggle" container-id="search-list" /> 全选/反选
                </label>
              </span>
              <input type="button" class="btn5" value="开启"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/isable/state/1" empty-tips="请选择要开启的分组"  confirm-tips="确定开启？"/>
              <input type="button" class="btn5" value="关闭"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/isable/state/2" empty-tips="请选择要关闭的分组" confirm-tips="确定关闭？" />
              <input type="button" class="btn5" value="删除"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/group/delete" empty-tips="请选择要删除的分组" confirm-tips="没有会员和级别时才能删除，确定删除？"/>
            </div>
            </form>
          </div>
          <div style="height:100px; display:none"></div>
          <div style="height:100px; display:none"></div>
        </div>
      </div>
    </div>    
</body>
</html><?php }
}
