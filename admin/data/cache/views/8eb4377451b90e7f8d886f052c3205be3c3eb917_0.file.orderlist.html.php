<?php
/* Smarty version 3.1.30, created on 2017-03-08 17:19:02
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\order\orderlist.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58bfcc86dcf947_80964994',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8eb4377451b90e7f8d886f052c3205be3c3eb917' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\order\\orderlist.html',
      1 => 1488964742,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58bfcc86dcf947_80964994 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
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
              <?php if ($_smarty_tpl->tpl_vars['params']->value['status'] == 0) {?>
              <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderlist">订单列表</a></dt>
              <?php } else { ?>
              <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderlist"  class="last">订单列表</a></dd>
              <?php }?>

              <?php if ($_smarty_tpl->tpl_vars['params']->value['status'] == 1) {?>
              <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderlist/status/1"  class="last">待支付</a></dt>
              <?php } else { ?>
              <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderlist/status/1"  class="last">待支付</a></dd>
              <?php }?>

              <?php if ($_smarty_tpl->tpl_vars['params']->value['status'] == 2) {?>
              <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderlist/status/2" class="last">已支付</a></dt>
              <?php } else { ?>
              <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderlist/status/2"  class="last">已支付</a></dd>
              <?php }?>
          </dl>
        </div>

        </form>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                    <th width="5%">选择</th>
                    <th width="10%">订单号</th>
                  <th width="5%">支付金额</th>
                  <th width="10%">产品名称</th>
                  <th width="5%">支付方式</th>
                  <th width="10%">时间</th>
                  <th width="5%">订单状态</th>
                  <th width="5%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                    <td><input type="checkbox" name="orderid[]" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['orderid'];?>
' />
                    </td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['ordersn'];?>
'><?php echo $_smarty_tpl->tpl_vars['item']->value['ordersn'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['product_name'];?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['payid'] == 1) {?>支付宝<?php }
if ($_smarty_tpl->tpl_vars['item']->value['payid'] == 2) {?>微信<?php }
if ($_smarty_tpl->tpl_vars['item']->value['payid'] == 3) {?>苹果支付<?php }?></td>
                    <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['ordertime'],'%Y-%m-%d %H:%M:%S');?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 1) {?>待付款<?php }
if ($_smarty_tpl->tpl_vars['item']->value['status'] == 2) {?>已付款<?php }
if ($_smarty_tpl->tpl_vars['item']->value['status'] == 3) {?>已取消<?php }?></td>
                    <td>
                   <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderInfo/orderid/<?php echo $_smarty_tpl->tpl_vars['item']->value['orderid'];?>
" class="last">查看</a>
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
/memorial/order/orderDelete/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" empty-tips="请选择要删除的订单" confirm-tips="确认删除？"/>

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
