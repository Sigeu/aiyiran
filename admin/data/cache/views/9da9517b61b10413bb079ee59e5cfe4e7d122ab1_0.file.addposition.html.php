<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:25:13
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\addposition.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2bee98a09f1_97692744',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9da9517b61b10413bb079ee59e5cfe4e7d122ab1' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\addposition.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a2bee98a09f1_97692744 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<style type='text/css'>
.dis{display:none}
</style>
<?php echo '<script'; ?>
>
$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:false,generalwordwide:true});
	//发送邮件用户名称验证
	$("#adname").formValidator({empty:false,onshow:"请输入1-100个字符",onfocus:"请输入1-100个字符",oncorrect:"输入正确"})
	.inputValidator({min:1,max:100,onerror:"请输入1-100个字符"});
	$("#adtypeid").formValidator({onshow:"请选择广告效果",onfocus:"请选择广告效果",oncorrect:"选择正确"}).inputValidator({min:1,onerror: "请选择广告效果"});
	$("#fontsize").formValidator({empty:true,onshow:"请输入广告位显示字数,由数字组成",onfocus:"请输入广告位显示字数,由数字组成",oncorrect:"输入正确"})
	.regexValidator({regexp:"^\\d+$",onerror:"请输入广告位显示字数,由数字组成"});
	$(".position").formValidator({onshow:"请输入广告位上边距,左边距",tipid:"positionTip",onfocus:"请输入上左边距",oncorrect:"输入正确"})
	.functionValidator({
	    fun:function(){
	    	var reg =  /^\d*$/;
	    	var up = $("#up").val();
	    	var left = $("#left").val();
			if(!reg.test(up)  || !reg.test(left)){
				return "请输入正数";
			}else{
				return true;
			}
		}
	});
	
	$('.size').formValidator({empty:false,onshow:"请输入广告位宽度,高度",tipid:"sizeTip",onfocus:"请输入宽高",oncorrect:"输入正确"})
	.functionValidator({
	    fun:function(){
	    	var reg =  /^\d*$/;
	    	var width = $("#width").val();
	    	var height = $("#size").val();

			if(!reg.test(width)|| !reg.test(height)){
				return "请输入正数";
			}else{
				return true;
			}
		}
	});
	
	$(".size").focus(function(){
		if($(this).val() =='宽度' || $(this).val()=="高度"){
			$(this).val('');
		}
	});
	$(".size").blur(function(){	
		if($(this).val() =="宽度" || $(this).val()=="高度" || $(this).val()==""){
			var val = $(this).attr('reg');
			$(this).val(val);
		}
	});
	$(".position").focus(function(){
		if($(this).val() =='上边距' || $(this).val()=="左边距"){
			$(this).val('');
		}
	});
	$(".position").blur(function(){	
		if($(this).val() =="上边距" || $(this).val()=="左边距" || $(this).val()==""){
			var val = $(this).attr('reg');
			$(this).val(val);
		}
	});
	
	$("#adtypeid").change(function(){
		var name = $("#adtypeid option:selected").attr('reg');
		$('.tem').removeClass('dis');
		$("#trsize").removeClass('dis');
		var adsize = $("#"+name).val();
		var adpos = $("#"+name).attr('reg');
		
		if($("#fontsize").val()=="" && name!="word")
		{
			   $("#fontsize").val('0');
		}
		//对联广告和文字广告时对边距值的控制
		if(name == 'couplet' || name=='word' ){
			$("#up").val("上边距");
			$("#left").val("左边距");
		}else{
			$("#up").val("0");
			$("#left").val("0");
		}
		//背投广告时对宽高的控制
		if(name == 'back'){
			$("#width").val("0");
			$("#size").val("0");
		}else{
			$("#width").val("宽度");
			$("#size").val("高度");
		}

		if(name == 'couplet')
		{
			$("#pos1").addClass('dis');
			$("#pos2").attr('class','');
			$("#fontnum").addClass('dis');
		}else if(name == 'back')
		{
			$(".tem").addClass('dis');
			
		}else if(name == 'turnup')
		{
			$("#pos2").addClass('dis');
			$("#fontnum").addClass('dis');
			
		}else if(name == 'adwindow')
		{
			$("#pos2").addClass('dis');
			$("#fontnum").addClass('dis');
			
		}else if(name == 'word')
		{
			$("#pos2").addClass('dis');
			$("#fontnum").addClass('dis');
			var obj = $("#fontnum").find("#fontsize").siblings("span");
			obj.attr('id',"fontsizeTip");
			obj.addClass('onShow');
			obj.html('请输入广告位显示字数');
		}else{
			$(".tem").addClass('dis');
		}
		if(adpos ==2){//广告类型不需要设置位置
			
        	$("#pos1").addClass("dis");
        	$("#pos2").addClass("dis");
        	$("#up").val('0');
        	$("#left").val('0');
        	
        }else if(adpos==1){
        	
        	$("#pos1").removeClass("dis");
        	$("#pos2").removeClass("dis");
        	$("#up").val('上边距');
        	$("#left").val('左边距');
        }
		if(adsize == 2){//广告类型不需要设置尺寸
			
        	$("#trsize").addClass("dis");
        	$("#width").val('0');
        	$("#size").val('0');
        }else if(adsize==1){
        	
        	$("#trsize").removeClass("dis");
        	$("#width").val('宽度');
        	$("#size").val('高度');
        }
		if(name=='adwindow' || name=='turnup'){
			$("#pos2").addClass('dis');
			$("#up").val('0');
        	$("#left").val('0');
		}else{
			$("#pos1").addClass('dis');
		}
		
		if($("#"+name).attr('atr') == 2){
			$("#fontsize").val('0');
			$("#fontnum").addClass('dis');
			
		}else if($("#"+name).attr('atr') == 1){
			$("#fontsize").val('0');
			$("#fontnum").removeClass('dis');
		}
	})
	$(".cancel").click(function(){
		window.location.href = "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/adPosition";
	})
	
})
<?php echo '</script'; ?>
>
<body>
    <div class="pubBox" style='height:550px;'>
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/adposition" class="last">广告位列表</a></dd>
            <dt class="on"><a href="">添加广告位</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
             <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/addposition" id='myform' method='post'>
              <table class="tabelLR">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['effect']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                   <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['item']->value['adsize'];?>
' reg='<?php echo $_smarty_tpl->tpl_vars['item']->value['adposition'];?>
' atr="<?php echo $_smarty_tpl->tpl_vars['item']->value['wordnum'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['item']->value['typefilename'];?>
"></input>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <tr>
                  <th width="145px"><font>*</font> 广告位名称：</th>
                  <td>
                      <input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['search']->value['category'];?>
" name='category' ></input>
                      <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
' name='keyword'></input>
                      <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['search']->value['page'];?>
' name='page'></input>
                      <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['adname'];?>
" name='adname' id="adname" class="Iw290"/>
                      <span id='adnameTip'></span>
                  </td>
                </tr>
                <tr>
                  <th><font>*</font> 广告效果：</th>
                  <td><select class="Iw290" style="width:162px;" name='adtypeid' id='adtypeid'>
                      <option value="0">请选择广告位类型</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['effect']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['item']->value['typename'];?>
" reg='<?php echo $_smarty_tpl->tpl_vars['item']->value['typefilename'];?>
' <?php if ($_smarty_tpl->tpl_vars['item']->value['id'] == $_smarty_tpl->tpl_vars['infor']->value['adtypeid']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['typename'];?>
</option>
                      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                      </select>
                      <span id='adtypeidTip'></span>
                    </td>
                </tr>
                <tr>
                  <th><font>*</font> 投放栏目：</th>
                  <td><select class="Iw290" style="width:162px;" name='useclumn'>
                      <option value="0">不限栏目</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value, 'clum');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['clum']->value) {
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['clum']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['clum']->value['catname'];?>
" <?php if ($_smarty_tpl->tpl_vars['clum']->value['id'] == $_smarty_tpl->tpl_vars['infor']->value['useclumn']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['clum']->value['catname'];?>
</option>
                      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select></td>
                </tr>
                <tr id='trsize' <?php if ($_smarty_tpl->tpl_vars['effect']->value['adsize'] == 2) {?>class='dis'<?php }?>>
                  <th><font>*</font> 广告位尺寸：</th>
                  <td><input type="text" value="<?php if ($_smarty_tpl->tpl_vars['infor']->value['width'] != '') {
echo $_smarty_tpl->tpl_vars['infor']->value['width'];
} else { ?>宽度<?php }?>" id='width' class="Iw45 size" name='width' reg='宽度'>&nbsp;px&nbsp;&nbsp;
                  <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['infor']->value['height'] != '') {
echo $_smarty_tpl->tpl_vars['infor']->value['height'];
} else { ?>高度<?php }?>" reg='高度' class="Iw45 size" name='height' id='size'>&nbsp;px
                  <span id='sizeTip'></span>
                  </td>
                </tr>
                <tr id='pos1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adtypeid'] == 7 || $_smarty_tpl->tpl_vars['infor']->value['adtypeid'] == 9 || $_smarty_tpl->tpl_vars['effect']->value['adposition'] == 1) {?>class='tem'<?php } else { ?> class='tem dis'<?php }?>>
                  <th><font>*</font> 广告位位置：</th>
                  <td>
                  <input type="radio" value="1"  class="Iw45" name='pos' <?php if ($_smarty_tpl->tpl_vars['infor']->value['pos'] != 2) {?>checked<?php }?> >左上角
                  <input type="radio" value="2"  class="Iw45" name='pos' <?php if ($_smarty_tpl->tpl_vars['infor']->value['pos'] == 2) {?>checked<?php }?>>右上角
                  </td>
                </tr>
                
                <tr id='pos2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adtypeid'] == 1 || $_smarty_tpl->tpl_vars['infor']->value['adtypeid'] == 4 || $_smarty_tpl->tpl_vars['effect']->value['adposition'] == 1) {?>class='tem'<?php } else { ?> class='tem dis'<?php }?>>
                  <th><font>*</font> 广告位位置：</th>
                  <td><input type="text" value="<?php if ($_smarty_tpl->tpl_vars['infor']->value['up']) {
echo $_smarty_tpl->tpl_vars['infor']->value['up'];
} else { ?>上边距<?php }?>" reg="上边距"  class="Iw45 position" name='up' id='up'>&nbsp;px&nbsp;&nbsp;
                  <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['infor']->value['left']) {
echo $_smarty_tpl->tpl_vars['infor']->value['left'];
} else { ?>左边距<?php }?>" reg="左边距"  class="Iw45 position" name='left' id='left'>&nbsp;px
                  <span id='positionTip'></span>
                  </td>
                </tr>
                 <tr  id='fontnum' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adtypeid'] == 4 || $_smarty_tpl->tpl_vars['effect']->value['wordnum'] == 1) {?>class='tem'<?php } else { ?> class='tem dis'<?php }?>>
                  <th width="145px"><font>*</font>每条广告显示字数：</th>
                  <td>
                      <input type="text" value="0" name='fontnum' id='fontsize' class="Iw290"/>
                      <span id='fontsizeTip'></span>
                  </td>
                </tr>
                <tr>
                  <th>&nbsp; 广告位描述：</th>
                  <td><textarea class="Iw450 Ih80" name='addescript'></textarea></td>
                </tr>
              </table>
            </div>
             <div class="pubTabelBot">
                <input type="submit" hidefocus="hide" value="确定" class="btn1"> 
                <input type="button" hidefocus="hide" value="取消" class="btn2 cancel">
              </div>
           </form>
          </div>
        </div>
      </div>
    </div>
    </body>
    </html><?php }
}
