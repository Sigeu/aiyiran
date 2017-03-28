<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:08:09
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\adtype.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2bae9d36ff6_93641738',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b6784088dcf9787a3b9fd90d210325e007df5c0' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\adtype.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2bae9d36ff6_93641738 (Smarty_Internal_Template $_smarty_tpl) {
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
            <dt class="on"><a href="#">广告类型列表</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
            <form action="" method='get' id="batch-form">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="10%">类型名称</th>
                  <th width="24%">类型文件名</th>
                  <th width="20%">状态</th>
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
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['typename'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['typefilename'];?>
</td>
                  <td reg="<?php echo $_smarty_tpl->tpl_vars['item']->value['state'];?>
" class='states'><?php if ($_smarty_tpl->tpl_vars['item']->value['state'] == 1) {?>开启<?php } else { ?>关闭<?php }?></td>                 
                  <td>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/set/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">修改</a> | 
                    <a  class='update'
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['state'] == 1) {?>
                        href = "#" 
                        style='color:#ccc;text-decoration:none;' 
                    <?php } else { ?>
                        href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/openOrClose/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/state/1/name/<?php echo $_smarty_tpl->tpl_vars['item']->value['typename'];?>
"
                    <?php }?>
                    > 开启</a> |
                    <a class='update'
                     <?php if ($_smarty_tpl->tpl_vars['item']->value['state'] == 2) {?>
                        href = "#" 
                        style='color:#ccc;text-decoration:none;' 
                     <?php } else { ?>
                        href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/openOrClose/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/state/2/name/<?php echo $_smarty_tpl->tpl_vars['item']->value['typename'];?>
"
                     <?php }?>
                      >关 闭</a> 
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
/modules/admanage/openOrClose/state/1" empty-tips="请选择要开启的广告类型" confirm-tips="确定要开启选中广告类型吗？"/>
              <input type="button" class="btn5" value="关闭"  onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/openOrClose/state/2" empty-tips="请选择要关闭的广告类型" confirm-tips="确定要关闭选中的广告类型吗？"/>
            </div>
            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
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
