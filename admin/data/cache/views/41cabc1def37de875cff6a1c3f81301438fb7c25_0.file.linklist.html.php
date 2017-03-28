<?php
/* Smarty version 3.1.30, created on 2017-03-13 17:12:11
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\link\linklist.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c6626b86b0a9_37928228',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '41cabc1def37de875cff6a1c3f81301438fb7c25' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\link\\linklist.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c6626b86b0a9_37928228 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
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
            <dt class="on"><a href="#">友情链接列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/add" class="last">添加友情链接</a></dd>
          </dl>
        </div>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/index" method='get' id="batch-form">
        <div class="pubTabelTot">
           <input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" />
           <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['search']->value['keyword'] != '') {
echo $_smarty_tpl->tpl_vars['search']->value['keyword'];
} else { ?>请输入关键字<?php }?>" class="Iw150 text-tips" tips="请输入关键字" name='keyword'>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <select class="Iw290" name="link_type" style="width:162px;" id='link_type'>
             <option value="">请选择类型</option>
             <option value="1" <?php if ($_smarty_tpl->tpl_vars['search']->value['link_type'] == 1) {?>selected<?php }?>>图片</option>
             <option value="2" <?php if ($_smarty_tpl->tpl_vars['search']->value['link_type'] == 2) {?>selected<?php }?>>文字</option>
            </select>
           <input type="submit" hidefocus="hide" value="搜 索" class="btn5">
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="10%">排序</th>
                  <th width="25%">网站名称</th>
                  <th width="16%">链接类型</th>
                  <th width="19%">图片logo</th>
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
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['name'],10,'...',true);?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['link_type'] == 1) {?>图片<?php } else { ?>文字<?php }?></td>
                   <td><image src="<?php if ($_smarty_tpl->tpl_vars['item']->value['logo'] == '') {?>/admin/template/images/default/np_Xsmall.jpg<?php } else { ?>/static/uploadfile/frind_link/<?php echo $_smarty_tpl->tpl_vars['item']->value['logo'];
}?>" width='60' height="60"></td>
                  <td>
                   <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/update/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/link_type/<?php echo $_smarty_tpl->tpl_vars['search']->value['link_type'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">修改</a> |
                   <a href="#"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/delete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
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
/modules/link/linkSort" empty-tips="请选择要进行排序的友情链接" is-selected="false" />
			  <input type="button" class="btn5" value="删除" class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/delete" empty-tips="请选择要删除的友情链接" confirm-tips="确认删除？"/>
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
