<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:06:04
  from "D:\WWW\jisi2\admin\template\public\copyright.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5853844c5f9be2_72524425',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a35062467b8f96b7f932c2f94ee0194ffc2ff73e' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\public\\copyright.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5853844c5f9be2_72524425 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\WWW\\jisi2\\vendor\\smarty\\plugins\\modifier.date_format.php';
?>
Copyright &copy; 2004-<?php echo smarty_modifier_date_format(time(),"%Y");?>
 izhanCMS. 铭万智达科技有限公司 版权所有<?php }
}
