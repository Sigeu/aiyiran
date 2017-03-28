<?php
/* Smarty version 3.1.30, created on 2016-12-19 12:05:32
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\area.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58575c8c8f8c97_30594613',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e61acb57f59f9254a983478106f3563c0d843c6' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\area.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58575c8c8f8c97_30594613 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['area']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
  <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                      <?php }
}
