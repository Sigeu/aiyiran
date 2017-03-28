<?php
/* Smarty version 3.1.30, created on 2017-01-06 15:07:10
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\acer\photocatadd.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f421e842777_99475888',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44aefcf318c13bdb57df4fe793d8f13583e7e099' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\acer\\photocatadd.html',
      1 => 1478676407,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_586f421e842777_99475888 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
$(function(){
    $.formValidator.initConfig({formid:"myform",autotip:false,generalwordwide:true});
    
    $("#name").formValidator({empty:false,onshow:"请输入2-50字符",onfocus:"请输入2-50字符",oncorrect:"输入正确"})
    .inputValidator({min:2,max:50,onerror:"请输入2-50字符"});
<?php echo '</script'; ?>
>
<body>
    <div class="pubBox" >
        <div class="pubtabBox">
            <div class="TabBoxT">
                <dl class="navTab">     
                    <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photo">相册列表</a></dd>
                    <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photocatadd" class="last">添加相册</a></dt>
                    <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photoadd" class="last">上传照片</a></dd>
                </dl>
            </div>

            <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photocatadd' method='post' id='myform'>
                <div class="TabBoxC">
                    <div>
                        <div class="pubTabel">
                            <table class="tabelLR">
                                <tr>
                                    <th width="170px"><font>*</font> 相册名称：</th>
                                    <td>
                                        <input type="text" value="" class="Iw290" name='name' id='name'/>&nbsp;<span id='nameTip'></span>
                                    </td>
                                </tr>
                                <tr>
                                   <th><font>*</font>相册封面：</th>
                                    <td>
                                        <div id="img-adta-0" style="display:none"></div>
                                        <img class="mt5" src="/admin/template/images/img_downl.png" id="img0" onclick="uploadAccessory({'upload_id':'0','limit':'2','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-0','img_id':'img0','hid_id':'hid0'})" width="110" height="86" style="cursor:pointer">
                                    </td>
                                </tr>

                                <!-- <tr>
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：</th>
                                    <td>
                                        <input type="text" value="0" class="Iw290" name='sort' id='sort'/>&nbsp;<span id='memberTip'></span>
                                    </td>
                                </tr>
 -->
                            
                            </table>
                            <div class="pubTabelBot"><input type="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
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
function uploadAccessory (obj)
{   

    var option={
        upload_id:'logo',
        title:'相册封面',
        return_id:'accessory',  
        callFunName:'accessoryUpload',
        setting:'<?php echo $_smarty_tpl->tpl_vars['picsetting']->value;?>
',
        param:obj
    };
    MainOneUpload(option);
}

<?php echo '</script'; ?>
>
 <?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
