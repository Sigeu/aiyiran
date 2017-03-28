<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>注册</title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/login2.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/commond.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery.validate.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/validate_email_phone.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/Register.js"></script>
        <link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>

        <!-- layer插件 -->
        <link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
        <script src="/template/default/member/layer/layer.js"></script>


    </head>
    <body>
        <div class="login_top">
            <div class="login_cont">
                <a href="/" class="logo fl"><img src="<?php echo IMG_PATH;?>/login_02.jpg"/></a>
                <span class=" fl">欢迎注册</span>
                <a href="/" class="return_sy fr">返回首页</a>
            </div>
        </div>
        <div class="login">
            <form id="formRegister" onsubmit="return false" action="/Account/Register" novalidate="novalidate">
            <div class="login_r register clearfix">
                        <h3>账号注册</h3>
                        <div class="inp_text user_name">
                            <span><i></i></span>
                            <input type="text" name="UserNo" id="errouname" value="" placeholder="手机/邮箱" />
                            
                        </div>
                        <!--<p class="error_tips" style=" display: none;">用户名错误</p>-->
                        <div class="inp_text  pass_word">
                            <span><i></i></span>
                            <input type="password" name="UserPassword" id="password" value="" placeholder="请输入密码" />
                            
                        </div>
                        <!-- <p class="error_tips" style=" display: block;">用户名错误</p> -->
                        <div class="inp_text  pass_word">
                            <span><i></i></span>
                            <input type="password" name="confirm_password" id="" value="" equalTo="#password" placeholder="确认密码" />
                            
                        </div>
                        <!--<p class="error_tips" style=" display: none;">用户名错误</p>-->
                        <div class="inp_text code">
                            <!--<input type="text" class="code_text" name="VerifyCode" id="" value="" placeholder="请输入验证码" />
                            <input type="text" class="code_but" name="" id="" value="获取验证码" />
                            <a href="###" class="code_but">获取验证码</a>-->
                                    <input name="VerifyCode" class="code_text" type="text" placeholder="验证码" />
                            <img src="/user/User/getCode2" alt="" id="yzm" >
                            <a id="changeVerifyCode" onclick="huan()" href="javascript:;"> 换一张</a>
                            <div class="iphone-but"><a href="javascript:RegisterSendMesCode()">发送手机验证码</a></div>
                        </div>
                        <p class="error_tips" style=" display: none;">用户名错误</p>
                        <div class="remember">
                            <span class="fl rem_user_n"><input type="checkbox" checked="" name="" id=""/>我已阅读并接受<a href="###">《爱依然用户协议》</a></span>
                            <span class="fr">
                            <a href="/user/Login/login2">立即登录</a>
                            </span>
                        </div>

                        <input type="hidden" class="pwd"  name='dosubmit' value="1"/>
                        <input type="hidden" class="groupid"  name='groupid' value="<?php echo $groupid;?>"/>

                        <button class="must_login" id="btnRegister" type="submit" onclick="Register()">立即注册</button>
                    </div>  
                    <input name="__RequestVerificationToken" value="" type="hidden">
                <input name="Emailormobile" value="email" type="hidden">
            </form>
        </div>
        <div class="footer">
        <p>Copyright © 2016爱依然纪念网. All Rights Reserved  </p>    
        </div>
    </body>
</html>

<script type="text/javascript">
    function huan() {
        var time = new Date().getTime();//当前时间
        $('#yzm').attr("src" , "/user/User/getCode2?t=" + time);//验证码切换
    }

    //清空手机号显示的错误信息
    $('#errouname').bind('input propertychange', function() {searchProductClassbyName();}); 
    function searchProductClassbyName()
    {
     $(".erroun").remove();
    }

</script>

<div class="show_log" style="display: none;">
    <div class="bg_yc02" style="display:block;"></div>
    <div class="bgBox" style="display:block;"></div>
    <div class="handleB" style="display:block;">
        <div class="handTop">
            <span class="handS">操作成功</span><em class="handEm"></em>
        </div>
        <div class="handBot">
            <span class="spanStyle"></span>
            <p class="handP">注册成功，请去邮箱激活账号</p>
            <em class="closeEm">（4秒后自动跳转到首页）</em>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $(".handEm").click(function(){
                $(".bg_yc02,.bgBox,.handleB").hide();
            });
        });
    </script>
</div>

<div class="show_phone" style="display: none;">
    <div class="bg_yc02" style="display:block;"></div>
    <div class="bgBox" style="display:block;"></div>
    <div class="handleB" style="display:block;">
        <div class="handTop">
            <span class="handS">操作成功</span><em class="handEm"></em>
        </div>
        <div class="handBot">
            <span class="spanStyle"></span>
            <p class="handP">手机号码注册成功</p>
            <em class="closeEm">（4秒后自动跳转到首页）</em>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $(".handEm").click(function(){
                $(".bg_yc02,.bgBox,.handleB").hide();
            });
        });
    </script>
</div>
