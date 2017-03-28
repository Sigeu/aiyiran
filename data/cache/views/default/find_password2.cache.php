<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>重置密码</title>
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/login2.css"/>
	</head>
	<body>
		<div class="login_top">
			<div class="login_cont">
				<a href="###" class="logo fl"><img src="<?php echo IMG_PATH;?>/login_02.jpg"/></a>
				<span class=" fl">重置密码</span>
			</div>
		</div>
		  <div class="set_box">
		  	<div class="set_cont">
		  		<ul class="three_step">
		  			<li class="active">
		  				<span>
		  					<i>1</i>
		  					<b>安全验证</b>
		  				</span>
		  				<em></em>
		  			</li>
		  			<li class="active">
		  				<span>
		  					<i>2</i>
		  					<b>安全验证</b>
		  				</span>
		  				<em></em>
		  			</li>
		  			<li>
		  				<span>
		  					<i>3</i>
		  					<b>安全验证</b>
		  				</span>
		  			</li>
		  		</ul>
		  		<form action="/user/User/setPassword" method="post">
		  		<div class="find_mm">
		  		    <label>
		  		    	<span><b>*</b>新密码：</span>
		  		    	<input type="text" name="password" id="" value="" />
		  		    	<p class="p1"></p>
		  		    </label>
		  		    <label>
		  		    	<span><b>*</b>确认密码：</span>
		  		    	<input type="text" name="password_cofirm" id="" value="" />
		  		    	<p class="p2"></p>
		  		    </label>
		  		    <input type="button" id="sub" value="验证" onclick="setPass();" class="verify" />
		  		</div>
		  		</form>
		  	</div>
		  </div>
		  
		<div class="footer">
		<p>Copyright © 2016爱依然纪念网. All Rights Reserved  </p>	
		</div>
	</body>
</html>
<script src="http://apps.bdimg.com/libs/jquery/1.7.2/jquery.js"></script>

<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>


<script>

    function ityzl_SHOW_LOAD_LAYER(){  
                return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    }  
    function ityzl_CLOSE_LOAD_LAYER(index){  
            layer.close(index);  
    }
    //验证邮箱验证码
    function setPass()
    {
        var password = $("input[name='password']").val();
        var password_cofirm = $("input[name='password_cofirm']").val();
        $.ajax({
                type: "Post",
                url: "/user/User/setPasswordd",
                data: {'password':password,'password_cofirm':password_cofirm},
                dataType: "json",
                beforeSend: function () {
                    i =ityzl_SHOW_LOAD_LAYER();
                },
                complete: function () {
                    ityzl_CLOSE_LOAD_LAYER(i);  
                },
                success: function(data) {
                    if (data.status == 1) {
                        $(".p2").html(data.msg);
                        setTimeout(function(){window.location="/user/User/find_password";},2000); 
                    }else if(data.status==2){
                        $(".p1").html(data.msg);
                    }else{
                        $(".p2").html(data.msg);
                    }
                }
        });

    }
</script>