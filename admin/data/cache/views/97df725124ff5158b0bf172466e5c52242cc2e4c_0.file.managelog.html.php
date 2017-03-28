<?php
/* Smarty version 3.1.30, created on 2017-02-08 15:55:06
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\system\managelog.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_589acedaa6aa17_21270043',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '97df725124ff5158b0bf172466e5c52242cc2e4c' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\system\\managelog.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589acedaa6aa17_21270043 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>日志管理</title>
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
    <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/ManageLog/index" method="get" id="myForm" name="myForm" >
      <div class="pubtabBox">
        <div class="pubTabelTot">
           <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
" tips="请输入关键字" class="Iw150 text-tips" name='keyword' />
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 操作时间：
           <span class="time"><input type="text" class="Iw150" value="<?php echo $_smarty_tpl->tpl_vars['starttime']->value;?>
" onfocus="WdatePicker()" id='starttime' name='starttime' readonly></span> 至
           <span class="time"><input type="text" class="Iw150" value="<?php echo $_smarty_tpl->tpl_vars['endtime']->value;?>
" onfocus="WdatePicker()" id='endtime' name='endtime' readonly></span>
           <input type="submit" value="搜 索" class="btn5">
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="16%">用户名</th>
                  <th width="24%">操作内容</th>
                  <th width="16%">操作时间</th>
                  <th width="10%">IP</th>
                  <th>备注</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['log']->value, 'list');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
?>
                <tr>
                  <td><?php echo $_smarty_tpl->tpl_vars['list']->value['admin_name'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['list']->value['module_name'];?>
</td>
                  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['list']->value['log_time'],'%Y-%m-%d %H:%M:%S');?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['list']->value['ip_address'];?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['list']->value['log_info'];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['list']->value['log_info'],20,"...",true);?>
</td>
                </tr>     
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate">
            <input type="button" class="btn5" value="清空日志" onclick="javascript:if (confirm('确定清空日志'))location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/ManageLog/empty'"/>
            </div>
            <div class="pubTabelBot">
                <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div>           
           </div>
          </div>
        </div>
      </div>
     </form>
    </div>
</body>
</html><?php }
}
