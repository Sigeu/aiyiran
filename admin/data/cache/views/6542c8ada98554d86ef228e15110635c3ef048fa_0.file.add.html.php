<?php
/* Smarty version 3.1.30, created on 2017-03-13 14:45:31
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\cemetery\add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c6400b6ca7d1_04667732',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6542c8ada98554d86ef228e15110635c3ef048fa' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\cemetery\\add.html',
      1 => 1481514924,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/baseurl.html' => 1,
  ),
),false)) {
function content_58c6400b6ca7d1_04667732 (Smarty_Internal_Template $_smarty_tpl) {
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
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/add' method='post' name=form1 id='myform' enctype="multipart/form-data">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="javascript:;">陵园信息管理</a></dt>
            <dt><a href="javascript:;">关于陵园</a></dt>
            <dt><a href="javascript:;">陵园景观</a></dt>
            <dt><a href="javascript:;">陵园服务</a></dt>
            <dt><a href="javascript:;">地理位置</a></dt>
            <!-- <dt><a href="javascript:;">陵园资讯</a></dt> -->
          </dl>
        </div>
        <div class="TabBoxC">
            <!--  陵园基本信息  -->
            <div>
                <div class="pubTabel">
                    <table class="tabelLR">
                                   <?php echo $_smarty_tpl->tpl_vars['form']->value['tupian'];?>

                        <tr>
                            <th width="145px"><font>*</font> 陵园名称：</th>
                            <td colspan="3"><input type="text" name="title" class="Iw290" value=""/></td>
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
"><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
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
" ><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    </td>
                        </tr>

                            <th>&nbsp; 陵园地址：</th>
                            <td colspan="3"><input type="text" name="address" class="Iw290" value=""/></td>
                        </tr>
                        <tr>
                            <th>&nbsp; 陵园电话：</th>
                            <td colspan="3"><input type="text" name="tel" class="Iw290" value=""/></td>
                        </tr>
                        <tr>
                            <th>&nbsp; 陵园摘要：</th>
                            <td colspan="3"><textarea name="summary" style="width: 288px; height: 50px;"></textarea></td>
                        </tr>
                        </tr>
                                   <th>发布状态：</th>
                                    <td  colspan="3">
                                       <select name="status">
                                         <option value="1"
                                         >发布</option>
                                         <option value="2"
                                         >不发布</option>
                                        </select>
                                    </td>
                                </tr>
                    </table>
                </div>
            </div>

            <!--  关于陵园  -->
            <div style="display:none;">
                <div class="pubTabel">
                    <table>
                         <tr>
                            <th width="145px"><font>*</font> 陵园简介：</th>
                            <td ><div class="edit_box" style="height:auto"><textarea name="summary" id="content1"></textarea></div></td>
                        </tr>
                        <tr>
                            <th width="145px"><font>*</font> 陵园荣誉：</th>
                            <td ><div class="edit_box" style="height:auto"><textarea name="honor" id="content2"></textarea></div></td>
                        </tr>
                        <tr>
                            <th width="145px"><font>*</font> 陵园文化：</th>
                            <td ><div class="edit_box" style="height:auto"><textarea name="culture" id="content3"></textarea></div></td>
                            </tr>
                    </table>
                </div>
            </div>

            <!--  陵园景观  -->
            <div style="display:none;">
                <div class="pubTabel">
                     <table>
                                   <?php echo $_smarty_tpl->tpl_vars['form']->value['tupian2'];?>

                    </table>
                </div>
            </div>

            <!--  陵园服务  -->
            <div style="display:none;">
                <div class="pubTabel">
                     <table>
                         <tr>
                            <th width="145px"><font>*</font> 陵园服务：</th>
                            <td ><div class="edit_box" style="height:auto"><textarea name="server" id="content4"></textarea></div></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- 地理位置 -->
            <div style="display:none;">
                <div class="pubTabel">
                     <table>
                         <tr>
                            <th width="145px"><font>*</font> 生成地图</th>
                            <td ><input type="text" name="map_name" value=""></td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>
        <div class="pubTabelBot">
           <input type="submit" name="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/link/index'">
        </div>
        </form>
      </div>
    </div>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
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
<?php echo '<script'; ?>
>$(document).ready(function(){init("content4", "加载失败");})<?php echo '</script'; ?>
>

</body>
</html><?php }
}
