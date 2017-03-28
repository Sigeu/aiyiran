<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:30:14
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\editposition.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2c01648ecc1_85212097',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9a1b78e2bbf3c645adcc3126846ddd23e0fccd63' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\editposition.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a2c01648ecc1_85212097 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>
$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,generalwordwide:true,onerror:function(){}});
	//发送邮件用户名称验证
	$("#adname").formValidator({empty:false,onshow:"请输入1-100个字符",onfocus:"请输入1-100个字符",oncorrect:"输入正确"})
	.inputValidator({min:1,max:100,onerror:"请输入1-100个字符"}).defaultPassed();
	$("#fontsize").formValidator({empty:false,onshow:"请输入广告位显示字数,由数字组成",onfocus:"请输入广告位显示字数,由数字组成",oncorrect:"输入正确"})
	.inputValidator({min:1,max:50,onerror:"请输入广告位显示字数,由数字组成"})
	.regexValidator({regexp:"^\\d+$",onerror:"请输入数字"}).defaultPassed();
	$(".position").formValidator({empty:false,onShow:"请输入广告位上边距,左边距",tipid:"positionTip",onfocus:"请输入上左边距",oncorrect:"输入正确",onempty:"请输入广告位上边距,左边距"})
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
	})
	.inputValidator({min:1,max:4,onerror:"请输入1-4位数字"}).defaultPassed();
	
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
	})
	.inputValidator({min:1,max:4,onerror:"请输入1-4位数字"}).defaultPassed();
	
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
	$(".cancle").click(function(){
		window.location.href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/adPosition/category/<?php echo $_smarty_tpl->tpl_vars['search']->value['category'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['search']->value['page'];?>
";
	})
})
<?php echo '</script'; ?>
>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">修改广告位</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
             <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/editPosition" id='myform' method='post'>
              <table class="tabelLR">
                <tr>
                  <th width="145px"><font>*</font> 广告位名称：</th>
                  <td>
                      <input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['search']->value['category'];?>
" name='category' ></input>
                      <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
' name='keyword'></input>
                      <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['search']->value['page'];?>
' name='page'></input>
                      <input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['id'];?>
" name='id' name='id'></input>
                      <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['adname'];?>
" name='adname' id="adname" class="Iw290"/>
                      <span id='adnameTip'></span>
                  </td>
                </tr>
                <tr>
                  <th>&nbsp;&nbsp;&nbsp; 广告效果：</th>
                  <td><select class="Iw290" style="width:162px;" name='adtypeid' id='adtypeid' disabled>
                      <option value="0"><?php echo $_smarty_tpl->tpl_vars['effect']->value['typename'];?>
</option>
                      </select>
                    </td>
                </tr>
                <tr>
                  <th>&nbsp;&nbsp;&nbsp; 投放栏目：</th>
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
}?>" id='width' class="Iw45 size" name='width' reg='宽度'>&nbsp;px&nbsp;&nbsp;
                  <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['infor']->value['height'] != '') {
echo $_smarty_tpl->tpl_vars['infor']->value['height'];
}?>" reg='高度' class="Iw45 size" name='height' id='size'>&nbsp;px
                  <span id='sizeTip'></span>
                  </td>
                </tr>
                <?php if (($_smarty_tpl->tpl_vars['effect']->value['id'] == 7 || $_smarty_tpl->tpl_vars['effect']->value['id'] == 9) && $_smarty_tpl->tpl_vars['effect']->value['adposition'] == 1) {?>
                <tr id='pos1'>
                  <th><font>*</font> 广告位位置：</th>
                  <td>
                  <input type="radio" value="1"  class="Iw45" name='pos' <?php if ($_smarty_tpl->tpl_vars['infor']->value['pos'] != 2) {?>checked<?php }?> >左上角
                  <input type="radio" value="2"  class="Iw45" name='pos' <?php if ($_smarty_tpl->tpl_vars['infor']->value['pos'] == 2) {?>checked<?php }?>>右上角
                  </td>
                </tr>
                <?php }?>
                <?php if (($_smarty_tpl->tpl_vars['effect']->value['id'] != 7 && $_smarty_tpl->tpl_vars['effect']->value['id'] != 9) && $_smarty_tpl->tpl_vars['effect']->value['adposition'] == 1) {?>
                <tr id='pos2'>
                  <th><font>*</font> 广告位位置：</th>
                  <td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['up'];?>
"   class="Iw45 position" name='up' id='up'>&nbsp;px&nbsp;&nbsp;
                  <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['left'];?>
"  class="Iw45 position" name='left' id='left'>&nbsp;px
                  <span id='positionTip'></span>
                  </td>
                </tr>
                <?php }?>
                 <?php if ($_smarty_tpl->tpl_vars['effect']->value['wordnum'] == 1) {?>
                 <tr  id='fontnum'>
                  <th width="145px"><font>*</font>每条广告显示字数：</th>
                  <td>
                      <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['fontnum'];?>
" name='fontnum' id='fontsize' class="Iw290" <?php if ($_smarty_tpl->tpl_vars['type']->value['wordnum'] != 1) {?>readonly<?php }?>/>
                      <span id='fontsizeTip'></span>
                  </td>
                </tr>
                <?php }?>
                <tr>
                  <th>&nbsp; 广告位描述：</th>
                  <td><textarea class="Iw450 Ih80" name='addescript'><?php echo $_smarty_tpl->tpl_vars['infor']->value['addescript'];?>
</textarea></td>
                </tr>
              </table>
            </div>
             <div class="pubTabelBot">
                <input type="submit" hidefocus="hide" value="确定" class="btn1">

                <input type="button" hidefocus="hide" value="取消" class="btn2 cancle">

              </div>
           </form>
          </div>
        </div>
      </div>
    </div>
    </body>
    </html><?php }
}
