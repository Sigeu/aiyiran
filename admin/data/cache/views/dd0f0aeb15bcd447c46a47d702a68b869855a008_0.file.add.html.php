<?php
/* Smarty version 3.1.30, created on 2017-03-13 14:45:37
  from "D:\xampp\htdocs\aiyiran\admin\template\content\content\add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c64011b80146_89481491',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dd0f0aeb15bcd447c46a47d702a68b869855a008' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\content\\content\\add.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58c64011b80146_89481491 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<style>
strong{ font-size:20px; line-height:20px; display:block; padding:10px 0;}
</style>
</head>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
			<dd><a href="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['indexUrl'];?>
">内容列表</a></dd>
            <dt class="on"><a href="">添加文章</a></dt>
			<dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/issue/content" class="last">更新文档</a></dd>
          </dl>
        </div>
        <form action="<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['addsaveUrl'];?>
" method='post' id='myForm'>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <table class="tabelLR">
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['form']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
                  <?php echo $_smarty_tpl->tpl_vars['item']->value;?>

              <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
               <div class="pubTabelBot">
                <input type="button" hidefocus="hide" id='myButton' value="确定" class="btn1" onclick="javascript:formSubmit()"><input type="button" hidefocus="hide" value="取消" onclick="javascript:window.location.href='<?php echo $_smarty_tpl->tpl_vars['urlArr']->value['indexUrl'];?>
';" class="btn2">
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    <div class="clearfix"></div>
 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
$(document).ready(function(){
	$.formValidator.initConfig({autotip:true,formid: "myForm",generalwordwide:true,  debug:false,onError: function(msg) {}, onSuccess: function() {}});
	<?php echo $_smarty_tpl->tpl_vars['formvalidator']->value;?>

	
	$('#categoryid').bind('change',function(){
		var _obj = $(this);
		var changeModel = $('#changeModel').val();
		var categoryid = _obj.val();
		var modelid = $("#hidden_model_"+categoryid).val();
		if(modelid!=changeModel&&categoryid)
		{
			$('#changeModel').val(modelid);
			window.location.href="/admin/content/Content/chanageForm/categoryid/"+categoryid+'/mid/'+modelid;
		}
	});
})
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
