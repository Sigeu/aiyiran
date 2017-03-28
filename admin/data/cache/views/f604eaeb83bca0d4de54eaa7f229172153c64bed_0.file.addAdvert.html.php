<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:33:22
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\addAdvert.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2c0d2548372_58976871',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f604eaeb83bca0d4de54eaa7f229172153c64bed' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\addAdvert.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a2c0d2548372_58976871 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
   $(function(){
	   
	   $(".cancel").click(function(){
		   var url ="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
"+"<?php echo $_smarty_tpl->tpl_vars['backUrl']->value;?>
";
		   window.location.href =url;
	   })
   })
<?php echo '</script'; ?>
>
<body>
    <div class="pubBox" style='height:1800px;'>
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/advert/adpos/<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
" class="last">广告列表</a></dd>
            <dt class="on"><a href="">添加广告</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
		<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/addAdvert" enctype="multipart/form-data" id='myform'>
          <div>
            <div class="pubTabel">
              <table class="tabelLR" >
                <tr>
                  <th width="145px"><font>*</font> 广告标题：</th>
                  <td>
                  <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['adpos']->value;?>
' name='adpos'></input>
                  <input type="text" value="" class="Iw290" name='adtitle' id='adtitle' />
                  </td>
                </tr>
                <tr>
                  <th>&nbsp; 广告类型：</th>
                  <td><select disabled="" class="Iw290" style="width:302px;">
                        <option value="" ><?php echo $_smarty_tpl->tpl_vars['infor']->value['adname'];?>
</option>
                    </select></td>
                </tr>
                <tr>
                  <th>&nbsp; 投放栏目：</th>
                  <td><select disabled="" class="Iw290" style="width:302px;">
                        <option value=""><?php echo $_smarty_tpl->tpl_vars['infor']->value['clumnname'];?>
</option>
                    </select></td>
                </tr>
                <tr>
                  <th>&nbsp; 广告内容类型：</th>
                  <td><span>
                    <input type="radio" <?php if (in_array('1',$_smarty_tpl->tpl_vars['type']->value)) {?>checked<?php }?> disabled/>
                    <label>图片</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" <?php if (in_array('2',$_smarty_tpl->tpl_vars['type']->value)) {?>checked<?php }?> disabled/>
                    <label>flash</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" <?php if (in_array('3',$_smarty_tpl->tpl_vars['type']->value)) {?>checked<?php }?> disabled/>
                    <label>文字</label>
                    </span></td>
                </tr>
                <tr>
                  <th>&nbsp; 时间限制：</th>
                  <td><span>
                    <input type="radio"  value='1' id='time' name='timetype' <?php if ($_smarty_tpl->tpl_vars['curinfor']->value['timetype'] != 2) {?>checked<?php }?>/>
                    <label>永不限制</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio"  value='2' name='timetype' <?php if ($_smarty_tpl->tpl_vars['curinfor']->value['timetype'] == 2) {?>checked<?php }?>/>
                    <label>在设定时间内有效</label>
                    </span></td>
                </tr>
                <tr>
                  <th>&nbsp; 广告投放时间</th>
                  <td>从&nbsp;<span class="time">
                  <input type="text" value="" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id='startTime' name='starttime' readonly class="Iw150">
                  </span>&nbsp;到&nbsp;
                  <span class="time"><input type="text" value="" name='endtime' readonly onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id='endTime' class="Iw150">
                  </span></td>
                </tr>
              </table>
            </div>

			<div class="pubTabel">
				<div class="theme"><?php if (in_array('3',$_smarty_tpl->tpl_vars['type']->value)) {?>文字<?php } else { ?>图片<?php }?>设置</div> 
				<table class="tableX">
					<?php
$__section_foo_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_foo']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo'] : false;
$__section_foo_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['infor']->value['adnum']) ? count($_loop) : max(0, (int) $_loop));
$__section_foo_0_start = min(0, $__section_foo_0_loop);
$__section_foo_0_total = min(($__section_foo_0_loop - $__section_foo_0_start), $__section_foo_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if ($__section_foo_0_total != 0) {
for ($__section_foo_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = $__section_foo_0_start; $__section_foo_0_iteration <= $__section_foo_0_total; $__section_foo_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
					<tr>
						<th width="145">链接地址：</th>
						<td><input type="text" value="http://" class="Iw290" id='link' name='adimg[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
][link]'/></td>
					</tr>
					<tr class="border">
						<th valign="top">文字提示：</th>
						<td>
							<input name='adimg[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
][font]' id='font' type="text" value="" class="Iw290 font" />
							<input name="adimg[<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
][img]" id="hid<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" value="" type="hidden" /><br />
							<div id="img-adta-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" style="display:none"></div>
							<?php if ($_smarty_tpl->tpl_vars['infor']->value['typefilename'] != 'word') {?>
							<img class="mt5" src="/admin/template/images/img_downl.png" id="img<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" onclick="uploadAccessory({'upload_id':'<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
','limit':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
','img_id':'img<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
','hid_id':'hid<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
'})" width='110' height='86' style="cursor:pointer"/>
							<?php }?>
						</td>
					</tr>
					<?php
}
}
if ($__section_foo_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = $__section_foo_0_saved;
}
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
	$("#adtitle").formValidator({empty:false,onshow:"请输入1-50个字符",onfocus:"请输入1-50个字符",oncorrect:"输入正确"})
	.inputValidator({min:1,max:50,onerror:"请输入1-50个字符"});

	 $(".cancel").click(function(){
		   var url ="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
"+"<?php echo $_smarty_tpl->tpl_vars['backUrl']->value;?>
";
		   window.location.href =url;
	 })
});
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
