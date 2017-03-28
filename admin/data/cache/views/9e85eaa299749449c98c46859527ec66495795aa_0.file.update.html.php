<?php
/* Smarty version 3.1.30, created on 2017-01-06 17:04:00
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\cemetery\update.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f5d80ea2a36_26830770',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9e85eaa299749449c98c46859527ec66495795aa' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\cemetery\\update.html',
      1 => 1481098581,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/baseurl.html' => 1,
    'file:public/cemetery_public.html' => 1,
  ),
),false)) {
function content_586f5d80ea2a36_26830770 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title></title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"  title="basc"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/bascB.css" rel="alternate stylesheet" type="text/css" title="bascB"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/bascG.css" rel="alternate stylesheet" type="text/css" title="bascG"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/bascR.css" rel="alternate stylesheet" type="text/css" title="bascR"/>

<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleL.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleX.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/validator.css" rel="stylesheet" type="text/css"/>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php $_smarty_tpl->_subTemplateRender("file:public/baseurl.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/styleswitch.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/My97DatePicker/WdatePicker.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/plugins/iframeTools.source.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/formvalidator.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/formvalidatorregex.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/floatcheck.js"><?php echo '</script'; ?>
>
<style type="text/css">
 #gray{color:#ccc;text-decoration:none;}
</style>
</head>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/city.js"><?php echo '</script'; ?>
>

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
        $(".b").addClass("on");
    })
<?php echo '</script'; ?>
>
        <?php $_smarty_tpl->_subTemplateRender("file:public/cemetery_public.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

 <?php echo '<script'; ?>
 type="text/javascript">
         $(function(){
 var baseUrl = "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/area";
  $("#originp,#brithp,#diedp").change(function(){
    var va = $(this).val();
    var idConn = $(this).attr("date-city");
    //alert(idConn);
    $.get(baseUrl,{id:va},function(date){
      $("#"+idConn).html(date);
    },"html");
  });
 })
      <?php echo '</script'; ?>
>
            <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/update' method='post' name=form1 id='myform'>
                <div class="TabBoxC">
                    <div>
                        <div class="pubTabel">
                            <table class="tabelLR">
                               <tr>
                                    <th valign="top">&nbsp;&nbsp;<font>*</font>陵园照片：</th>
                                    <td>
                                     
                                        <div id="img-adta-0" style="display:none"></div>
                                        <img class="mt5" src="/static/uploadfile<?php echo $_smarty_tpl->tpl_vars['updata']->value['photo_url'];?>
" id="img0" onclick="uploadAccessory({'upload_id':'0','limit':'2','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-0','img_id':'img0','hid_id':'hid0'})" width="110" height="86" style="cursor:pointer">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="180px">&nbsp;&nbsp;<font>*</font>陵园名称：</th>
                                    <td>
                                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['updata']->value['title'];?>
" class="Iw290" name='title' id='name'/>&nbsp;<span id='nameTip'></span>
                                    </td>
                                </tr>

                            <tr>
                                    <th>&nbsp;籍贯：</th>
                                    <td>
                                    <select name="province" id="originp" date-city="originc">
                                     <option value="">省份</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['area']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" 
                                        <?php if ($_smarty_tpl->tpl_vars['updata']->value['province'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>
                                      ><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <select name="city" id="originc">
                                     <option value="">省份</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['originInfo']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" 
                                            <?php if ($_smarty_tpl->tpl_vars['updata']->value['city'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>
                                      ><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
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
                                    <th width="180px">&nbsp;&nbsp;<font>*</font>陵园地址：</th>
                                    <td>
                                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['updata']->value['address'];?>
" class="Iw290" name='address' id='personname'/>&nbsp;<span id='personnameTip'></span>
                                    </td>
                                </tr>
                                 <tr>
                                    <th width="180px">&nbsp;&nbsp;<font>*</font>陵园电话：</th>
                                    <td>
                                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['updata']->value['tel'];?>
" class="Iw290" name='tel' id='personname'/>&nbsp;<span id='personnameTip'></span>
                                    </td>
                                </tr>
                                   <th width="180px">&nbsp;&nbsp;<font>*</font>陵园摘要：</th>
                                    <td>
                                        <textarea style="width: 288px; height: 50px;" name="summary"><?php echo $_smarty_tpl->tpl_vars['updata']->value['summary'];?>
</textarea>
                                    </td>
                                </tr>
                                </tr>
                                   <th width="180px">&nbsp;&nbsp;<font>*</font>发布状态：</th>
                                    <td>
                                       <select name="status">
                                         <option value="1" <?php if ($_smarty_tpl->tpl_vars['updata']->value['status'] == 1) {?>selected=''<?php }?>
                                         >发布</option>
                                         <option value="2" <?php if ($_smarty_tpl->tpl_vars['updata']->value['status'] == 2) {?>selected=''<?php }?>
                                         >不发布</option>
                                        </select>
                                    </td>
                                </tr>
                                <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['updata']->value['id'];?>
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
/memorial/cemetery/delpic",
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
