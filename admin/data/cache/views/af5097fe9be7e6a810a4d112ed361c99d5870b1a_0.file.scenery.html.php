<?php
/* Smarty version 3.1.30, created on 2017-01-13 18:51:13
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\cemetery\scenery.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5878b121abbe91_76957331',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af5097fe9be7e6a810a4d112ed361c99d5870b1a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\cemetery\\scenery.html',
      1 => 1479440335,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
    'file:public/cemetery_public.html' => 1,
  ),
),false)) {
function content_5878b121abbe91_76957331 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<!-- layer插件 -->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/skin/default/layer.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/layer.js"><?php echo '</script'; ?>
>
<style type="text/css">
    .pic{width: 15px; height: 15px;position: relative;left: -22px; top: -1px;
    display: inline-block; cursor: pointer;}
    .pic img{width: 15px; height: 15px;}
</style>
<body>
    <div class="pubBox" >
        <div class="pubtabBox">
<?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
        $(".d").addClass("on");
    })
<?php echo '</script'; ?>
>
        <?php $_smarty_tpl->_subTemplateRender("file:public/cemetery_public.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


            <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/scenery' method='post' id='myform'>
                <div class="TabBoxC">
                    <div>
                        <div class="pubTabel">
                            <table class="tabelLR">
                               <tr>
                                    <th width="100px;"><font>*</font>陵园景观：</th>
                                    <td>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['photo']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                        <img width="70" class="del_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" src="/static/uploadfile<?php echo $_smarty_tpl->tpl_vars['item']->value['photo_url'];?>
">
                                        <span class="pic" id="pic_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" data="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><img src="/static/uploadfile/logo/delete.png" class="del_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"></span>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                        <div id="img-adta-0" style="display:none"></div>
                                        <img class="mt5" src="/admin/template/images/img_downl.png" id="img0" onclick="uploadAccessory({'upload_id':'0','limit':'2','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-0','img_id':'img0','hid_id':'hid0'})" width="110" height="86" style="cursor:pointer">
                                    </td>
                                </tr>
                                
                                 <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
                              </table>
                            <div class="pubTabelBot"><input type="submit" name="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/index'"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
 <?php echo '<script'; ?>
>
 /*
*  -------------------------------------------------
*   自定义上传方法
*  -------------------------------------------------
*/
var _acc_option=
{
    upload_id:'accessory_upload',
    title:'附件上传',
    return_id:'accessory',
    callFunName:'accessoryUpload',
    setting:'<?php echo $_smarty_tpl->tpl_vars['picsetting']->value;?>
',
    param:{}
};

function uploadAccessory (obj)
{   
    _acc_option.param = obj;
    MainOneUpload(_acc_option);//调用统一上传方法
}

 <?php echo '</script'; ?>
>

 <!-- 删除轮播图ajax -->
 <?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
         $(".pic").click(function(){
        var id = $(this).attr('data');
        var idx = layer.confirm('确认删除吗', {
            btn: ['确认','取消'] //按钮
                        }, function(){
                            $.ajax({
                                type: "Post",
                                url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/sceneryDel",
                                data: {"id":id},
                                dataType: "json",
                                success: function(data) {
                                    if (data.status == 1) {
                                        layer.msg(data.msg, {icon: 1});
                                        $('.del_'+id).remove();
                                    } else {
                                        layer.msg(data.msg, {icon: 2});
                                    };
                                }
                            });
                        }, function(){
                         layer.close(idx);
            });
    });
    });
     
 <?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
