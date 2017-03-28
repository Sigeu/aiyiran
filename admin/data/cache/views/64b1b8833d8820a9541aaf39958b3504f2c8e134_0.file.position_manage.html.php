<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:21:54
  from "D:\xampp\htdocs\aiyiran\admin\template\content\position\position_manage.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2be220a1f19_02076416',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '64b1b8833d8820a9541aaf39958b3504f2c8e134' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\content\\position\\position_manage.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2be220a1f19_02076416 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>推荐位管理</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
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
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/My97DatePicker/WdatePicker.js"><?php echo '</script'; ?>
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
            <dt class="on"><a href="javascript:void(0)">推荐位管理</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/position/addposition" class="last">添加推荐位</a></dd>
          </dl>
        </div>
        <div class="height16"></div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
            <form method="POST" action="" id="batch-form" />
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="6%">选择</th>
                  <th width="10%">ID</th>
                  <th width="25%">推荐位名称</th>
                  <th width="8%">特效</th>
                  <th width="14%">所属栏目</th>
                  <th width="14%">编辑时间</th>
                  <th width="18%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pos']->value, 'list');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
?>
                <tr>
                  <td><input type="checkbox" id="posid" name="posid[]" value="<?php echo $_smarty_tpl->tpl_vars['list']->value['pos_id'];?>
"/></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['list']->value['pos_id'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['list']->value['name'];?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['list']->value['special'] == 0) {?>无<?php } elseif ($_smarty_tpl->tpl_vars['list']->value['special'] == 1) {?>跑马灯<?php } else { ?>幻灯片<?php }?></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['list']->value['catname'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['list']->value['alter_time'];?>
</td>
                  <td><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/position/positioninfo/pid/<?php echo $_smarty_tpl->tpl_vars['list']->value['pos_id'];?>
/catid/<?php echo $_smarty_tpl->tpl_vars['list']->value['cat_id'];?>
">信息管理</a> | <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/position/editposition/id/<?php echo $_smarty_tpl->tpl_vars['list']->value['pos_id'];?>
">修改</a> | <a href="javascript:void(0);"onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/position/delposition/id/<?php echo $_smarty_tpl->tpl_vars['list']->value['pos_id'];?>
')">删除</a></td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
              </form>
            </div>
            <div class="pubOperate"><span class="btn5" style="width:80px;"><label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" /> 全选/反选</label></span>
             <input type="button" class="btn5" value="删除" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/position/delposition" empty-tips="请选择要删除的记录！" confirm-tips="确定要删除吗？"/>
            </div>
            <div class="pubTabelBot">
              <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
</body>
</html>
<?php }
}
