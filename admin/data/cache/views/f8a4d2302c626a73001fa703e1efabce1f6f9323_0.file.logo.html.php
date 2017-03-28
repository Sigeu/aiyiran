<?php
/* Smarty version 3.1.30, created on 2017-02-16 10:35:13
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\backstage\logo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a50fe18c7eb5_32826880',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f8a4d2302c626a73001fa703e1efabce1f6f9323' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\backstage\\logo.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a50fe18c7eb5_32826880 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<body>
  <form method="POST" id="thisform" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/backlogo/updateLogo" enctype="multipart/form-data" >
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="javascript:void(0)">授权后台LOGO设置</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <table class="tabelLR">

                  <?php if ($_smarty_tpl->tpl_vars['empower']->value == '2') {?><div style="margin:10px 0px 10px 20px;">温馨提示：未授权无法修改（<a href="http://www.izhancms.com/category/Category/index/cid/4" target="_blank"><font style="color:red">点击购买授权</font></a>）</div><?php }?>

                <tr>
                  <th>后台LOGO：</th>
                  <td>
				  <span id="single-upload"><img src="<?php echo $_smarty_tpl->tpl_vars['imgpath']->value;?>
/logo.png" width="190px;" height="36px;" style="margin-top:-5px;margin-left:-250px; position: absolute"/></span>&nbsp;
                    <input class="btn5" type="button"<?php if ($_smarty_tpl->tpl_vars['empower']->value == '2') {?>disabled <?php }?> value="更换" name="accessory" style="position: relative;top: 3px;" onclick="uploadAccessory({'limit':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
','_switch':'brand','self_id':'uploadButton','ady_upload':1,'dis_place':'single-upload'});" handle="single-upload" id="uploadButton"/></td>
                </tr>

              </table>
              <div class="pubTabelBot">
                <input type="submit" value="确定" <?php if ($_smarty_tpl->tpl_vars['empower']->value == '2') {?>class="btn2" disabled <?php } else { ?> class="btn1" <?php }?>>
                <input type="button" value="取消" class="btn2" >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      </form>
    <div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
function uploadAccessory (obj)
{	
	var option=
	{
		upload_id:'accessory_upload',
		title:'上传LOGO',
		return_id:'accessory',
		callFunName:'accessoryUpload',
		setting:'<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
',
		param:obj
	};
	MainOneUpload(option);
}
<?php echo '</script'; ?>
><?php }
}
