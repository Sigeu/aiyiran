<?php
/* Smarty version 3.1.30, created on 2016-12-29 16:08:23
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\mail\mailset.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5864c4770455c0_09303311',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ce41fbb07c2f6f7103dffcf68722abe3d04f89d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\mail\\mailset.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_5864c4770455c0_09303311 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function(){
	
	$.formValidator.initConfig({formid:"form",debug:false,submitonce:true,
		onerror:function(msg,obj,errorlist){
			//$.map(errorlist,function(msg1){alert(msg1)});
			//alert(msg);
		}
	});
	//发送邮件邮箱账号验证
	$("#mail").formValidator({empty:false,onshow:"请输入邮箱地址,由@,点号组成",onfocus:"请输入邮箱地址,由@,点号组成",oncorrect:"输入正确"})
	.inputValidator({min:1,onerror:"请输入邮箱地址,由@,点号组成"})
	.functionValidator({
		 fun:function(val){
		    
			 var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		     if(reg.test(val)){
		    	 return true;
		     }else{
		    	 return "请输入邮箱地址,由@,点号组成";
		     }
		 }
	}).defaultPassed();
	
	//发送邮件邮箱密码验证
	$("#password").formValidator({onshow:"请输入密码,至少4位字符",onfocus:"请输入密码,至少4位字符",oncorrect:"输入正确"})
	.functionValidator({
		 fun:function(val){

		     if(val.length<4){
		    	 
		    	 return "请输入密码,至少4位字符";
		     } else if (val.indexOf(' ') != -1) {
		    	 
		    	 return "请输入非空格字符";
		     }else {
		    	 
		    	 return true;
		     }
		 }
	}).defaultPassed();
	
	//发送邮件用户名称验证
	$("#name").formValidator({empty:true,onshow:" ",onfocus:"请输入2-100个字符,由数字、文字、字母、符号组成",oncorrect:"输入正确",onempty:"用户名可为空"})
	.inputValidator({min:2,max:100,onerror:"请输入2-100个字符,由数字、文字、字母、符号组成"});
	
	//SMTP服务器
	$("#smtpserver").formValidator({onshow:"请输入SMTP服务器",onfocus:"请输入SMTP服务器",oncorrect:"输入正确"})
	.inputValidator({min:1,onerror:"请输入SMTP服务器"}).defaultPassed();
	
	//smtp端口号
	$("#port").formValidator({onshow:"请输入服务器端口号,由正整数组成",onfocus:"请输入服务器端口号,由正整数组成",oncorrect:"输入正确"})
	.regexValidator({regexp:"^[0-9]+$",onerror:"请输入服务器端口号,由正整数组成"}).defaultPassed();
	
	//取消按钮
	$(".cancel").click(function(){
		location.reload(true);
	})
	
    $("#sub").bind('click',function(){
    	
    	var val = $("input[name='sendstyle']:checked").val();
 
    	if ( val == 2 ) {
    		
    		
    	}
    	
       if($.formValidator.pageIsValid("1") == true){
    	 //接收需要提交的数据
   		 var sendstyle = $('input:radio[name=sendstyle]:checked').val();
   		 var smtpserver = $("input[name=smtpserver]").val();
   		 var name = $("input[name=name]").val();
   		 var port = $("input[name=port]").val();
   		 var mail = $("input[name=mail]").val();
   		 var password =$("input[name=password]").val();
   		 
   		 if(password == "请输入您的密码"){
   			 
   			password = $("input[name=hidpwd]").val();
   			
   		 }
   		 
   		 var parameter = 'sendstyle='+sendstyle+'&smtpserver='+smtpserver+'&name='+name+'&port='+port+'&mail='+mail+'&password='+password; 
   		
   		 //异步提交数据
   		 $.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/mailset/mailserver',parameter,function(infor){
   			Moalert(infor);
   	     });
       }
       return false;
    });
	
	//取消操作
	$(".cancel").click(function(){
		location.reload();
	});
    
    var tips = new Array();
        tips['smtpserver'] = '请输入SMTP服务器';
        tips['port'] = '请输入服务器端口号,由正整数组成';
        tips['mail'] = '请输入邮箱地址,由@,点号组成';
        tips['password'] = '请输入密码,至少4位字符';
    $('input:text').each(function () {
        var val = $(this).val();
        var id = $(this).attr('id');
        if (val=='') {
            $('#' + id + 'Tip').text(tips[id]);
            $('#' + id + 'Tip').attr('class', 'onShow');
        }
    });
});
<?php echo '</script'; ?>
>
<body>

<div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">邮件服务器设置</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div >
            <div class="pubTabel" id='parent'> 
            
             <form   id="form" action='' method='post'>
              <table class="tabelLR">
                <tr>
                  <th><font>*</font> 邮件发送方式：</th>
                  <td><span>
                    <input type="radio" name='sendstyle' value="1" <?php if ($_smarty_tpl->tpl_vars['mail']->value['mo_send_style'] == 1) {?>checked<?php }?>/>
                    <label>SMTP模式发送</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='sendstyle' value="2" <?php if ($_smarty_tpl->tpl_vars['mail']->value['mo_send_style'] == 2) {?>checked<?php }?>/>
                    <label>mail函数发送</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style='color:red'>*&nbsp;&nbsp;使用mail函数发送时请确保您的系统上有支持发送邮件的邮件服务软件 &nbsp;请谨慎使用</span>
                    </td>
                </tr>
                <tr>
                  <th>&nbsp;&nbsp;发送邮件用户名称：</th>
                  <td><input class="Iw150"  type="text" value="<?php echo $_smarty_tpl->tpl_vars['mail']->value['mo_send_user'];?>
" name="name" id="name"/>
                  <span id="nameTip"></span>
                  </td>
                </tr>
                <tr>
                  <th><font>*</font> SMTP服务器：</th>
                  <td><input class="Iw150"  type="text" value="<?php echo $_smarty_tpl->tpl_vars['mail']->value['mo_service'];?>
" name="smtpserver" id="smtpserver"/>
                      <span id="smtpserverTip"></span>
                  </td>
                </tr>
                <tr>
                  <th><font>*</font> SMTP服务器端口：</th>
                  <td><input class="Iw150"  type="text" name="port" value="<?php echo $_smarty_tpl->tpl_vars['mail']->value['mo_service_port'];?>
" id="port"/>
                      <span id="portTip"></span>
                  </td>
                </tr>
                <tr>
                  <th> <font>*</font> 发送邮件邮箱账号：</th>
                  <td><input class="Iw150"  type="text" name="mail" value="<?php echo $_smarty_tpl->tpl_vars['mail']->value['mo_mail_account'];?>
" id="mail"/>
                  <span id="mailTip"></span></td>
                </tr>
                <tr>
                  <th> <font>*</font> 发送邮件邮箱密码：</th>
                  <td><input class="Iw150"  type="password" name="password" value="请输入您的密码" id="password"/>
                  <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['mail']->value['mo_mail_password'];?>
" class='hidpwd' name='hidpwd'></input>
                  <span id="passwordTip"></span>
                  </td>
                </tr>
              </table>       
              <div class="pubTabelBot">
                <input type="button" hidefocus="hide" value="确定" class="btn1" id="sub">
                <input type="button" hidefocus="hide" value="取消" class="btn2 cancel">
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html><?php }
}
