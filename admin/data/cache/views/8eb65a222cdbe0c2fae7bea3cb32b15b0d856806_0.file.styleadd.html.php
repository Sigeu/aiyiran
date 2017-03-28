<?php
/* Smarty version 3.1.30, created on 2017-02-14 15:33:32
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\moreset\styleadd.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2b2cc77b5b9_68378882',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8eb65a222cdbe0c2fae7bea3cb32b15b0d856806' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\moreset\\styleadd.html',
      1 => 1487057608,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a2b2cc77b5b9_68378882 (Smarty_Internal_Template $_smarty_tpl) {
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
 })
<?php echo '</script'; ?>
>
<body>
	<div class="pubBox" >
		<div class="pubtabBox">
			<div class="TabBoxT">
				<dl class="navTab">     
                     <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/style">模板列表</a></dt>
                     <dd  class="on"><a href="" class="last">添加模板</a></dd>
				</dl>
			</div>

			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/addstyle' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>模板名称：</th>
									<td>
										<input type="text" value="" class="Iw290" name='name' id='name'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>
                               <tr id="webLogo">
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>模板图片：</th>
									<td>
										<span id="single-upload"><input type="text" name="" class="Iw290" value="" /></span>
										<input class="btn5" hideFocus="" type="button" value="浏览" onclick="uploadAccessory({'limit':1,'_switch':'friend_link','self_id':'logo_uploadButton','ady_upload':1,'dis_place':'single-upload','check_id':'logo','show_id':'logo_show'})" id="logo_uploadButton">
										<input type="hidden" id="logo" value="" _required=2/><span id='logoTip'></span>
									</td>
								<tr>
                                <tr>
                                <!--<tr>
									<th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>模板图片：</th>
									<td>
                                     <input type="text" readonly  value="" class="Iw290" id="thumb_show" name="info[thumb]"/>
                                     <input type="button" hidefocus="hide" value="浏览" class="btn5" onclick="thumbuploadAccessory({'limit':'2','_switch':'upload_image','self_id':'thumb_uploadButton','ady_upload':1,'dis_place':'thumbsingle-upload','check_id':'thumb','show_id':'thumb_show'})" id="thumb_uploadButton"/>
                                     <input type="hidden" id="thumb" value="" _required=2 />&nbsp;&nbsp;&nbsp;<input id="del_button"  type="button" hidefocus="hide" value="删除" class="btn5"  onclick="thumbdeleteUpload()"/>
										<p style="padding-bottom:5px;">
											<input onclick="uploadAccessory({'limit':'20','_switch':'accessory','self_id':'uploadButton','check_id':'isUpload'})" id="uploadButton" type="button" value="浏览上传" class="btn5" />
											<input type="hidden" id="isUpload" value=""/>
										</p>
									</td>
								</tr>-->
                                <!--<tr>-->
									<!--<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否免费：</th>-->
									<!--<td>-->
                                     <!--<span><input type="radio" name="free" value="1" checked=""><label>是</label></span>-->
									 <!--<span><input type="radio" name="free" value="2"><label>否</label></span>-->
									<!--</td>-->
								<!--</tr>-->
                                <!--<tr>-->
									<!--<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格：</th>-->
									<!--<td>-->
										<!--<input type="text" value="0" class="Iw290" name='price' id='price'/>&nbsp;<span id='priceTip'></span>-->
									<!--</td>-->
								<!--</tr>-->
								<!--<tr>-->
									<!--<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：</th>-->
									<!--<td>-->
										<!--<input type="text" value="0" class="Iw290" name='sort' id='sort'/>&nbsp;<span id='memberTip'></span>-->
									<!--</td>-->
								<!--</tr>-->

							
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
function uploadAccessory (obj)
{	

	var option={
		upload_id:'logo',
		title:'图片上传',
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
