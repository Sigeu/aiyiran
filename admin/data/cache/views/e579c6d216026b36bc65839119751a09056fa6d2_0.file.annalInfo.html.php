<?php
/* Smarty version 3.1.30, created on 2017-03-09 11:29:31
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\order\annalInfo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c0cc1b589018_09441535',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e579c6d216026b36bc65839119751a09056fa6d2' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\order\\annalInfo.html',
      1 => 1489030168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58c0cc1b589018_09441535 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">账户变动信息</a></dt>
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
                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;">用户名</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd">
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['username']) {?>
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['username'];?>

                        <?php } else { ?>
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['email'];?>

                        <?php }?>
                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%">充值备注</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd">
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 1) {?>在线充值<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 2) {?>系统奖励<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 3) {?>系统扣除<?php }?>
                    </td>
                  </tr>
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;width:20%;border-right:1px solid #ddd">账户元宝数量</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-right:1px solid #ddd">
                        <?php echo $_smarty_tpl->tpl_vars['info']->value['ss'];?>

                    </td>
                      <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">本次账户变动元宝数量</th>
                      <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd;border-top:0px;">
                         + <?php echo $_smarty_tpl->tpl_vars['info']->value['point'];?>

                      </td>

                  </tr>
                </table>

                <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd;border-top:0px;">
                  <tr>
                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">支付方式</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;border-top:0px;">
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 1) {?>在线充值<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 2) {?>系统奖励<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 3) {?>系统扣除<?php }?>
                    </td>

                    <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">账户变动状态</th>
                    <td style="text-indent:1em;text-align:left;width:30%;border-bottom:1px solid #ddd;border-top:0px;">
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 1) {?>在线充值成功<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 2) {?>系统奖励成功<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['info']->value['pay_type'] == 3) {?>系统扣除成功<?php }?>
                    </td>
                  </tr>
                </table>

                <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd;border-top:0px;">
                    <tr>
                        <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;border-top:0px;">产品名称</th>
                        <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;border-top:0px;">
                            元宝
                        </td>

                        <th style="text-align:center;text-indent:0px;background:#eee;width:20%;border-right:1px solid #ddd">变动时间</th>
                        <td style="text-indent:1em;text-align:left;width:30%;border-right:1px solid #ddd">
                            <?php if ($_smarty_tpl->tpl_vars['info']->value['addtime'] != 0) {?>
                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['info']->value['addtime'],'%Y-%m-%d %H:%M:%S');?>

                            <?php }?>
                        </td>
                    </tr>
                </table>



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
