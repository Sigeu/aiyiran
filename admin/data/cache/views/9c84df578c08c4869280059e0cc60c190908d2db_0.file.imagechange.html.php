<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:07:49
  from "D:\xampp\htdocs\aiyiran\admin\template\public\advert\imagechange.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2bad51923b3_78073195',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c84df578c08c4869280059e0cc60c190908d2db' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\public\\advert\\imagechange.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2bad51923b3_78073195 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['n']->value != 1) {
echo '<script'; ?>
 type='text/javascript'><?php }?>
var str ="<style type='text/css'>.mainone_ads_q_pic_art_<?php echo $_smarty_tpl->tpl_vars['ad']->value['id'];?>
 {width:<?php if ($_smarty_tpl->tpl_vars['ad']->value['width']) {
echo $_smarty_tpl->tpl_vars['ad']->value['width'];
} else { ?>900<?php }?>px;height:<?php if ($_smarty_tpl->tpl_vars['ad']->value['height']) {
echo $_smarty_tpl->tpl_vars['ad']->value['height'];
} else { ?>90<?php }?>px;}.mainone_ads_q_pic_art_<?php echo $_smarty_tpl->tpl_vars['ad']->value['id'];?>
{margin-top:<?php echo $_smarty_tpl->tpl_vars['ad']->value['up'];?>
px;margin-left:<?php echo $_smarty_tpl->tpl_vars['ad']->value['left'];?>
px;}</style><div class='mainone_ads_q_pic_art_<?php echo $_smarty_tpl->tpl_vars['ad']->value['id'];?>
'><a href='<?php echo $_smarty_tpl->tpl_vars['adimg']->value['link'];?>
' target='_blank'><img src='<?php if ($_smarty_tpl->tpl_vars['adimg']->value['img']['path']) {?>/static/uploadfile/advert/<?php echo $_smarty_tpl->tpl_vars['adimg']->value['img']['path'];
} else { ?>/admin/template/images/pic_.jpg<?php }?>' width='<?php echo $_smarty_tpl->tpl_vars['ad']->value['width'];?>
' height='<?php echo $_smarty_tpl->tpl_vars['ad']->value['height'];?>
'/></div>";
document.write(str);
<?php if ($_smarty_tpl->tpl_vars['n']->value != 1) {
echo '</script'; ?>
><?php }
}
}
