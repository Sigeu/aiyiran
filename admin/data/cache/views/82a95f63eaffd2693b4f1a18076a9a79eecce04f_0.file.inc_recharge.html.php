<?php
/* Smarty version 3.1.30, created on 2017-03-10 17:35:19
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\order\inc_recharge.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c27357d75384_08159696',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '82a95f63eaffd2693b4f1a18076a9a79eecce04f' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\order\\inc_recharge.html',
      1 => 1489138516,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58c27357d75384_08159696 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
<div class="pubBox" style="min-height: 350px;">
    <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/modrecharge" method='post' id='operation-form'>
    <div class="pubtabBox">

        <div class="TabBoxC">
            <div>
                <div class="pubTabel">
                    <dl class="navTab" style='padding-left:1px;border:0px;'>
                        <dt class="on" style='display:block;padding:0 10px;'>账户充值</dt>
                    </dl>

                    <table class="tabelLR" style="border:1px solid #ddd;border-bottom:dashed 1px #ddd">
                        <tr>
                            <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;">元宝数量</th>
                            <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd">
                                <input type="text" id="mo_webname" name="point">
                            </td>

                        </tr>

                        <tr>
                            <th style="text-align:center;text-indent:0px;background:#eee;border:1px solid #ddd;width:20%;">备注</th>
                            <td style="text-indent:1em;text-align:left;width:30%;border:1px solid #ddd;height: 100px;">
                                <textarea name="remarks" id="beizhu" cols="30" rows="10"><?php echo $_smarty_tpl->tpl_vars['info']->value['remarks'];?>
</textarea>
                            </td>

                        </tr>
                        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
">
                        </table>



                </div>
            </div>
        </div>
    </div>



    </form>

</div>
<div class="clearfix"></div>

<!--<?php echo '<script'; ?>
 type="text/javascript">-->
    <!--$('.submit_btn').click(function () {-->
        <!--var url = $(this).attr('submit-url');-->
        <!--$('#operation-form').attr('action', url);-->
        <!--$('#operation-form').submit();-->
    <!--});-->
<!--<?php echo '</script'; ?>
>-->
</body>
</html>

<?php echo '<script'; ?>
>
    $(document).ready(function() {
        $.formValidator.initConfig({formid:"thisform",autotip:true,debug:false,submitonce:true,onerror:function(msg,obj,errorlist){}});
        $("#mo_webname").formValidator({onshow:"(必填)",onfocus:"请输入数字",oncorrect:"输入正确",empty:false})
                .inputValidator({min:1,max:50,onerror:"请输入数字"});
        $("#mo_basehost").formValidator({onshow:"(必填)",onfocus:"请输入1-255个字符",oncorrect:"输入正确",empty:true})
                .inputValidator({min:1,max:50,onerror:"请输入1-255个字符"});
    });
<?php echo '</script'; ?>
><?php }
}
