<?php
/* Smarty version 3.1.30, created on 2017-01-06 16:45:29
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\funeray\add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f5929468d75_35751132',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '47d58316980c2c22060274379a5212250588845c' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\funeray\\add.html',
      1 => 1483692322,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_586f5929468d75_35751132 (Smarty_Internal_Template $_smarty_tpl) {
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
                    <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/funeray/lists" class="last">商品列表</a></dt>
                <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/funeray/add" class="last">添加商品</a></dd>
                </dl>
            </div>

            <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/funeray/add' method='post' id='myform'>
                <div class="TabBoxC">
                    <div>
                        <div class="pubTabel">
                            <table class="tabelLR">
                                <tr>
                                    <th width="170px"><font>*</font> 商品分类：</th>
                                    <td>
                                      <select name="cid" id="">
                                          <option value="">请选择商品分类</option>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cate']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['cate'];?>
</option>
                                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="170px"><font>*</font> 商品名称：</th>
                                    <td>
                                        <input type="text" value="" class="Iw290" name='gname' id='name'/>&nbsp;<span id='nameTip'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="170px"><font>*</font> 商品logo：</th>
                                     <td>
                                        <div id="img-adta-0" style="display:none"></div>
                                        <img class="mt5" src="/admin/template/images/img_downl.png" id="img0" onclick="uploadAccessory({'upload_id':'0','limit':'2','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-0','img_id':'img0','hid_id':'hid0'})" width="110" height="86" style="cursor:pointer">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="170px"><font>*</font> 价格：</th>
                                    <td>
                                        <input type="text" value="" class="Iw90" name='price' id='acer'/>&nbsp;<span id='nameTip'>元</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="170px"><font>*</font> 上架期限：</th>
                                    <td>
                                        <input type="text" value="" class="Iw90" name='gtime' id='acer'/>&nbsp;<span id='nameTip'>天</span>
                                    </td>
                                </tr>
                                
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
</body>
</html>
<?php }
}
