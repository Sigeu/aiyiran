<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:22:00
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\advert.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2be28386a40_67970211',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '892bed2a92978b4200c9e083c41a0498b46e9b83' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\advert.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2be28386a40_67970211 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>广告管理 </title>
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
            <dt class="on"><a href="#">广告列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/addAdvert/adpos/<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
/state/2" class='last'>添加广告</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
             <div class="pubTabelTot">
            </div>
            <div class="pubTabel">
            <form action='' method='get' id="batch-form">
             <table class="tabelTB" id="search-list">
                <tr>
                  <th width="5%">选择</th>
                  <th width="7%">排序</th>
                  <th width="20%">广告名称</th>
                  <th width="10%">广告类型</th>
                  <th width="20%">广告位名称</th>
                  <th width="13%">广告下架时间</th>
                  <th width="10%">点击量</th>
                  <th width="15%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" name='id[]'/></td>
                  <td>
                  <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
' name='adpos'></input>
                  <input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" name='page'></input>
                  <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" name='ids[]'></input>
                  <input class="Iw45" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['sort'];?>
" name='sort[]'></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['adtitle'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['pos']->value['adtypename'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['pos']->value['clumnname'];?>
</td>
                  <td>
                  <?php if ($_smarty_tpl->tpl_vars['item']->value['timetype'] != 1) {?>
                  <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['endtime'],"%Y-%m-%d %H:%M:%S");?>

                  <?php } else { ?>
                                                      永不限制
                  <?php }?>
                  </td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['clicknum'];?>
</td>
                  <td><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/editorAdvert/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/adpos/<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/state/2">修改</a> | 
                  <a href="#" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/delAdvert/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/adpos/<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/name/<?php echo $_smarty_tpl->tpl_vars['item']->value['adtitle'];?>
','确认删除？')">删除</a></td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate">
              <span class="btn5" style="width:80px;"><label>
              <input type="checkbox" class="Check-All-Toggle" container-id="search-list"  /> 全选/反选</label></span>
              <input type="button" class="btn5" value="更新排序" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/advertSort" empty-tips="请选择要进行排序的记录！" is-selected="false" />
               <input type="button" class="btn5" value="删除"  class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/delAdvert" empty-tips="请选择要删除的记录！" confirm-tips="确认删除？"/>
            </div>
            </form>
            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div> 
          </div>  
        </div>
      </div>
    </div>   
</body>
</html>
<?php }
}
