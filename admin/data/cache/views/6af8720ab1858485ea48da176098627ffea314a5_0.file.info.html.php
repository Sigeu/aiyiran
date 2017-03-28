<?php
/* Smarty version 3.1.30, created on 2017-02-20 10:43:13
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\info.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58aa57c1ebcd19_30145451',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6af8720ab1858485ea48da176098627ffea314a5' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\info.html',
      1 => 1487558571,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58aa57c1ebcd19_30145451 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<!-- 时间日期插件 -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/laydate.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/need/laydate.css" type="text/css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/skins/molv/laydate.css" type="text/css">


<body>
	<div class="pubBox" >
		<div class="pubtabBox">
			<div class="TabBoxT">
				<dl class="navTab">     
                    <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" class="last">纪念馆列表</a></dd>
                    <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/info/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">逝者资料管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/biography/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">传记管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/mshow/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">隐私管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/eulogy/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">祭文悼词管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/epitaph/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">墓志铭管理</a></dt>
                    <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/steleauthor/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">立碑人信息</a></dt>
                </dl>
			</div>
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
/memorial/hall/info' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
                               <tr>
									<th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>头像：</th>
									<td>
										 <!--<p style="padding-bottom:5px;">
											<input onclick="uploadAccessory({'limit':'20','_switch':'accessory','self_id':'uploadButton','check_id':'isUpload'})" id="uploadButton" type="button" value="浏览上传" class="btn5" />
											<input type="hidden" id="isUpload" value=""/>
										</p>-->
                                        <div id="img-adta-0" style="display:none"></div>
                                        <img class="mt5" src="<?php echo $_smarty_tpl->tpl_vars['memorial']->value['userpic'];?>
" id="img0" onclick="uploadAccessory({'upload_id':'0','limit':'2','_switch':'ad_img','ady_upload':'1','img_data_id':'img-adta-0','img_id':'img0','hid_id':'hid0'})" width="110" height="86" style="cursor:pointer">
									</td>
								</tr>
								<tr>
									<th width="170px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>姓名：</th>
									<td>
										<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['person'];?>
" class="Iw290" name='person' id='person'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>

								<tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;性别：</th>
									<td>
									<select name="sex">
                                      <option value="0" <?php if ($_smarty_tpl->tpl_vars['info']->value['sex'] == 0) {?>selected<?php }?>>未定义</option>
                                      <option value="1" <?php if ($_smarty_tpl->tpl_vars['info']->value['sex'] == 1) {?>selected<?php }?>>男</option>
                                      <option value="2" <?php if ($_smarty_tpl->tpl_vars['info']->value['sex'] == 2) {?>selected<?php }?>>女</option>
                                    </select>
									</td>
								</tr>
                                <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;民族：</th>
									<td>
									<select name="nation">
                                     <option value="">自定义</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['nation']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['nation'] == 0) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['nation'];?>
" name='nationval'/>
									</td>
								</tr>
							    <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;籍贯：</th>
									<td>
									<select name="originp" id="originp" date-city="originc">
                                     <option value="">省份</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['area']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['originp'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <select name="originc" id="originc">
                                     <option value="">省份</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['originInfo']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['originc'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['origind'];?>
" name='origind'/>
									</td>
								</tr>
       	                         <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;职业：</th>
									<td>
										<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['careers'];?>
" class="Iw290" name='careers' id='careers'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>
                                 <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;与逝者关系：</th>
									<td>
									<select name="relationship">
                                     <option value="">请选择</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['person_type']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['relationship'] == $_smarty_tpl->tpl_vars['v']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
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
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;生辰：</th>
									<td>
									<select name="brith">
                                        <option value="1" <?php if ($_smarty_tpl->tpl_vars['info']->value['brith'] == 1) {?>selected<?php }?>>公元</option>
                                       <option value="2" <?php if ($_smarty_tpl->tpl_vars['info']->value['brith'] == 2) {?>selected<?php }?>>公元前</option>
                                    </select>
                                    <span class="time">
                                        <input id="data1" class="laydate-icon" name="brithdate" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['info']->value['brithdate'],'%Y-%m-%d');?>
" />
                                    </span>
									</td>
								</tr>

                                <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;忌日：</th>
									<td>
									<select name="died">
                                        <option value="1" <?php if ($_smarty_tpl->tpl_vars['info']->value['died'] == 1) {?>selected<?php }?>>公元</option>
                                       <option value="2" <?php if ($_smarty_tpl->tpl_vars['info']->value['died'] == 2) {?>selected<?php }?>>公元前</option>
                                    </select>
                                        <span class="time">
                                        <input id="data2" class="laydate-icon" name="dieddate" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['info']->value['dieddate'],'%Y-%m-%d');?>
" />
                                        </span>
									</td>
								</tr>
                                 <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出生地：</th>
									<td>
									<select name="brithp" id="brithp" date-city="brithd">
                                     <option value="">省份</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['area']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['brithp'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <select name="brithd" id="brithd">
                                     <option value="">市区</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['brithpInfo']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['brithd'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['brithc'];?>
" name='brithc'/>
									</td>
								</tr>
                                <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;安葬地：</th>
									<td>
									<select name="diedp" id="diedp" date-city="diedd">
                                     <option value="">省份</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['area']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['diedp'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <select name="diedd" id="diedd">
                                     <option value="">市区</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['diedpInfo']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['diedd'] == $_smarty_tpl->tpl_vars['v']->value['area_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['diedc'];?>
" name='diedc'/>
									</td>
								</tr>
                                <tr>
									<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;所葬陵园：</th>
									<td>
									<select name="cemetery">
                                     <option value="">请选择</option>
                                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['came']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['info']->value['cemetery'] == $_smarty_tpl->tpl_vars['v']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
                                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
									</td>
								</tr>
                                <tr><th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;内容描述：</th><td colspan="3"><textarea class="Iw450 Ih80" name="descript" id="descript"><?php echo $_smarty_tpl->tpl_vars['info']->value['descript'];?>
</textarea> &nbsp;&nbsp;</td></tr>
                                <!-- 纪念馆id -->
                                <input type="hidden" name="mid" value="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">
                                <!-- 资料id -->
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
>
laydate({
  elem: '#data1', 
  event: 'focus',
  format: 'YYYY-MM-DD', //日期格式
  min: '1000-01-01 00:00:00' //最小日期
});

laydate({
  elem: '#data2', 
  event: 'focus',
  format: 'YYYY-MM-DD', //日期格式
  min: '1000-01-01 00:00:00' //最小日期
});
laydate.skin('dahong'); //皮肤
<?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
