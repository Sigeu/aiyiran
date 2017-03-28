<?php
/* Smarty version 3.1.30, created on 2017-02-07 10:34:38
  from "D:\xampp\htdocs\aiyiran\admin\template\admin\index\shortcut.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5899323e000988_05894022',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61533d17f66c36442b57c0084831a278c9efbb15' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\admin\\index\\shortcut.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5899323e000988_05894022 (Smarty_Internal_Template $_smarty_tpl) {
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
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleL.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
>
</head>
<body>
    <form action="" method="post" id='myForm' name="myForm">
    <input type="hidden" name='task' value="dosubmit" id="task" />
    <div class="notif">
    <h4>添加常用操作</h4>
    <div class="Ncon">
        <div class="Ncont">
            <table class="add_daily">
	            <tr>
				<?php
$__section_loop_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_loop']) ? $_smarty_tpl->tpl_vars['__smarty_section_loop'] : false;
$__section_loop_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['shortcutList']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_loop_0_total = min(($__section_loop_0_loop - 0), $__section_loop_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_loop'] = new Smarty_Variable(array());
if ($__section_loop_0_total != 0) {
for ($__section_loop_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index'] = 0; $__section_loop_0_iteration <= $__section_loop_0_total; $__section_loop_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_loop']->value['first'] = ($__section_loop_0_iteration == 1);
?> 
				<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index'] : null)%5 == 0 && !(isset($_smarty_tpl->tpl_vars['__smarty_section_loop']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_section_loop']->value['first'] : null)) {?>
				</tr> 
				<tr>
				<?php }?>
				<td><div class="<?php if (in_array($_smarty_tpl->tpl_vars['shortcutList']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index'] : null)]['id'],$_smarty_tpl->tpl_vars['myShortcut']->value)) {?>active<?php } else { ?>no_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['shortcutList']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index'] : null)]['name'];?>
<a href="#">add</a><input type="checkbox" name="shortcut[]" value="<?php echo $_smarty_tpl->tpl_vars['shortcutList']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_loop']->value['index'] : null)]['id'];?>
" style="display:none"></div></td>
				<?php
}
}
if ($__section_loop_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_loop'] = $__section_loop_0_saved;
}
?>
				</tr> 
            </table>
        </div>
        <!-- <div class="Nsubm" style="margin-top:150px;">
            <input type="button" hidefocus="hide" value="确定" class="btn3" id="dosubmit">
            <input type="button" hidefocus="hide" value="取消" class="btn4" id="cancle">
        </div> -->
    </div>    
</div>
</form>
    </body>
    </html><?php }
}
