<?php
/* Smarty version 3.1.30, created on 2017-02-07 16:09:00
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\acer\photoinfo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5899809c16fc08_51275895',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4828b8e2755f096fef77569a239593751c1d2d07' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\acer\\photoinfo.html',
      1 => 1486454928,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_5899809c16fc08_51275895 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="pubBox" width="630px">
        <div class="pubtabBox" >
        
          <img src="<?php echo $_smarty_tpl->tpl_vars['img']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" >
        </div>
    </div>
</body>
</html>
<?php }
}
