<?php
/* Smarty version 3.1.30, created on 2017-03-10 15:43:12
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\order\orderInfo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c259100fecd2_75403345',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '058963ad2fa30b731008926140efaf6353fe4f0c' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\order\\orderInfo.html',
      1 => 1489131790,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58c259100fecd2_75403345 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">订单信息</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel mt10">
                <dl class="navTab" style='padding-left:1px;border:0px;'>
                    <dt class="on" style='display:block;padding:0 10px;'>基本信息</dt>
                </dl>

             	<table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd">
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;">订单号</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd">
                        <?php echo $_smarty_tpl->tpl_vars['order']->value['ordersn'];?>

                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%">订单状态</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd">
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['status'] == 1) {?>
                            待付款
                        <?php } elseif ($_smarty_tpl->tpl_vars['order']->value['status'] == 2) {?>
                            已付款
                        <?php } elseif ($_smarty_tpl->tpl_vars['order']->value['status'] == 3) {?>
                            已取消
                        <?php } else { ?>
                            状态有误
                        <?php }?>
                    </td>
                  </tr>
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;width:20%;border-right:1px solid #ddd">下单会员</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-right:1px solid #ddd">
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['username']) {?>
                            <?php echo $_smarty_tpl->tpl_vars['order']->value['username'];?>

                        <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['order']->value['email'];?>

                        <?php }?>
                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;width:20%;border-right:1px solid #ddd">下单时间</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-right:1px solid #ddd">
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['ordertime'] != 0) {?>
                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['order']->value['ordertime'],'%Y-%m-%d %H:%M:%S');?>

                        <?php }?>
                    </td>
                  </tr>
                </table>

                <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd;border-top:0px;">
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">支付方式</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;border-top:0px;">
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['payid'] == 1) {?>
                            支付宝
                        <?php } elseif ($_smarty_tpl->tpl_vars['order']->value['payid'] == 2) {?>
                            微信支付
                        <?php } else { ?>
                            其他支付
                        <?php }?>
                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">支付状态</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd;border-top:0px;">
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['status'] == 1) {?>待付款<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['status'] == 2) {?>已付款<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['status'] == 3) {?>已取消<?php }?>
                    </td>
                  </tr>
                </table>

                <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd;border-top:0px;">
                    <tr>
                        <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">支付金额</th>
                        <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;border-top:0px;">
                            <?php echo $_smarty_tpl->tpl_vars['order']->value['money'];?>

                        </td>

                        <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">产品名称</th>
                        <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd;border-top:0px;">
                            <?php echo $_smarty_tpl->tpl_vars['order']->value['product_name'];?>

                        </td>
                    </tr>
                </table>





            </div>
          </div>
        </div>
        </div>


        <div class="TabBoxC">
          <div>
            <div class="pubTabel mt10">
                <dl class="navTab" style='padding-left:1px;border:0px;'>
                    <dt class="on" style='display:block;padding:0 10px;'>操作信息</dt>
                </dl>
                <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderConfirm" method='post' id='operation-form'>
                    <input type="hidden" name="orderid" value="<?php echo $_smarty_tpl->tpl_vars['order']->value['orderid'];?>
"/>

                    <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd;border-top:0px;">
                        <tr>
                            <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;border-top:0px;">
                                <textarea name="remarks" style="width: 60%;height: 80px;" class='text-tips' tips="请输入备注信息..."><?php echo $_smarty_tpl->tpl_vars['order']->value['remarks'];?>
</textarea>
                            </td>
                        </tr>
                    </table>

             	<table class="tabelLR" style="border:1px solid #ddd;">

                  <tr>
                    <td style="text-align:left;text-indent:2em;border-right:1px solid #ddd">
                        <?php if ($_smarty_tpl->tpl_vars['order']->value['status'] == 1) {?>
                        <input type='submit' class="btn5"  value='确认付款'>
                        <?php }?>
                        <!--<input type='button' class="btn5 submit_btn"  value='取消'>-->
                        <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderlist" class="btn5 submit_btn" style="display: inline-block">取消</a>
                    </td>
                  </tr>
                </table>
                </form>



            </div>
          </div>
        </div>
    </div>
<div class="clearfix"></div>

    <?php echo '<script'; ?>
 type="text/javascript">
        $('.submit_btn').click(function () {
            var url = $(this).attr('submit-url');
            $('#operation-form').attr('action', url);
            $('#operation-form').submit();
        });
    <?php echo '</script'; ?>
>
</body>
</html><?php }
}
