<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:11:45
  from "D:\WWW\jisi2\admin\template\memorial\cat\catlist.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585385a1560d81_95339630',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ff14482d106f1298b20726b54a33046b4593042' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\memorial\\cat\\catlist.html',
      1 => 1479983483,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585385a1560d81_95339630 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
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
/admin.js"><?php echo '</script'; ?>
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

</head>

<body>
  <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">纪念馆分类列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/add" class="last">添加纪念馆分类</a></dd>
          </dl>
        </div>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/index" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="10%">排序</th>
                  <th width="20%">所属上级分类</th>
                  <th width="25%">分类名称</th>
                  <th width="25%">纪念馆数量</th>
                  <th width="20%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td>
                  <input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" />
                  </td>
                  <td>
                  <input type="text" class="Iw45" name="sort[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['sort'];?>
">
                  </td>
                  <td>
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['pid'] == 0) {?>
                      顶级分类
                    <?php }?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 's');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['s']->value) {
?>
                    <?php if ($_smarty_tpl->tpl_vars['s']->value['id'] == $_smarty_tpl->tpl_vars['item']->value['pid']) {?>
                    <?php echo $_smarty_tpl->tpl_vars['s']->value['name'];?>

                    <?php }?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                  </td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
</td>
                  <td>
                   <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/update/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/link_type/<?php echo $_smarty_tpl->tpl_vars['search']->value['link_type'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">修改</a> |
                   <a href="#"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/delete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/name/<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/link_type/<?php echo $_smarty_tpl->tpl_vars['search']->value['link_type'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
','确认删除？')">删除</a>
                  </td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate"><span class="btn5">
              <label>
              <input type="checkbox" class="Check-All-Toggle" container-id="search-list"/>
                                        全选/反选</label>
              </span> 
              <input type="button" class="btn5" value="更新排序" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/linkSort" empty-tips="请选择要进行排序的友情链接" is-selected="false" />
			  <input type="button" class="btn5" value="删除" class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cat/delete" empty-tips="请选择要删除的友情链接" confirm-tips="确认删除？"/>
            </div>
            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div> 
             </form>          
           </div>
          </div>
    </body>
    </html>
<?php }
}
