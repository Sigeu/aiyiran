<?php
/* Smarty version 3.1.30, created on 2017-01-06 14:53:00
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\cemetery\lists.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f3ecc1c2459_54336567',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '950892a01f191520068beb71ead4abe6af989740' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\cemetery\\lists.html',
      1 => 1480416593,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_586f3ecc1c2459_54336567 (Smarty_Internal_Template $_smarty_tpl) {
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
<!-- 时间日期插件 -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/laydate.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/need/laydate.css" type="text/css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/skins/molv/laydate.css" type="text/css">




</head>

<body>
  <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">陵园列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/add" class="last">添加陵园</a></dd>
          </dl>
        </div>
        <form  method='get' action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/lists" id='myForm'>
        <!-- 搜索区域 -->
        <div class="pubTabelTot">
              <input type="text" name='keywords' <?php if ($_smarty_tpl->tpl_vars['search']->value['keywords']) {?> value="<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
" <?php } else { ?>value="请输入关键字"<?php }?>  class="Iw215 text-tips" tips="请输入关键字" >
              <select name="status">
                <option>请选择发布状态</option>
                <option value="1" <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 1) {?> selected='' <?php }?>
                >已发布</option>
                <option value="2" <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 2) {?> selected='' <?php }?>
                >未发布</option>
              </select>
              创建时间：<input id="data1" class="laydate-icon" name="star" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['star'];?>
" /> 至
                        <input id="data2" class="laydate-icon" name="end"  value="<?php echo $_smarty_tpl->tpl_vars['search']->value['end'];?>
"/>
<?php echo '<script'; ?>
>
laydate({
  elem: '#data1', 
  event: 'focus',
  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
  min: '1000-01-01 00:00:00' //最小日期
});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
laydate({
  elem: '#data2', 
  event: 'focus',
  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
  min: '1000-01-01 00:00:00' //最小日期
});
laydate.skin('dahong'); //皮肤
<?php echo '</script'; ?>
>


              <input type="button" hidefocus="hide" value="搜 索" class="btn5" onclick='formSubmit();'>
        </div>
        <!-- 搜索区域 -->
        </form>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="15%">陵园名称</th>
                  <th width="15%">创建时间</th>
                  <th width="15%">发布状态</th>
                  <th width="20%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['lists']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td>
                  <input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" />
                  </td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['addtiem'];?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 1) {?>已发布<?php } else { ?>未发布<?php }?></td>
                  <td>
                  <a href="">预览</a> |
                   <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/update/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">修改</a> |
                   <a href="javascript:;"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/delete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/title/<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
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
/memorial/cemetery/delete/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/title/<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" empty-tips="请选择要删除的友情链接" confirm-tips="确认删除？"/>
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
/memorial/hall/audi",
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
/memorial/hall/noaudi",
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

    // 不通过
     $(".bushenhe").click(function(){
      var id = $(this).attr('data');
       var idx = layer.confirm('不通过审核吗？', {
            btn: ['确认','取消'] //按钮
                        }, function(){
                            $.ajax({
                                type: "Post",
                                url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/noaudi",
                                data: {"id":id},
                                dataType: "json",
                                success: function(data) {
                                    if (data.status == 1) {
                                        layer.msg(data.msg, {icon: 1});
                                        setTimeout("window.location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/Hall/index'",2000);
                                    } else {
                                        layer.msg(data.msg, {icon: 2});
                                    };
                                }
                            });
                        }, function(){
                         layer.close(idx);
            });
    });
  })
<?php echo '</script'; ?>
>

    </body>
    </html>
<?php }
}
