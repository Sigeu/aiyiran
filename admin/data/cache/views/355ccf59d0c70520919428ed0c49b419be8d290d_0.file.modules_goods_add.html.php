<?php
/* Smarty version 3.1.30, created on 2016-12-29 16:08:15
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\goods\modules_goods_add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5864c46fcb9f65_84814583',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '355ccf59d0c70520919428ed0c49b419be8d290d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\goods\\modules_goods_add.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_5864c46fcb9f65_84814583 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/iniEditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
$(function()
{
	//初始化配置
	$.formValidator.initConfig({formid:"formid",autotip:true,generalwordwide:true});
	$("#goodsname").formValidator(
	{
		onshow:"请输入1至100个字符",
		onfocus:"请输入1至100个字符",
		oncorrect:"输入正确"
	}).inputValidator(
	{
		min:1,
		max:100,
		onerror:"请输入1至100个字符"
	});

	$("#categoryid").formValidator(
	{
		onshow:"请选择栏目",
		onfocus:"请选择栏目",
		oncorrect:"选择正确"
	}).inputValidator(
	{
		min:1,
		onerror:"请选择栏目"
	});

	$("#sortid").formValidator(
	{
		onshow:"请选择分类",
		onfocus:"请选择分类",
		oncorrect:"选择正确"
	}).inputValidator(
	{
		min:0,
		onerror:"请选择分类"
	});
	
	$("#content").formValidator(
	{
		onshow:"请输入内容",
		onfocus:"请输入内容",
		oncorrect:"输入正确",
		onempty:'输入内容为空',
		empty:false
	}).inputValidator(
	{
		min:1,
		onerror:"请输入内容"
	});
	
	$("#marketprice").formValidator(
	{
		onshow:"请输入市场价",
		onfocus:"请输入市场价",
		oncorrect:"输入正确",
		onempty:'输入内容为空',
		empty:true
	}).inputValidator(
	{
		min:0,
		onerror:"请输入市场价"
	}).regexValidator({regexp:['price'],datatype:"enum",onerror:"输入有误"});

	$("#shopprice").formValidator(
	{
		onshow:"请输入优惠价",
		onfocus:"请输入优惠价",
		oncorrect:"输入正确",
		onempty:'输入内容为空',
		empty:true
	}).inputValidator(
	{
		min:0,
		onerror:"请输入优惠价"
	}).regexValidator({regexp:['price'],datatype:"enum",onerror:"输入有误"});

	$("#isUpload").formValidator(
	{
		tipid:'albumID',
		onshow:"请上传图片",
		onfocus:"请上传图片",
		oncorrect:"上传正确"
	}).functionValidator(
	{
		 fun:function(val)
		 {
			if ($('div[class*=dis-btn-]')/2 > 10)
			{
				return '只能上传10张图片';
			}
			return true;
		 }
	});

	$("#title").formValidator(
	{
		tipid:'title_tips',
		empty:true,
		onshow:" ",
		onfocus:"请输入0-62个字符"
	}).inputValidator(
	{
		min:0,
		max:62,
		onerror:"请输入0-62个字符",
		onerrormax:"最多输入62个字符"
	});
	$("#keywords").formValidator(
	{
		tipid:'keywords_tips',
		empty:true,
		onshow:' ',
		onfocus:'请输入0-200个字符,多个关键词之间用","隔开'
	}).inputValidator(
	{
		min:0,
		max:200,
		onerror:"请输入0-200个字符",
		onerrormax:"最多输入200个字符"
	});
	$("#brief").formValidator(
	{
		tipid:'brief_tips',
		empty:true,
		onshow:" ",
		onfocus:"请输入0-300个字符"
	}).inputValidator(
	{
		min:0,
		max:62,
		onerror:"请输入0-300个字符",
		onerrormax:"最多输入300个字符"
	});
});
<?php echo '</script'; ?>
>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
	  <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/add" id="formid" enctype="multipart/form-data"  >
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="javascript:;">基本项</a></dt>
            <dt><a href="javascript:;">关联商品</a></dt>
            <dt><a href="javascript:;">商品属性</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
			<!--  基本项  -->
			<div>
				<div class="pubTabel">
					<table class="tabelLR">
						<tr>
							<th width="145px"><font>*</font> 商品名称：</th>
							<td colspan="3"><input type="text" name="goodsname" id="goodsname" class="Iw290" value="" /></td>
						</tr>
						<tr>
							<th>&nbsp; 副标题：</th>
							<td colspan="3"><input type="text" name="subname" class="Iw290" value=""/></td>
						</tr>
						<tr>
							<th>&nbsp; 特殊属性：</th>
							<td colspan="3">
								<span><input type="checkbox" name="isbest"    value="1"/><label>精品</label></span>&nbsp;&nbsp;&nbsp;
								<span><input type="checkbox" name="isnew"     value="1"/><label>新品</label></span>&nbsp;&nbsp;&nbsp;
								<span><input type="checkbox" name="ishot"     value="1"/><label>热销</label></span>&nbsp;&nbsp;&nbsp;
								<span><input type="checkbox" name="isspecial" value="1"/><label>特卖</label></span>
							</td>
						</tr>
						<tr>
							<th><font>*</font> 商品栏目：</th>
							<td colspan="3">
								<select class="Iw290" style="width:302px;" name="categoryid" id="categoryid">
									<option value="">请选择栏目</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['l']->value['model'] != 2) {?>disabled='true' style="color:#747474"<?php } else { ?>style="color:#1C1C1C"<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value['catname'];?>
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
							<th><font>*</font> 商品分类：</th>
							<td colspan="3">
								<select class="Iw290" style="width:302px;" name="sortid" id="sortid">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['goods_sort']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['sortname'];?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
								&nbsp;
								<input type="button" class="btn5" value="添加分类" hidefocus="hide" onclick="javascript:location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodssort/add'">
							</td>
						</tr>
						<tr>
							<th>&nbsp; 商品品牌：</th>
							<td colspan="3">
								<select class="Iw290" style="width:302px;" name="brandid">
									<option value="">请选择商品品牌</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['goods_brand']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['brandid'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['brandname'];?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
								&nbsp;
								<input type="button" class="btn5" value="添加品牌" hidefocus="hide" onclick="javascript:location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goodsbrand/add'">
							</td>
						</tr>
						<tr>
							<th>&nbsp; 商品页标题：</th>
							<td colspan="3"><input type="text" value="" class="Iw290" name="title" id="title"/>
							&nbsp;&nbsp;<span id="title_tips"></span><br/><span>注：页面标题为内容页页面title，为空时根据系统默认设置实现</span>
							</td>
						</tr>
						<tr>
							<th>&nbsp; 关键词：</th>
							<td colspan="3"><input type="text" value="" class="Iw290" name="keywords"  id="keywords"/>
                            &nbsp;&nbsp;<span id="keywords_tips"></span><br/><span>注：关键词为内容页页面keywords，为空时根据系统默认设置实现</span>
							</td>
						</tr>
						<tr>
							<th valign="top">&nbsp; 内容描述：</th>
							<td colspan="3"><textarea class="Iw450 Ih80" name="brief"  id="brief"></textarea>
                            &nbsp;&nbsp;<span id="brief_tips"></span><br/><span>注：内容描述为内容页页面description，为空时根据系统默认设置实现</span></td>
						</tr>
						<tr>
							<th valign="top"><font>*</font>  内容：</th>
							<td colspan="3"><textarea id='content' name='content'></textarea></td>
						</tr>

						<tr>
							<th width="12%">&nbsp; 市场价：</th>
							<td  width="40%"><input type="text" value="" class="Iw150" name="marketprice" id="marketprice"></td>
							<td  width="10%">优惠价：</td>
							<td  width="38%"><input type="text" value="" class="Iw150" name="shopprice" id="shopprice"/></td>
						</tr>
						<tr>
							<th>&nbsp; 计量单位：</th>
							<td><input type="text" value="" class="Iw150" name="unit" id="unit" ></td>
							<td>上架时间：</td>
							<td>
								<span class="time">
									<input type="text" value="" readonly class="Iw150" onfocus="WdatePicker_start()" id='startTime' name='publishtime'>
								</span>
								<?php echo '<script'; ?>
>
									function WdatePicker_start()
									{
										var pos = $("#startTime").offset();
										var mytop=pos.top+28;
										WdatePicker({position:{top:mytop,left:pos.left},dateFmt:'yyyy-MM-dd HH:mm:ss'});
									}
								<?php echo '</script'; ?>
>
							</td>
						</tr>
						<tr>
							<th valign="top">&nbsp; 商品图片：</th>
							<td colspan="3">
								<input type="button" hidefocus="hide" value="添加" class="btn5" onclick="uploadAccessory({'limit':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
','_switch':'goodsadd','self_id':'uploadButton','dis_place':'multi-upload'})" id="uploadButton" />
							</td>
						</tr>

						<tr>
							<th>&nbsp;  发布选项：</th>
							<td colspan="3">
								<span>
								<input type="radio" name="publishopt" value="1"/>
								<label>生成HTML</label>
								</span>&nbsp;&nbsp;<span>
								<input type="radio" checked="checked" name="publishopt" value="2"/>
								<label>仅动态浏览</label>
								</span><br /><br />
								注：如需做前台权限控制，请勿选择"生成HTML",否则权限无效!
							</td>
						</tr>
						<tr>
							<th>阅读权限：</th>
							<td colspan="3">
								<table>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['member_group']->value, 'ml');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ml']->value) {
?>
									<tr>
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ml']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
										<td>
											<?php if ($_smarty_tpl->tpl_vars['l']->value) {?>
											<label style="cursor:pointer"><input type="checkbox" name="alowpower[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" /> <?php echo $_smarty_tpl->tpl_vars['l']->value['groupname'];?>
</label>
											<?php }?>
										</td>
										<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

									</tr>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</table>	
								<br />默认都不选，所有会员组均有阅读权限；若选择，则只允许选中的会员组有阅读权限。
							</td>
						</tr>

						<tr>
							<th>&nbsp; 评论选项：</th>
							<td>
								<span><input type="radio" name="iscomment" checked="checked" value="1"/><label>允许评论</label></span>&nbsp;&nbsp;
								<span><input type="radio"  name="iscomment" value="2"/><label>禁止评论</label></span>
							</td>
							<td>选择模板：</td>
							<td>
								<select class="Iw290" style="width:162px;" id="template" name="goodstpl">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['content_tpl']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value;?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<!--  关联商品  -->
			<div style="display:none;">
				<div class="pubTabel">
					<div class="topboxX">
						<input type="text" value="" id="ajax-keywords" class="Iw290 text-tips" tips="输入商品关键字"/>&nbsp;
						<select class="Iw290" style="width:150px;" id="ajax-sort">
							<option value="">所有分类</option>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['goods_sort']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['sortid'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['sortname'];?>
</option>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						</select>
						&nbsp;
						<select class="Iw290" style="width:150px;" id="ajax-brand">
							<option value="">所有品牌</option>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['goods_brand']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['brandid'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['brandname'];?>
</option>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						</select>
						&nbsp;
						<input type="button" class="btn5" value="搜 索" id="searchGoodsList" hidefocus="hide">
					</div>

					<div class="boxP">
						<div class="linebkX"><select multiple="multiple" style="width:296px;height:210px;" id="goodslist"></select></div>
						<div class="linebkX cenFun"> 
							<span><input type="radio" checked class="width12" name="relation" value="1"/></span>
							<label>单向关联</label>
							<span><input type="radio"  class="width12" name="relation" value="2"/></span>
							<label>双向关联</label>
							<input type="button" hidefocus="hide" value="全部选中>>" class="btn5" id="selectAll">
							<input type="button" hidefocus="hide" value="<<全部删除" class="btn5" id="deleteAll">
							<input type="button" hidefocus="hide" value="选 中 >" class="btn5" id="select">
							<input type="button" hidefocus="hide" value="< 删 除" class="btn5" id="delete">
						</div>
						<div class="cenFunT"><select multiple="multiple" style="width:296px;height:210px;" id="selectlist" name="relationid[]"></select></div>
					</div>
				</div>
			</div>

			<!--  商品属性  -->
			<div style="display:none;">
				<div class="pubTabel">
					<table class="tabelLR" id="tabX">
						<tr>
							<th width="145px">&nbsp; 商品属性：</th>
							<td>
								<select class="Iw290" style="width:302px;" id="goodsType" name="typeid">
									<option value="">请选择</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['goods_type']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['typeid'];?>
"><?php echo $_smarty_tpl->tpl_vars['l']->value['typename'];?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
								<span class="warnBlue">请选择商品的所属类型，进而完善此商品的属性</span>
							</td>
						</tr>
					</table>
					<div id="goodsAttr"></div>
				</div>
			</div>
		  
        </div>
		<div class="pubTabelBot">
			<input type="submit" value="确定" onclick="javascript:$('#selectlist option').attr('selected',true)" class="btn1">
			<input type="button" value="取消"  class="btn2"  onclick="javascript:history.go(-1);">
		</div>
		</form>
      </div>
    </div>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
$(function()
{
	//属性表单
	var _html = new Array();
	
	$('#goodsType').bind('change',function(){
		var obj = $(this);
		var type_id = obj.val();
		if (type_id == '')
		{
			$('#goodsAttr').empty();
			return false;
		}
		if(_html[type_id] != undefined)
		{
			$('#goodsAttr').html(_html[type_id]);//直接使用js缓存表单
			return;
		}
		
		$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/getattr',{'typeid':type_id},function(d)
		{
			$('#goodsAttr').html(d);
			$.each($('#attr-group-'+type_id).find('textarea[isEditor="true"]'),function(i,n){
				init($(n).attr('id'), 'fail');//初始化编辑器	
			});
			_html[type_id] = $('#goodsAttr').html();//存储JS缓存
		});
	});

	//关联商品搜索
	$('#searchGoodsList').bind('click',function(){
		$('#selectlist').empty();
		var tips = $('#ajax-keywords').attr('tips');
		var keywords = $('#ajax-keywords').val();
		keywords = (keywords==tips) ? '' : keywords;
		var sort = $('#ajax-sort').val();
		var brand = $('#ajax-brand').val();
		$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/ajaxlist',{'keywords':keywords,'sort':sort,'brand':brand},function(d){
			var str = Array();
			if(d.length)
			{
				$.each(d,function(i,n){
					str.push('<option value="'+n.goodsid+'">'+n.goodsname+'</option>');
				});
			}
			$('#goodslist').html(str.join(''));
		},'json');
	});

	//选中删除
	var gl = $('#goodslist');
	var sl = $('#selectlist');
	$('#selectAll').bind('click',function(){
		if(gl.html() == '') return;
		sl.append(gl.html());
		gl.empty();
	});

	$('#deleteAll').bind('click',function(){
	if(sl.html() == '') return;
		gl.append(sl.html());
		sl.empty();
	});

	$('#select').bind('click',function(){
		var op = gl.find('option:selected');
		if(op.length)
		{
			var str = new Array();
			$.each(op,function(i,n){
				str.push('<option value="'+$(n).val()+'">'+$(n).text()+'</option>');
			});
			sl.append(str.join(''));
			op.remove();
		}
	});

	$('#delete').bind('click',function(){
		var op = sl.find('option:selected');
		if(op.length)
		{
			var str = new Array();
			$.each(op,function(i,n){
				str.push('<option value="'+$(n).val()+'">'+$(n).text()+'</option>');
			});
			gl.append(str.join(''));
			op.remove();
		}
	});

	
	//选中栏目
	var cid = "<?php echo $_smarty_tpl->tpl_vars['categroyid']->value;?>
";
	jQuery('#categoryid option[value="'+cid+'"]').attr('selected','selected');
});

document.ready = init('content', 'fail');

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
		title:'商品图片上传',
		return_id:'accessory',
		callFunName:'accessoryUpload',
		setting:'<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
',
		param:obj
	};
	MainOneUpload(option);//调用统一上传方法
}

$('#categoryid').change(function () {
    var id = $('#categoryid').val();
    if (id != '') {
        $.ajax({
              type:"POST",
              url:"<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/content/ajaxGetTemplate",
              data:"id="+id,
              async:false,
              success:function(data){
                  if (data) {
                      //data = JSON.parse(data);
                      $('#template').val(data);
                  }
              }
         });
    }
});

$('#categoryid').ready(function () {
    var id = $('#categoryid').val();
    if (id != '') {
        $.ajax({
              type:"POST",
              url:"<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/content/ajaxGetTemplate",
              data:"id="+id,
              async:false,
              success:function(data){
                  if (data) {
                      //data = JSON.parse(data);
                      $('#template').val(data);
                  }
              }
         });
    }
});
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
