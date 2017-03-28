<?php
/* Smarty version 3.1.30, created on 2017-03-10 12:58:30
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\order\consumeInfo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c2327665c9c3_03529154',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '27acb964f3a17b1a6497025d04112a1b3734a885' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\order\\consumeInfo.html',
      1 => 1489121908,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58c2327665c9c3_03529154 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">消费记录</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel mt10">
                <dl class="navTab" style='padding-left:1px;border:0px;'>
                    <dt class="on" style='display:block;padding:0 10px;'>消费记录</dt>
                </dl>
             	<table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd">
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;">用户名</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd">
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['username']) {?>
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['username'];?>

                        <?php } else { ?>
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['email'];?>

                        <?php }?>
                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%">纪念馆</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd">
                       <?php echo $_smarty_tpl->tpl_vars['info']->value['memorial_name'];?>

                    </td>
                  </tr>
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;width:20%;border-right:1px solid #ddd">消费项目</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-right:1px solid #ddd">
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['gname'];?>

                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;width:20%;border-right:1px solid #ddd">消费元宝</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-right:1px solid #ddd">
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['num']*$_smarty_tpl->tpl_vars['info']->value['price'];?>

                    </td>
                  </tr>
                </table>

                <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd;border-top:0px;">
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">消费纪念馆</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;border-top:0px;">
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['memorial_name']) {?>
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['memorial_name'];?>

                        <?php } else { ?>
                        储物箱
                        <?php }?>

                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">时间</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd;border-top:0px;">
                        <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['info']->value['addtime'],'%Y-%m-%d %H:%M:%S');?>

                    </td>
                  </tr>
                </table>

                <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd;border-top:0px;">
                    <tr>
                        <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">是否放置到纪念馆</th>
                        <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;border-top:0px;">
                            <?php if ($_smarty_tpl->tpl_vars['info']->value['place'] == 1) {?>
                                已放置
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['info']->value['place'] == 2) {?>
                                未放置
                            <?php }?>
                        </td>

                        <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">商品数量</th>
                        <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd;border-top:0px;">
                            <?php echo $_smarty_tpl->tpl_vars['info']->value['num'];?>

                        </td>
                    </tr>
                </table>
                <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/orderConfirm" method="post">
                    <input type="hidden" name="orderid" value="<?php echo $_smarty_tpl->tpl_vars['order']->value['orderid'];?>
"/>





            </div>
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
