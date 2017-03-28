<?php
/* Smarty version 3.1.30, created on 2016-12-29 16:07:27
  from "D:\xampp\htdocs\aiyiran\admin\template\members\level\level_list.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5864c43f41b7e8_70539504',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c68148f45bd9b07cb4ce81d1d8492f833ad8247f' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\members\\level\\level_list.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5864c43f41b7e8_70539504 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
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
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/My97DatePicker/WdatePicker.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
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
/members/level/index">级别列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/add" class="last">添加级别</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/index" method="get" id="myForm" name="myForm">
            <input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
" />
            <div class="pubTabelTot">
              <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
" class="Iw290 text-tips" tips="请输入关键字" style="width:150px;" id="keyword" name="keyword">
              <select class="Iw290" style="width:150px;" id="groupid" name="groupid">
                <option value="">请选择所属会员组</option>
                 <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['allGroup'], 'name', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
?>
                 <option value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"  <?php if ($_smarty_tpl->tpl_vars['searchInfo']->value['groupid'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</option>
                 <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </select>
              <select class="Iw290" style="width:130px;" id="status" name="status">
                <option value="">请选择级别状态</option>
                <option value="1" <?php if ($_smarty_tpl->tpl_vars['searchInfo']->value['status'] == 1) {?>selected<?php }?>>开启</option>
                <option value="2" <?php if ($_smarty_tpl->tpl_vars['searchInfo']->value['status'] == 2) {?>selected<?php }?>>关闭</option>
              </select>&nbsp;&nbsp;
              <input type="button" hidefocus="hide" value="搜 索" class="btn5" onclick="formSubmit();">
            </div>
            <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="5%">选择</th>
                  <th width="5%">ID</th>
                  <th width="15%">级别名称</th>
                  <th width="10%">会员数量</th>
                  <th width="10%">积分小于</th>
                  <th width="5%">状态</th>
                  <th width="15%">所属会员组</th>
                  <th width="25%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['levelList']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                <tr>
                  <td><input type="checkbox" id="levelid" name="levelid[]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"  /></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['row']->value['levelname'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['row']->value['levelname'],"8","...",'utf8');?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['row']->value['membernum'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['row']->value['point'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['status'][$_smarty_tpl->tpl_vars['row']->value['status']];?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['allGroup'][$_smarty_tpl->tpl_vars['row']->value['groupid']];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['pageInfo']->value['allGroup'][$_smarty_tpl->tpl_vars['row']->value['groupid']],"8","...",'utf8');?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['row']->value['groupstatus'] == 2) {?><a href="#" id="gray">修改</a><?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/edit/id/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/group/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/kw/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/st/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['status'];?>
">修改</a><?php }?> | 
                  <?php if ($_smarty_tpl->tpl_vars['row']->value['status'] == 1) {?><a href="#" id="gray">开启</a><?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/isable/state/1/levelid/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/status/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['status'];?>
">开启</a><?php }?> | 
                  <?php if ($_smarty_tpl->tpl_vars['row']->value['status'] == 2) {?><a href="#" id="gray">关闭</a><?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/isable/state/2/levelid/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/status/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['status'];?>
">关闭</a><?php }?> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index/groupid/<?php echo $_smarty_tpl->tpl_vars['row']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">管理会员</a></td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>                 
            </div>
            <div class="pubOperate"><span class="btn5" style="width:80px;"><label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" /> 全选/反选</label></span>
              <input type="button" class="btn5" value="开启"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/isable/state/1" empty-tips="请选择要开启的级别！" confirm-tips="确定开启？"/>
              <input type="button" class="btn5" value="关闭"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/isable/state/2" empty-tips="请选择要关闭的级别！" confirm-tips="确定关闭？"/>
              <input type="button" class="btn5" value="删除"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/level/delete" empty-tips="请选择您要删除的级别！" confirm-tips="级别下没有会员才能删除，确定删除？"/>
            </div>
            <div class="pubTabelBot">
              <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
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
