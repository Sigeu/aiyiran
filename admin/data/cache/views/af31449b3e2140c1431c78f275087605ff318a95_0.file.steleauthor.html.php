<?php
/* Smarty version 3.1.30, created on 2017-01-05 14:14:18
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\moreset\steleauthor.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586de43a693372_76436543',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af31449b3e2140c1431c78f275087605ff318a95' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\moreset\\steleauthor.html',
      1 => 1479194295,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_586de43a693372_76436543 (Smarty_Internal_Template $_smarty_tpl) {
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
            <dt class="on"><a href="#">立碑人模板信息列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/addstele" class="last">添加立碑人模板信息</a></dd>
          </dl>
        </div>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/stelesort" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="10%">排序</th>
                  <th width="25%">模板名称</th>
                  <th width="25%">模板内容</th>
                  <th width="10%">操作</th>
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
                  <input type="text" class="Iw45" name="listorder[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['listorder'];?>
">
                  </td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
                  <td style="float: left;"><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</td>
                  <td>
                   <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/steleupdate/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">修改</a> |
                   <a href="#"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/steledelete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/name/<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
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
/memorial/moreset/stelesort" empty-tips="请选择要进行排序的模板" is-selected="false" />
			  <input type="button" class="btn5" value="删除" class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/steledelete" empty-tips="请选择要删除的模板" confirm-tips="确认删除？"/>
            </div>
            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div> 
             </form>          
           </div>
          </div>

<?php echo '<script'; ?>
 type="text/javascript">
  $(function(){
    $(".shenhe").click(function(){
      var id = $(this).attr('data');
       var idx = layer.confirm('确认通过审核吗？', {
            btn: ['通过','不通过'] //按钮
                        }, function(){
                            $.ajax({
                                type: "Post",
                                url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/stelesortyes",
                                data: {"id":id},
                                dataType: "json",
                                success: function(data) {
                                    if (data.status == 1) {
                                        layer.msg(data.msg, {icon: 1});
                                        setTimeout("history.go(0)",2000);
                                    } else {
                                        layer.msg(data.msg, {icon: 2});
                                    };
                                }
                            });
                        }, function(){
                           $.ajax({
                                type: "Post",
                                url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/stelesortno",
                                data: {"id":id},
                                dataType: "json",
                                success: function(data) {
                                    if (data.status == 1) {
                                        layer.msg(data.msg, {icon: 1});
                                        setTimeout("history.go(0)",2000);
                                    } else {
                                        layer.msg(data.msg, {icon: 2});
                                    };
                                }
                            });
                        
            });
    });
  });

<?php echo '</script'; ?>
>      

    </body>
    </html>
<?php }
}
