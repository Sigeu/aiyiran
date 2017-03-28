<?php
/* Smarty version 3.1.30, created on 2017-03-20 11:12:57
  from "D:\xampp\htdocs\aiyiran\admin\template\admin\login\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58cf48b9a04075_33894032',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fe41a750407e458b684e3a328444e373788543ff' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\admin\\login\\index.html',
      1 => 1489738647,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/copyright.html' => 1,
  ),
),false)) {
function content_58cf48b9a04075_33894032 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台登录</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {
    $('#captcha').click(function(){
        $('#captcha').attr('src','<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php?' + Math.random());
        return false;
    });
    
    
    $("#username").blur(function(){
     if($(this).val()=="" || $(this).val()=="请输入用户名")
     {
        $("#uname").html("用户名不能为空！");
        $("#uname").addClass("error");
        $("#username").addClass("errorRed");        
     }else
     {
         $("#uname").html("");
         $("#uname").removeClass("error");
         $("#username").removeClass("errorRed"); 
     }
    });
    
    $("#password").blur(function(){
     if($(this).val()=="")
     {
        $("#pwd").html("密码不能为空！");
        $("#pwd").addClass("error");
        $("#password").addClass("errorRed");        
     }else
     {
         $("#pwd").html("");
         $("#pwd").removeClass("error");
         $("#password").removeClass("errorRed"); 
     }
    });
    
    $("#captcha_code").blur(function(){
     if($(this).val()=="" || $(this).val()=="请输入验证码")
     {
        $("#code").html("验证码不能为空！");
        $("#code").addClass("error");
        $("#captcha_code").addClass("errorRed");        
     }else
     {
         $("#code").html("");
         $("#code").removeClass("error");
         $("#captcha_code").removeClass("errorRed"); 
     }
    });
    
});

document.onkeydown=function(event){
     var e = event || window.event || arguments.callee.caller.arguments[0];
     if(e && e.keyCode==13){ // enter 键
         loginsubmit();
         return false;
    }
}; 


//后台登录表单验证
function loginsubmit()
{
    var numbers  = Math.random();
    var username = $("#username").val();
    var password = $("#password").val();
    var captcha  = $("#captcha_code").val();
    var isremember = $("#isremember").attr('checked');
    
    if(username=='' || username=='请输入用户名')
    {
        $("#uname").html("用户名不能为空！");
        $("#uname").addClass("error");
        $("#username").addClass("errorRed");
        return false;
    }
    if(password=='')
    {
        $("#pwd").html("密码不能为空！");
        $("#pwd").addClass("error");
        $("#password").addClass("errorRed");  
        return false;
    }
    if(captcha=='' || captcha=="请输入验证码")
    {
        $("#code").html("验证码不能为空！");
        $("#code").addClass("error");
        $("#captcha_code").addClass("errorRed"); 
        return false;
    }
    $.post("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/login/checklogin",{task:'dosubmit',username:username,password:password,captcha:captcha,isremember:isremember,number:numbers},function(data){
    	if (data == 5) {
            alert('登录失败！');
            $('#captcha').attr('src','<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php?' + Math.random());
        } else
    	if(data == 1)
        {
            $("#code").html("请输入正确的验证码");
            $("#code").addClass("error");
            $('#captcha').attr('src','<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php?' + Math.random());
        }else if(data==2)
        {
	          $("#uname").html("用户不存在 ");
	          $("#uname").addClass("error");
	          $('#captcha').attr('src','<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php?' + Math.random());
	          }else if(data==3)
	          {
	              $("#uname").html("账号异常，请联系总管理员  ");
	              $("#uname").addClass("error");
	          }else if(data==4)
	          {
                  $("#pwd").html("密码错误  ");
                  $("#pwd").addClass("error");
                  $('#captcha').attr('src','<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php?' + Math.random());
	          }else if(data==10)
	          {
	              window.location.href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/index/index?"+ Math.random();
	          }
        });
}
<?php echo '</script'; ?>
>
</head>
<body>
<div class="login_top">MainOne CMS</div>
<div class="login_con">
  <div class="login_contaier">
    <div class="login_info">
     <form action="" method="post" id="myForm" name="myForm">
        <ul>
          <li>
            <span class="login_input01"><input id="username" name="username" value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
" type="text" class="login_intxt text-tips" tips="请输入用户名" style="padding-left:45px;" /></span><span id ="uname" class=""></span>
          </li>
          <li>
            <span class="login_input02"><input id="password" name="password" value="" type="password" class="login_inpwd" style="padding-left:45px;" /></span><span id ="pwd" class=""></span>
          </li>
          <li>
            <span><input id="captcha_code" name="captcha_code" type="text" class="login_input03 text-tips" tips="请输入验证码" value=""/></span>
            <span class="yzm"><img id="captcha" onerror="this.src='<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php?t=1'" src="<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php" class="yzm"/></span><span id ="code" class=""></span>
          </li>
          <li><span><input type="button" name="dosubmit" value="登录" onclick="loginsubmit();" class="login_btn" /></span>&nbsp;&nbsp;&nbsp;<span class="logininfo"><input type="checkbox" style="vertical-align:-2px;" id="isremember" name="isremember" value="1" checked />&nbsp;<span class="f999">记住用户名</span>&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/login/findpwd" target="_blank">找回密码</a></span></span></li>
        </ul>
     </form>
    </div>
  </div>
</div>
<div class="login_foot"><?php $_smarty_tpl->_subTemplateRender("file:public/copyright.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
</body>
<?php echo '<script'; ?>
>
$('#captcha').ready(function () {
    var img=new Image();
    img.src=$('#captcha').attr('src');
    if(img.width==0){
         $('#captcha').attr('src','<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
static/js/securimage/securimage_show.php?' + Math.random());
    }
});
<?php echo '</script'; ?>
>
</html><?php }
}
