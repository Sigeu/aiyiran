<?php
/* Smarty version 3.1.30, created on 2017-02-14 15:32:10
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\moreset\stylelist.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2b27a976707_87020451',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ea340ec98d816cf6124b715bddd93e28ed17ff7' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\moreset\\stylelist.html',
      1 => 1487057529,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2b27a976707_87020451 (Smarty_Internal_Template $_smarty_tpl) {
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
            <dt class="on"><a href="#">模板列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/addstyle" class="last">添加模板</a></dd>
          </dl>
        </div>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/stylesort" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="10%">排序</th>
                  <th width="25%">模板名称</th>
                  <!--<th width="10%">是否免费</th>-->
                  <!--<th width="10%">价格</th>-->
                  <th width="10%">图片</th>
                  <th width="15%">操作</th>
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
'><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
                  <!--<td>&lt;!&ndash;{if $item.free eq 1}&ndash;&gt;是&lt;!&ndash;{else}&ndash;&gt;否&lt;!&ndash;{/if}&ndash;&gt;</td>-->
                  <!--<td title='&lt;!&ndash;{$item.price}&ndash;&gt;'>&lt;!&ndash;{$item.price}&ndash;&gt;</td>-->
                  <td><img src="/static/uploadfile<?php echo $_smarty_tpl->tpl_vars['item']->value['pic'];?>
" width="60" height="60"/></td>
                  <td>
                  <a href="/static/uploadfile<?php echo $_smarty_tpl->tpl_vars['item']->value['pic'];?>
" target="_blank">预览</a> |
                   <a href="javascript:;" class="begin" data="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 1) {?>启用<?php } else { ?></a> <a href="javascript:;" class="end" data="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">禁用<?php }?></a> |
                   <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/styleupdate/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">修改</a> 
                 
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
/memorial/moreset/stylesort" empty-tips="请选择要进行排序的模板" is-selected="false" />
			  <input type="button" class="btn5" value="删除" class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/styledelete" empty-tips="请选择要删除的模板" confirm-tips="确认删除？"/>
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
              // 不启用
              $(".begin").click(function(){
                var id = $(this).attr('data');
                $.ajax({
                    type: "Post",
                    url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/begin",
                    data: {"id":id},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            layer.msg(data.msg, {icon: 1});
                            setTimeout("window.location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/style'",2000);
                        } else {
                            layer.msg(data.msg, {icon: 2});
                        };
                    }
                });
              });

              // 启用
              $(".end").click(function(){
                var id = $(this).attr('data');
                $.ajax({
                    type: "Post",
                    url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/end",
                    data: {"id":id},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            layer.msg(data.msg, {icon: 1});
                            setTimeout("window.location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/style'",2000);
                        } else {
                            layer.msg(data.msg, {icon: 2});
                        };
                    }
                });
              })
            });
          <?php echo '</script'; ?>
>

    </body>
    </html>
<?php }
}
