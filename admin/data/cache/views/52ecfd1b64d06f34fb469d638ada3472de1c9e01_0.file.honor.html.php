<?php
/* Smarty version 3.1.30, created on 2017-02-17 14:18:57
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\audit\honor.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a695d1132386_99457438',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52ecfd1b64d06f34fb469d638ada3472de1c9e01' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\audit\\honor.html',
      1 => 1487312105,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a695d1132386_99457438 (Smarty_Internal_Template $_smarty_tpl) {
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
            <dt  class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/audit/honor" class="last">作品及荣誉</a></dt>
          </dl>
        </div>

        <form  method='get' action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/audit/honor" id='myForm'>
        <!-- 搜索区域 -->
        <div class="pubTabelTot">
              <input type="text" name='keywords' <?php if ($_smarty_tpl->tpl_vars['search']->value['keywords']) {?> value="<?php echo $_smarty_tpl->tpl_vars['search']->value['keywords'];?>
" <?php } else { ?>value="请输入关键字"<?php }?>  class="Iw215 text-tips" tips="请输入关键字" >

              <select class="Iw290" style="width:140px;"  name='memorial_id'>
                <option value="">选择所属纪念馆</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allList']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"
                  <?php if ($_smarty_tpl->tpl_vars['search']->value['memorial_id'] == $_smarty_tpl->tpl_vars['item']->value['id']) {?> selected='' <?php }?>
                ><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </select>

              <select class="Iw290" style="width:110px;"  name='status'>
                <option value="">选择状态</option>
                <option value="3"  <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 3) {?> selected='' <?php }?>
                >未审核</option>
                <option value="1"  <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 1) {?> selected='' <?php }?>
                >通过</option>
                <option value="2"  <?php if ($_smarty_tpl->tpl_vars['search']->value['status'] == 2) {?> selected='' <?php }?>
                >未通过</option>
              </select>
              创建时间：<input id="data1" class="laydate-icon" name="star" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['star'];?>
" /> 至
                        <input id="data2" class="laydate-icon" name="end" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['end'];?>
" />
<?php echo '<script'; ?>
>
laydate({
  elem: '#data1', 
  event: 'focus',
  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
laydate({
  elem: '#data2', 
  event: 'focus',
  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
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
                <th>选择</th>
                <th>荣誉作品名称</th>
                <th>所属纪念馆</th>
                <th>添加时间</th>
                <th>状态</th>
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
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['hname'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['createtime'];?>
</td>
                  <td><?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 3) {?>未审核<?php }
if ($_smarty_tpl->tpl_vars['item']->value['status'] == 1) {?>已通过<?php }
if ($_smarty_tpl->tpl_vars['item']->value['status'] == 2) {?>未通过<?php }?></td>
                  <td>
                    <a href="javascript:;" class="shenhe" data="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">审核</a> |
                    <a href="javascript:;"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/audit/honordelete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
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
/memorial/audit/honordelete" empty-tips="请选择要删除的数据" confirm-tips="确认删除？"/>
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
/memorial/audit/honoryes",
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
/memorial/audit/honorno",
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
