<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:08:18
  from "D:\WWW\jisi2\admin\template\webset\search\search.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585384d26b6d29_57658325',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1e09720d1f5f34ddf15bdd6de939df616ba53004' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\webset\\search\\search.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_585384d26b6d29_57658325 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>
   $(function(){
	   
     $(".cancel").click(function(){
	     window.location.href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;
echo $_smarty_tpl->tpl_vars['url']->value;?>
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
            <dt class="on"><a href="#">全文搜索配置</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div >
            <div class="pubTabel" id='parent'> 
             <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/search/searchAdd' method='post' name="myForm" id='myForm'>
              <table class="tabelLR">
                <tr>
                  <th  style="width:390px;"> 启用Sphinx全文搜索功能（需配置Sphinx服务器）：</th>
                  <td>
                    <input type="radio" name='stat' id='stat' onclick="changeit(1);"  value='1' <?php if ($_smarty_tpl->tpl_vars['stat']->value == 1) {?>   checked=true <?php }?>/>
                    <label>是</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='stat' id='stat' onclick="changeit(2);"  value='2' <?php if ($_smarty_tpl->tpl_vars['stat']->value == 2) {?>   checked=true <?php }?>/>
                    <label>否</label>
                  </td>
                </tr>
              </table> 
              <div id='showinfo' style="display:block">
                <table class="tabelLR"> 
                <tr>
                  <th><?php if ($_smarty_tpl->tpl_vars['stat']->value == 1) {?><font>*</font><?php }?> Sphinx服务器主机地址：</th>
                  <td><input class="Iw150"  type="text"  value="<?php echo $_smarty_tpl->tpl_vars['dress']->value;?>
"  name="dress" id="dress"/><span id ="dname" class=""></span>
                  </td>
                </tr>
                <tr>
                  <th><?php if ($_smarty_tpl->tpl_vars['stat']->value == 1) {?><font>*</font><?php }?> Sphinx服务器端口号：</th>
                  <td><input class="Iw150"  type="text" value="<?php echo $_smarty_tpl->tpl_vars['number']->value;?>
" name="number" id="number"/><span id ="nname" class=""></span>
                  </td>
                </tr>
                </table> 
              </div>   
              <div class="pubTabelBot">
            	<input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" name='url'>
              	<input type="hidden" name='show' id='show' value="<?php echo $_smarty_tpl->tpl_vars['stat']->value;?>
">
                <input type="submit" hidefocus="hide" value="确定" class="btn1" id="sub">
                <input type="button" hidefocus="hide" value="取消" class="btn2 cancel" >
              </div>
              </form>
            </div>
             <div class="notice2"><span class="notice_warnblue">备注说明：Sphinx服务器配置方法请参照官方网站相关说明。</span></div>
			</div>
        </div>
      </div>
    </div>
</body>
</html>



<?php echo '<script'; ?>
 type="text/javascript">
/*js验证*/
$(document).ready(function(){
		
	$.formValidator.initConfig({formid:"myForm",autotip:true,generalwordwide:true});
	
	$("#dress").formValidator({empty:false,onshow:"请输入服务器地址",onempty:"输入正确",onfocus:"请输入服务器地址",oncorrect:"输入正确"})
	.inputValidator({min:1,max:20,onerror:"请输入服务器地址"}).defaultPassed();

	$("#number").formValidator({empty:false,onshow:"请输入服务器端口",onfocus:"请输入服务器端口",oncorrect:"输入正确",onempty:"输入正确"}).inputValidator({min:1,max:4,onerror:"请输入服务器端口"}).defaultPassed();
	
	/*是/否隐藏显示*/
	if($('#show').val() == 1)
	{ 
		showinfo.style.display="block";
	}
	else if($('#show').val() == 2)
	{
		showinfo.style.display="none";
	}
	
});
<?php echo '</script'; ?>
>



<?php echo '<script'; ?>
 type="text/javascript">
/*单选按钮切换*/
function changeit(stat)
{
	if(stat == 1)
	{
		showinfo.style.display="block";
	}
	else
	{
		showinfo.style.display="none";
	}
		
}
<?php echo '</script'; ?>
>

<?php }
}
