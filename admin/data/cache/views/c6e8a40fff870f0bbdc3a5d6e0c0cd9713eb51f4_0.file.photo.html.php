<?php
/* Smarty version 3.1.30, created on 2017-02-07 16:07:59
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\acer\photo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5899805f319886_49535506',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c6e8a40fff870f0bbdc3a5d6e0c0cd9713eb51f4' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\acer\\photo.html',
      1 => 1486454873,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5899805f319886_49535506 (Smarty_Internal_Template $_smarty_tpl) {
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
<!-- layer插件 -->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/skin/default/layer.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/layer.js"><?php echo '</script'; ?>
>

</head>

<body>
  <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photo">相册列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photocatadd" class="last">添加相册</a></dd>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photoadd" class="last">上传照片</a></dd>
          </dl>
        </div>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th>选择</th>
                  <th>照片名称</th>
                  <th>照片</th>
                  <th>相册名称</th>
                  <th>操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td>
                    <input type="checkbox" name="id[]" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' />
                  </td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['pname'];?>
</td>
                  <td><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['photo'];?>
" width="50"></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['cname'];?>
</td>
                  <td>
                    <a href="javascript:;" onclick="messageInfo(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">预览</a> |
                    <a href="javascript:;"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photodel/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
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
             
              <input type="button" class="btn5" value="删除" class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photodel/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" empty-tips="请选择要删除的数据" confirm-tips="确认删除？"/>
            </div>
            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div> 
             </form>          
           </div>
          </div>

    <?php echo '<script'; ?>
>
    function messageInfo(id){
        window.top.art.dialog({title:'预览', content:'<iframe src="/admin/memorial/acer/photoinfo/id/'+id+'" width="630px" height="500px" scrolling="yes" frameborder="0"></iframe>', width:'630px', height:'500px',id:'createActivit'});
    }
    <?php echo '</script'; ?>
>
    </body>
    </html>

<?php }
}
