<?php
/* Smarty version 3.1.30, created on 2017-01-13 18:51:12
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\cemetery\about.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5878b1207f40d5_00271512',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ba41a15dc19d3801330b83ecb580ce81e01c7016' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\cemetery\\about.html',
      1 => 1481093214,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
    'file:public/cemetery_public.html' => 1,
  ),
),false)) {
function content_5878b1207f40d5_00271512 (Smarty_Internal_Template $_smarty_tpl) {
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
        $(".c").addClass("on");
    })
<?php echo '</script'; ?>
>
        <?php $_smarty_tpl->_subTemplateRender("file:public/cemetery_public.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


            <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/about' method='post' id='myform'>
                <div class="TabBoxC">
                    <div>
                        <div class="pubTabel">
                            <table class="tabelLR">
                              
                                <tr>
                                    <th width="180px">&nbsp;&nbsp;<font>*</font>陵园简介：</th>
                                        <td ><div class="edit_box" style="height:auto"><textarea name="summary" id="content1"><?php echo $_smarty_tpl->tpl_vars['data']->value['summary'];?>
</textarea></div></td>
                                    </td>
                                </tr>

                                <tr>
                                    <th width="180px">&nbsp;&nbsp;<font>*</font>陵园荣誉：</th>
                                        <td ><div class="edit_box" style="height:auto"><textarea name="honor" id="content2"><?php echo $_smarty_tpl->tpl_vars['data']->value['honor'];?>
</textarea></div></td>
                                    </td>
                                </tr>

                                <tr>
                                    <th width="180px">&nbsp;&nbsp;<font>*</font>陵园文化：</th>
                                        <td ><div class="edit_box" style="height:auto"><textarea name="culture" id="content3"><?php echo $_smarty_tpl->tpl_vars['data']->value['culture'];?>
</textarea></div></td>
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

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/iniEditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>$(document).ready(function(){init("content1", "加载失败");})<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>$(document).ready(function(){init("content2", "加载失败");})<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>$(document).ready(function(){init("content3", "加载失败");})<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
