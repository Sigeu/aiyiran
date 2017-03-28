<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:33:59
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\editor_advert.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2c0f7a1f8b4_35876980',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '36f1da0aa44d6ab723cbdb947e910b0ab554a497' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\editor_advert.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a2c0f7a1f8b4_35876980 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<body>
    <div class="pubBox" style='height:1800px;'>
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">修改广告</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
		<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/editorAdvert" enctype="multipart/form-data" id='myform'>
          <div>
			<!--  基本信息  -->
			<div class="pubTabel">
				<table class="tabelLR">
					<tr>
						<th width="145px"><font>*</font> 广告标题：</th>
						<td>
							<input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' name='id'></input>
							<input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
' name='adpos'></input>
							<input type="hidden" name="rubbish" value="<?php echo $_smarty_tpl->tpl_vars['rubbish']->value;?>
" />
							<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['curinfor']->value['adtitle'];?>
" class="Iw290" name='adtitle' id='adtitle' />
						</td>
					</tr>

					<tr>
						<th>&nbsp; 广告类型：</th>
						<td><select disabled="" class="Iw290" style="width:302px;"><option value="" ><?php echo $_smarty_tpl->tpl_vars['infor']->value['adname'];?>
</option></select></td>
					</tr>

					<tr>
						<th>&nbsp; 投放栏目：</th>
						<td><select disabled="" class="Iw290" style="width:302px;"><option value=""><?php echo $_smarty_tpl->tpl_vars['infor']->value['clumnname'];?>
</option></select></td>
					</tr>

					<tr>
						<th>&nbsp; 广告内容类型：</th>
						<td>
							<span><input type="radio" <?php if (in_array('1',$_smarty_tpl->tpl_vars['type']->value)) {?>checked<?php }?> disabled/><label>图片</label></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span><input type="radio" <?php if (in_array('2',$_smarty_tpl->tpl_vars['type']->value)) {?>checked<?php }?> disabled/><label>flash</label></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span><input type="radio" <?php if (in_array('3',$_smarty_tpl->tpl_vars['type']->value)) {?>checked<?php }?> disabled/><label>文字</label></span>
						</td>
					</tr>

					<tr>
						<th>&nbsp; 时间限制：</th>
						<td>
							<span>
								<input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" name='page'></input>
								<input type="radio"  value='1' id='time' name='timetype' <?php if ($_smarty_tpl->tpl_vars['curinfor']->value['timetype'] != 2) {?>checked<?php }?>/>
								<label>永不限制</label>
							</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<span>
								<input type="radio"  value='2' name='timetype' <?php if ($_smarty_tpl->tpl_vars['curinfor']->value['timetype'] == 2) {?>checked<?php }?>/>
								<label>在设定时间内有效</label>
							</span>
						</td>
					</tr>
                  <th>&nbsp; 广告投放时间</th>
                  <td>从&nbsp;<span class="time">
                  <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['curinfor']->value['timetype'] == 2) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['curinfor']->value['starttime'],'%Y-%m-%d %H:%M:%S');
}?>" readonly class="Iw150" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id='startTime' name='starttime' readonly class="Iw150">
                  </span>&nbsp;到&nbsp;
                  <span class="time"><input type="text" value="<?php if ($_smarty_tpl->tpl_vars['curinfor']->value['timetype'] == 2) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['curinfor']->value['endtime'],'%Y-%m-%d %H:%M:%S');
}?>" name='endtime' readonly onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id='endTime' class="Iw150">
                  </span></td>
                </tr>
				</table>
			</div>

			<!--  图片集列表  -->
			<div class="pubTabel">
				<div class="theme"><?php if (in_array('3',$_smarty_tpl->tpl_vars['type']->value)) {?>文字<?php } else { ?>图片<?php }?>设置</div> 
				<table class="tableX">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['curinfor']->value['adimg'], 'item', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
					<tr>
						<th width="145">链接地址：</td>
						<td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" class="Iw290" id='link' name="adimg[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
][link]"/></td>
					</tr>
					<tr class="border">
						<th valign="top">文字提示：</th>
						<td>
							<input name="adimg[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
][font]" id='font' type="text" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['font'];?>
" class="Iw290 font" /><br />
							<input name="adimg[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
][img]" id="hid<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" type="hidden"  value=""/>
							<input name="adimg[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
][old_img]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['old_img'];?>
" type="hidden" />
							<div id="img-adta-<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" style="display:none"></div>
							<?php if ($_smarty_tpl->tpl_vars['infor']->value['typefilename'] != 'word') {?>
							<img src="<?php if ($_smarty_tpl->tpl_vars['item']->value['img']['path'] != '' && $_smarty_tpl->tpl_vars['item']->value['img']['extension'] != 'swf') {
echo $_smarty_tpl->tpl_vars['uploadpath']->value;?>
/advert/<?php echo $_smarty_tpl->tpl_vars['item']->value['img']['path'];
} elseif ($_smarty_tpl->tpl_vars['item']->value['img']['extension'] == 'swf') {?>/admin/template/images/default/np_Xsmall.jpg<?php } else { ?>/admin/template/images/img_downl.png<?php }?>" id="img<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" onclick="uploadAccessory({'upload_id':'<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
','limit':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
','img_id':'img<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
','hid_id':'hid<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
'})" width='110' height='86' class="mt5" style="cursor:pointer"/>                   
							<?php }?>
						</td>
					</tr>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

				</table>
			</div>

			<div class="pubTabelBot">
				<input type="submit" hidefocus="hide" value="确定" class="btn1">
				<input type="button" hidefocus="hide" value="取消" class="btn2 cancel">
			</div>
          </div>
		  </form>
        </div>
      </div>
    </div>
<?php echo '<script'; ?>
 type="text/javascript">
function uploadAccessory (obj)
{
	var option=
	{
		upload_id:'accessory_upload'+obj.upload_id,
		title:'广告图片上传',
		return_id:'accessory',
		callFunName:'accessoryUpload',
		setting:'<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
',
		param:obj
	};
	MainOneUpload(option);//调用统一上传方法
}


$(function()
{
	$.formValidator.initConfig({formid:"myform",autotip:true,generalwordwide:true});
	$("#adtitle").formValidator({empty:false,onshow:"请填写广告位名称",onfocus:"请填写广告位名称",oncorrect:"输入正确"})
	.inputValidator({min:1,max:50,onerror:"请填写1-50个字符"}).defaultPassed();
    
	$(".cancel").click(function(){
		
		window.location.href= "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
"+"/modules/admanage/advert/adpos/<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
";
	})
});
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
