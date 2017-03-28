<?php
/* Smarty version 3.1.30, created on 2017-01-11 17:11:37
  from "D:\xampp\htdocs\aiyiran\admin\template\content\column\content_column_edit.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5875f6c9b95b37_85309759',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '07eafec8385e8157421860873d100a5aa53ce385' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\content\\column\\content_column_edit.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_5875f6c9b95b37_85309759 (Smarty_Internal_Template $_smarty_tpl) {
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
 type="text/javascript">
$(function()
{
	init('content', 'fail');
	//初始化配置
	$.formValidator.initConfig({formid:"formid",autotip:true,generalwordwide:true});
	//栏目名验证
	$("#catname").formValidator(
	{
		onshow:"请输入栏目名称",
		onfocus:"请输入2至60个字符",
		oncorrect:"输入正确"
	}).inputValidator(
	{
		min:2,
		max:60,
		onerror:"请输入2至60个字符"
	}).defaultPassed();

	//模型必选验证
	$("#model").formValidator(
	{
		onshow:"请选择内容模型",
		onfocus:"请选择内容模型",
		oncorrect:"选择正确"
	}).inputValidator(
	{
		min:1,
		onerror: "内容模型必选"
	}).defaultPassed();
	//目录名验证
	$("#filepath").formValidator(
	{
		onshow:"请输入文件保存目录",
		onfocus:"请输入1至40个字符",
		oncorrect:"输入正确",
		empty:true,
		onempty:'输入为空，将取栏目拼音为目录名'
	}).functionValidator(
	{
		 fun:function(val)
		 {
			var columnattr = $('#columnattr-link').attr('checked');
			//选择了添加外部链接
			if (columnattr == 'checked')
			{
				 reg = new RegExp(regexEnum.url,"i");  // 创建正则表达式对象。
				 if(val.match(reg))
					 return true;
				 else
					 return "栏目属性选择外部链接时，请输入正确的链接地址";
			}
			//没有选择了添加外部链接
			else
			{
				var len = val.length;
				if(len >=1 &&  len <=40)
				{
					 reg = new RegExp(regexEnum.numberLetter,"i");  // 创建正则表达式对象。
					 if(reg.test(val))
						 return true;
					 else
						 return "目录名称格式错误";
				}
				else
				{
					return '请输入1至40个字符';
				}
			}
		 }
	}).ajaxValidator(
	{
		type:"POST",
		other:['editid'],
		url : "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/ajaxcheckpath",
		success : function(data)
		{	
			var columnattr = $('#columnattr-link').attr('checked');
			if ((data == 1) && (columnattr == undefined))
				return false;
			else 
				return true;
		},
		buttons: $(".btn2"),
		error: function(jqXHR, textStatus, errorThrown){onerror: "可能服务器忙，请重试"},
		onerror : "该目录名已被占用，请换一个",
		onwait : "正在对目录名进行合法性校验，请稍候..."
	}).defaultPassed();

	$("#crossid").formValidator(
	{
		onshow:"请输入栏目ID(用逗号分开)",
		onfocus:"请输入栏目ID(用逗号分开)",
		oncorrect:"输入正确"
	}).functionValidator(
	{
		 fun:function(val)
		 {
			if ($('#columncross3').attr('checked') == 'checked')//选择了手工交叉
			{
				reg = new RegExp("[^0-9,]","i");  // 创建正则表达式对象。
				 if(val.match(reg))
					 return "请输入栏目ID(用逗号分开)";
				 else
					 return true;
			}
			return true;
		 }
	});

	//seo设置验证
    $("#seo_title").formValidator(
    {
        empty:true,
        onshow:"请输入0-62个字符",
        onfocus:"请输入0-62个字符"
    }).inputValidator(
    {
        min:0,
        max:62,
        onerror:"请输入0-62个字符",
        onerrormax:"最多输入62个字符"
    }).defaultPassed();
    $("#seo_keywords").formValidator(
    {
        empty:true,
        onshow:'请输入0-200个字符，多个关键词之间用","隔开',
        onfocus:'请输入0-200个字符，多个关键词之间用","隔开'
    }).inputValidator(
    {
        min:0,
        max:200,
        onerror:"请输入0-200个字符",
        onerrormax:"最多输入200个字符"
    }).defaultPassed();
    $("#seo_description").formValidator(
    {
        empty:true,
        onshow:"请输入0-300个字符",
        onfocus:"请输入0-300个字符"
    }).inputValidator(
    {
        min:0,
        max:62,
        onerror:"请输入0-300个字符",
        onerrormax:"最多输入300个字符"
    }).defaultPassed();

	$('.columncross').bind('click',function()
	{
		if($(this).val() == 3)
		{
			$('#crossid').focus().blur();
			$('#crossid').attr('disabled',false);
		}
		else 
		{
			$('#crossid').focus();
			$('#crossid').attr('disabled',true);
		}
	});
    
    $('#filepath').bind('blur', function () {
        var check = $('#pinyin').attr('checked');
        if (check != 'checked') {
            var val = $('#filepath').val();
            if (val == '') {
                $('#filepathTip').attr('class', 'onError');
                $('#filepathTip').text('请输入1至40个字符');
            }
        }
    });
    
    $('#formid').bind('submit', function () {
        var check = $('#pinyin').attr('checked');
        if (check != 'checked') {
            var val = $('#filepath').val();
            if (val == '') {
                $('#filepathTip').attr('class', 'onError');
                $('#filepathTip').text('请输入1至40个字符');
                return false;
            }
            return true;
        }
    });
});

<?php echo '</script'; ?>
>
<div id="qwe" class="">
	
</div>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="javascript:;">基本项</a></dt>
            <dt><a href="javascript:;">权限设置</a></dt>
            <dt><a href="javascript:;">SEO设置</a></dt>
            <dt><a href="javascript:;">栏目内容</a></dt>
          </dl>
        </div>
		<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/edit" id="formid" enctype="multipart/form-data">
		<input type="hidden" name="id" id="editid" value="<?php echo $_smarty_tpl->tpl_vars['column_info']->value['id'];?>
" />
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <table class="tabelLR"><!--  基本项 Start  -->
                <tr>
                  <th width="145px"><font>*</font> <font>栏目名称：</font></th>
                  <td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['column_info']->value['catname'];?>
" name="info[base][catname]" id="catname" maxlength="60" class="Iw290"/></td>
                </tr>
                <tr>
                  <th><font>*</font> 内容模型：</th>
                  <td>
					  <select class="Iw290" style="width:302px;" name="info[base][model]" <?php if (!$_smarty_tpl->tpl_vars['content_num']->value) {?>id="model"<?php }?>>
						<?php if ($_smarty_tpl->tpl_vars['content_num']->value) {?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['model']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
							<?php if ($_smarty_tpl->tpl_vars['column_info']->value['model'] == $_smarty_tpl->tpl_vars['l']->value['id']) {?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['l']->value['name'];?>
</option>
							<?php }?>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						<?php } else { ?>
							<option value="">请选择模型</option>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['model']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['model'] == $_smarty_tpl->tpl_vars['l']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value['name'];?>
</option>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						<?php }?>
					</select>
					<?php if ($_smarty_tpl->tpl_vars['content_num']->value) {?>
					<strong>[温馨提示]：</strong><span>此栏目下有内容则不能更换"内容模型"！</span>
					<?php }?>
				  </td>
                </tr>
                <tr>
                  <th>&nbsp; 父级栏目：</th>
                  <td><select class="Iw290" style="width:302px;" name="info[base][pid]">
                      <option value="0">顶级栏目</option>
					  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cat_tree']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
					  <option value="<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['pid'] == $_smarty_tpl->tpl_vars['l']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value['catname'];?>
</option>
					  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select></td>
                </tr>
                <tr>
                  <th><font>*</font> 文件保存目录：</th>
                  <td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['column_info']->value['filepath'];?>
" class="Iw290" name="info[base][filepath]" id="filepath"/> <input type="checkbox" name="pinyin" id="pinyin" value="1" /> 拼音
                   目录名为数字、字母组合</td>
                </tr>
                <tr>
                  <th>&nbsp; 栏目首页模板：</th>
                  <td><select class="Iw290" style="width:302px;" name="info[base][indextpl]">
                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['index_tpl']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['indextpl'] == $_smarty_tpl->tpl_vars['l']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value;?>
</option>
					  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select></td>
                </tr>
                <tr>
                  <th>&nbsp; 栏目列表页模板：</th>
                  <td><select class="Iw290" style="width:302px;" name="info[base][columntpl]">
                       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list_tpl']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columntpl'] == $_smarty_tpl->tpl_vars['l']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value;?>
</option>
					  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select></td>
                </tr>
                <tr>
                  <th>&nbsp; 内容页模板：</th> 
                  <td><select class="Iw290" style="width:302px;" name="info[base][contenttpl]">
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['content_tpl']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['l']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['contenttpl'] == $_smarty_tpl->tpl_vars['l']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value;?>
</option>
					 <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select></td>
                </tr>
                <tr>
                  <th>&nbsp; 是否在导航显示：</th>
                  <td><span>
                    <input type="radio" name="info[base][isnav]" value="1" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['isnav'] == 1) {?>checked<?php }?>/>
                    <label>是</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name="info[base][isnav]" value="2" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['isnav'] == 2) {?>checked<?php }?>/>
                    <label>否</label>
                    </span></td>
                </tr>
                <tr>
                  <th>&nbsp; 栏目页选项：</th>
                  <td>
				    <span>
                    <input type="radio" name="info[base][columnoption]" value="1" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columnoption'] == 1) {?>checked<?php }?>/>
                    <label>链接到栏目首页静态页</label>
                    </span>&nbsp;&nbsp;
					<span>
                    <input type="radio" name="info[base][columnoption]" value="3" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columnoption'] == 3) {?>checked<?php }?>/>
                    <label>链接到栏目首页动态页</label>
                    </span>&nbsp;&nbsp;
					<span>
                    <input type="radio" name="info[base][columnoption]" value="2" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columnoption'] == 2) {?>checked<?php }?>/>
                    <label>链接到栏目列表第一页</label>
                    </span>
					</td>
                </tr>
                <tr>
                  <th>&nbsp; 保存目录位置：</th>
                  <td><span>
                    <input type="radio" name="info[base][dirpath]" value="1" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['dirpath'] == 1) {?>checked<?php }?>/>
                    <label>上级目录</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name="info[base][dirpath]" value="2" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['dirpath'] == 2) {?>checked<?php }?>/>
                    <label>CMS根目录</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name="info[base][dirpath]" value="3" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['dirpath'] == 3) {?>checked<?php }?>/>
                    <label>站点根目录</label>
                    </span></td>
                </tr>
                <tr>
                  <th>&nbsp; 栏目属性：</th>
                  <td><span>
                    <input type="radio" name="info[base][columnattr]" value="1" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columnattr'] == 1) {?>checked<?php }?>/>
                    <label>最终列表栏目（允许在本栏目发布文档，并生成文档列表）</label>
                    </span><br />
                    <span>
                    <input type="radio" name="info[base][columnattr]" value="2" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columnattr'] == 2) {?>checked<?php }?>/>
                    <label>频道封面（栏目本身不允许发布文档）</label>
                    </span><br />
                    <span>
                    <input type="radio" name="info[base][columnattr]" id="columnattr-link" value="3" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columnattr'] == 3) {?>checked<?php }?>/>
                    <label>外部链接（在"文件保存目录"处填写网址）</label>
                    </span>
					<br />
                    <span>
                    <input type="radio" name="info[base][columnattr]" id="columnattr-link" value="4" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columnattr'] == 4) {?>checked<?php }?>/>
                    <label>单页栏目（例如：公司简介等）</label>
                    </span>
					</td>
                </tr>
                <tr>
                  <th>&nbsp; 栏目交叉<br />
                    &nbsp; 仅适用[最终列表栏目]：</th>
                  <td><span>
                    <input type="radio" name="info[base][columncross]" value="1" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columncross'] == 1) {?>checked<?php }?> class="columncross"/>
                    <label>不交叉</label>
                    </span><span>
                    <input type="radio" name="info[base][columncross]" value="2" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columncross'] == 2) {?>checked<?php }?> class="columncross"/>
                    <label>自动获取同名栏目内容</label>
                    </span><br />
                    <span>
                    <input type="radio" name="info[base][columncross]" id="columncross3" value="3" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columncross'] == 3) {?>checked<?php }?> class="columncross"/>
                    <label>手工指定交叉栏目ID(用逗号分开)</label>
                    </span>
                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['column_info']->value['crossid'];?>
" <?php if ($_smarty_tpl->tpl_vars['column_info']->value['columncross'] != 3) {?>disabled<?php }?>  name="info[base][crossid]" id="crossid" class="Iw150" /></td>
                </tr>
              </table><!--  基本项 end  -->
              <div class="pubTabelBot">
                <input type="submit"  hidefocus="hide" value="确定" class="btn1">
                &nbsp;&nbsp;&nbsp;
                <input type="button" hidefocus="hide" value="取消" class="btn2"  onclick="javascript:location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/index'">
              </div>
            </div>
          </div>
          <div style="display:none;">
            <div class="pubTabel">
              <table class="tabelLR"><!--  权限设限 Start  -->
                <tr>
                  <th width="145px"><strong>管理员权限：</strong></th>
                  <td>温馨提示【如果您设置的某管理员权限不能正常使用，请查看“系统角色管理”中此管理员的权限！】</td>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['admin_role']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>				
                <tr>
                  <th><?php echo $_smarty_tpl->tpl_vars['l']->value['rolename'];?>
：</th>
                  <td><span>
                    <input type="checkbox" name="info[power][admin][<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
][]" value="2" <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['admin']->value, 'l1', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['l1']->value) {
if (($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['l']->value['id']) && in_array(2,$_smarty_tpl->tpl_vars['l1']->value)) {?>checked<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 />
                    <label>添加</label>
                    </span>&nbsp;&nbsp;<span>
                    <input type="checkbox" name="info[power][admin][<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
][]" value="3" <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['admin']->value, 'l1', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['l1']->value) {
if (($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['l']->value['id']) && in_array(3,$_smarty_tpl->tpl_vars['l1']->value)) {?>checked<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 />
                    <label>修改</label>
                    </span>&nbsp;&nbsp;<span>
                    <input type="checkbox" name="info[power][admin][<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
][]" value="4" <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['admin']->value, 'l1', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['l1']->value) {
if (($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['l']->value['id']) && in_array(4,$_smarty_tpl->tpl_vars['l1']->value)) {?>checked<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 />
                    <label>删除</label>
                    </span>&nbsp;&nbsp;<span>
                    <input type="checkbox" name="info[power][admin][<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
][]" value="5" <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['admin']->value, 'l1', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['l1']->value) {
if (($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['l']->value['id']) && in_array(5,$_smarty_tpl->tpl_vars['l1']->value)) {?>checked<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 />
                    <label>移动</label>
                    </span></td>
                </tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <tr>
                  <th><strong>会员权限：</strong></th>
                  <td></td>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['member_group']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
                <tr>
                  <th><?php echo $_smarty_tpl->tpl_vars['l']->value['groupname'];?>
：</th>
                  <td>
					<span><input type="checkbox" name="info[power][member][<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
][]" value="1" <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['member']->value, 'l1', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['l1']->value) {
if (($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['l']->value['id']) && in_array(1,$_smarty_tpl->tpl_vars['l1']->value)) {?>checked<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 /><label>允许访问</label></span>&nbsp;&nbsp;
					<span><input type="checkbox" name="info[power][member][<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
][]" value="2" <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['member']->value, 'l1', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['l1']->value) {
if (($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['l']->value['id']) && in_array(2,$_smarty_tpl->tpl_vars['l1']->value)) {?>checked<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 /><label>允许评论</label></span>
				   </td>
                </tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table><!--  权限设限 End  -->
              <div class="pubTabelBot">
                <input type="submit" hidefocus="hide" value="确定" class="btn1">
                &nbsp;&nbsp;&nbsp;
                <input type="button" hidefocus="hide" value="取消" class="btn2"  onclick="javascript:location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/index'">
              </div>
            </div>
          </div>
          <div style="display:none;">
            <div class="pubTabel">
              <table class="tabelLR"><!--  SEO设置 Start  -->
                <tr>
                  <th width="145px">标题：</th>
                  <td><input id="seo_title" type="text" value="<?php echo $_smarty_tpl->tpl_vars['column_info']->value['seo_title'];?>
" class="Iw215" maxlength="62" name="info[base][seo_title]"/></td>
                </tr>
                <tr>
                  <th>关键词：</th>
                  <td><input id="seo_keywords" type="text" value="<?php echo $_smarty_tpl->tpl_vars['column_info']->value['seo_keywords'];?>
" class="Iw215" maxlength="200" name="info[base][seo_keywords]"/></td>
                </tr>
                <tr>
                  <th>描述：</th>
                  <td><textarea class="Iw450 Ih80" id="seo_description" maxlength="300" name="info[base][seo_description]"><?php echo $_smarty_tpl->tpl_vars['column_info']->value['seo_description'];?>
</textarea></td>
                </tr>
              </table><!--  SEO设置 End  -->
              <div class="pubTabelBot">
                <input type="submit" hidefocus="hide" value="确定" class="btn1"/>
                <input type="button" hidefocus="hide" value="取消" class="btn2"  onclick="javascript:location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/index'"/>
              </div>
            </div>
          </div>
		  <div style="display:none;">
            <div class="pubTabel">
              <table class="tabelLR"><!--  栏目内容  -->
                <tr>
                  <th>描述：</th>
                  <td><textarea class="Iw450 Ih80" id='content' name='info[base][content]'><?php echo $_smarty_tpl->tpl_vars['column_info']->value['content'];?>
</textarea></td>
                </tr>
              </table><!--  SEO设置 End  -->
              <div class="pubTabelBot">
                <input type="submit" hidefocus="hide" value="确定" class="btn1"/>
                <input type="button" hidefocus="hide" value="取消" onclick="javascript:location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/column/index'" class="btn2"/>
              </div>
            </div>
          </div>
        </div>
		</form>
      </div>
    </div>
    <div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
><?php }
}
