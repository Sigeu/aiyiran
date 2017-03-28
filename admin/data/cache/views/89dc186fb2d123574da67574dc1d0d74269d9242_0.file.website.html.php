<?php
/* Smarty version 3.1.30, created on 2017-01-06 15:44:58
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\system\website.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f4afad5b216_87682885',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89dc186fb2d123574da67574dc1d0d74269d9242' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\system\\website.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_586f4afad5b216_87682885 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<body>
<form method="post" id="thisform" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/System/updateParameter" enctype="multipart/form-data">
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxC">
          <div>
            <div class="pubTabel mt10">
              <table class="tabelLR">
                <tr>
                  <th width="150px"> 站点名称：</th>
                  <td><input class="Iw290" id="mo_webname" name="mo_webname" type="text" value="<?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_webname'];?>
"/></td>
                </tr>
                <tr>
                  <th> 站点域名：</th>
                  <td><input class="Iw290" id="mo_basehost" name="mo_basehost" type="text" value="<?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_basehost'];?>
"/></td>
                </tr>
                <tr>
                  <th style="vertical-align:top;"> 外观设置：</th>
                  <td>
                    <span id="single-upload">
                      <img src="<?php echo $_smarty_tpl->tpl_vars['uploadpath']->value;
echo $_smarty_tpl->tpl_vars['parameter']->value['mo_logo_dir'];?>
" width="200px;" height="30px;" onerror="javascript:this.src='<?php echo $_smarty_tpl->tpl_vars['imgpath']->value;?>
/default_logo.png';" />&nbsp;&nbsp;&nbsp;图片ALT注释：<input type="text" name="mo_logo_alt" value="<?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_logo_alt'];?>
" maxlength="100"/>
                    </span> 
                    <input class="btn5" hideFocus="" onclick="uploadAccessory({'limit':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
','_switch':'brand','self_id':'uploadButton','ady_upload':1,'dis_place':'single-upload'})" type="button" value="浏览" id="uploadButton"/><br/><br/>
                    <select class="Iw290 mt5" name="template_style" style="width:300px;" disabled>
                        <!--<option value="0">选择网站模板</option>-->
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['template']->value, 'list');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['list']->value['identify'];?>
" <?php if ($_smarty_tpl->tpl_vars['list']->value['disable'] == 1) {?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['list']->value['name'];?>
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
                  <th> 网站首页标题：</th>
                  <td><input class="Iw290" ID="mo_title" name="mo_title" type="text" value="<?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_title'];?>
"/></td>
                </tr>
                <tr>
                  <th> 网站关键词：</th>
                  <td><input class="Iw290" ID="mo_keywords" name="mo_keywords" type="text" value="<?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_keywords'];?>
"/></td>
                </tr>
                <tr>
                  <th style="vertical-align:top;"> 网站描述：</th>
                  <td><textarea class="Iw450 Ih80" id="mo_description" name="mo_description"><?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_description'];?>
</textarea></td>
                </tr>
                <tr>
                  <th> 网站备案号：</th>
                  <td><input class="Iw290" name="mo_beian" Id="mo_beian" type="text" value="<?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_beian'];?>
"/></td>
                </tr>
                <tr>
                  <th style="vertical-align:top;"> 网站版权信息：</th>
                  <td><textarea class="Iw450 Ih80" id="mo_powerby" name="mo_powerby"><?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_powerby'];?>
</textarea></td>
                </tr>

				<tr>
					<th style="vertical-align:top;border-bottom:none"> 爱站版权信息：</th>
					<td style="border-bottom:none">
						<span><input type="radio" <?php if ($_smarty_tpl->tpl_vars['is_license']->value != 1) {?>disabled<?php }?> name="mo_izhan_copyright" value="Y" <?php if ($_smarty_tpl->tpl_vars['parameter']->value['mo_izhan_copyright'] == 'Y') {?>checked<?php }?>/><label>开启</label></span>&nbsp;&nbsp;&nbsp;&nbsp;
						<span><input type="radio" <?php if ($_smarty_tpl->tpl_vars['is_license']->value != 1) {?>disabled<?php }?> name="mo_izhan_copyright" value="N" <?php if ($_smarty_tpl->tpl_vars['parameter']->value['mo_izhan_copyright'] == 'N') {?>checked<?php }?>/><label>关闭</label></span>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php if ($_smarty_tpl->tpl_vars['is_license']->value != 1) {?>温馨提示：未授权无法修改（<a href="http://izhancms.com/category/Category/index/cid/4" title="授权中心" target="_blank" style="color:red">点击购买授权</a>）！<?php }?>
					</td>
				</tr>

				<tr>
					<th style="vertical-align:top;"> 前台显示样式：</th>
					<td></td>
				</tr>

                <tr>
                  <th> 关闭站点：</th>
                  <td><span>
                    <input type="radio" name="mo_shut_down" id="just" onclick="show_reason();" value ="Y" <?php if ($_smarty_tpl->tpl_vars['parameter']->value['mo_shut_down'] == 'Y') {?> checked="true" <?php }?>/>
                    <label>是</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name="mo_shut_down" onclick="hide_reason();" value="N" <?php if ($_smarty_tpl->tpl_vars['parameter']->value['mo_shut_down'] == 'N') {?> checked="true" <?php }?>/>
                    <label>否</label>
                    </span></td>
                </tr>
                <tr style="display:none" id="hide_or_show">
                  <th style="vertical-align:top;"> 关闭原因：</th>
                  <td><textarea class="Iw450 Ih80" id="mo_shut_reason" name="mo_shut_reason"><?php echo $_smarty_tpl->tpl_vars['parameter']->value['mo_shut_reason'];?>
</textarea></td>
                </tr>
              </table>
              <div class="pubTabelBot">
                <input type="submit" value="确定" class="btn1" />
                <input type="button" value="取消" onclick="location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/System/index'" class="btn2" />
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

$(document).ready(function(){
$.formValidator.initConfig({formid:"thisform",autotip:true,debug:false,submitonce:true,onerror:function(msg,obj,errorlist){}});

$("#mo_webname").formValidator({onshow:" ",onfocus:"请输入1-50个字符",oncorrect:"输入正确",empty:true})
.inputValidator({min:1,max:50,onerror:"请输入1-50个字符"});

$("#mo_basehost").formValidator({onshow:" ",onfocus:"请输入1-50个字符",oncorrect:"输入正确",empty:true})
.inputValidator({min:1,max:50,onerror:"请输入1-50个字符"});

$("#mo_beian").formValidator({onshow:" ",onfocus:"请输入1-50个字符",oncorrect:"输入正确",empty:true})
.inputValidator({min:1,max:50,onerror:"请输入1-50个字符"});

$("#mo_title").formValidator({onshow:" ",onfocus:"请输入0-62个字符",oncorrect:"输入正确",empty:true})
.inputValidator({min:0,max:62,onerror:"请输入0-62个字符",onerrormax:"最多输入62个字符"});

$("#mo_keywords").formValidator({onshow:' ',onfocus:'请输入0-200个字符，多个关键词之间用","隔开',oncorrect:"输入正确",empty:true})
.inputValidator({min:0,max:200,onerror:"请输入0-200个字符",onerrormax:"最多输入200个字符"});

$("#mo_description").formValidator({onshow:" ",onfocus:"请输入0-300个字符",oncorrect:"输入正确",empty:true})
.inputValidator({min:0,max:300,onerror:"请输入0-300个字符",onerrormax:"最多输入300个字符"});

$("#mo_powerby").formValidator({onshow:" ",onfocus:"请输入10-500个字符",oncorrect:"输入正确",empty:true})
.inputValidator({min:10,max:500,onerror:"请输入10-500个字符"});

});

function show_reason()
{
    $("#hide_or_show").show();    
}

function hide_reason()
{
    $("#hide_or_show").hide();    
}

window.onload = function(){
    if($("#just").attr('checked') == 'checked'){
        $("#hide_or_show").show();
    }
};


/*
*  -------------------------------------------------
*   自定义上传方法
*  -------------------------------------------------
*/
function uploadAccessory (obj)
{	
	var option=
	{
		upload_id:'accessory_upload',
		title:'图片上传',
		return_id:'accessory',
		callFunName:'accessoryUpload',
		setting:'<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
',
		param:obj
	};
	MainOneUpload(option);//调用统一上传方法
}
<?php echo '</script'; ?>
>

<?php }
}
