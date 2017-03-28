<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>登录</title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/login.css"/>
    </head>
    <body>
        <div class="login_top">
            <div class="login_cont">
                <a href="/" class="logo fl"><img src="<?php echo IMG_PATH;?>/login_02.jpg"/></a>
                <span class=" fl">欢迎登陆</span>
                <a href="/" class="return_sy fr">返回首页</a>
            </div>
        </div>
        <div class="login">
            <div class="login_r">
                        <h3>账号登录</h3>
                        <div class="inp_text user_name" style="margin-bottom: 0px;">
                        <?php if($_SESSION['saveName']) { ?>
                            <input type="text" name="username" id="username" value="<?php echo Template::addquote($_SESSION['saveName']);?>"/>
                        <?php } else { ?>
                            <input type="text" name="username" id="username" placeholder="请输入用户名"/>
                        <?php } ?>

                            <span><i></i></span>
                        </div>
                        <p class="error_tips p1" style=" display: block;"></p>
                        <div class="inp_text pass_word" style="margin-bottom: 0px;">
                            <input type="password" name="password" id="password" value="" placeholder="请输入密码" />
                            <span><i></i></span>
                        </div>
                        <p class="error_tips p2" style=" display: block;"></p>
                        <div class="remember">
                            <span class="fl rem_user_n">
                                <input type="checkbox" name="saveName" value="1" id="female" /><label for="female">记住用户名</label></span>
                            <span class="fr">
                            <a href="/user/User/restPassword">忘记密码</a>
                            <em>|</em>
                            <a href="/user/User/register/groupid/24">免费注册</a>
                            </span>
                        </div>
                        <input type="button" onclick="login();" id="" value="立即登录" class="must_login" />
                        <div class="therr_dl">
                            <a href="###" class="qq_dl"></a>
                            <a href="###" class="wb_dl"></a>
                            <a href="###" class="wx_dl"></a>
                        </div>
                    </div>
        </div>
        <div class="footer">
        <p>Copyright © 2016爱依然纪念网. All Rights Reserved  </p>
        </div>
    </body>
</html>
<script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>

<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>

<script>
$(function(){
    if($("input[name='username']").val()=="请输入用户名"){
        alert(1);
    }
});

$(function () {
    $("body").keydown(function() {
        if (event.keyCode == "13") {//keyCode=13是回车键
            login();
        }
    });
})

    function ityzl_SHOW_LOAD_LAYER(){
                return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    }
    function ityzl_CLOSE_LOAD_LAYER(index){
            layer.close(index);
    }

    function login()
    {
        var password = $("input[name='password']").val();
        var username = $("input[name='username']").val();
        var saveName = $('input[name="saveName"]:checked').val();


        //初始化
        $(".p1").html('');
        $(".p2").html('');
        if(username==""){
            $(".p1").html('用户名不能为空');
            $("#username").focus();
            return false;
        }
         if(password==""){
            $(".p2").html('密码不能为空');
            $("#password").focus();
            return false;
        }
        $.ajax({
                type: "Post",
                url: "/user/Login/login2",
                data: {'password':password,'username':username, 'saveName':saveName},
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
                        setTimeout(function(){window.location="/";},1000);
                    }else{
                        $(".p2").html(data.msg);
                        return false;
                    }
                }
        });

    }
</script>
