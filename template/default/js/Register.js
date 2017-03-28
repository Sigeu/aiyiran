var isSendSMS = false; //是否已经发送过手机验证码

$(function () {
    $(".erroun").hide();
    $("#formRegister").validate({
        rules: {
            UserNo: {
                required: true,
            },
            UserPassword: {
                required: true,
                minlength: 5
            },
            VerifyCode: "required"
        },
        messages: {
            UserNo: {
                required: "请填写有效的手机号/邮箱"
            },
            UserPassword: {
                required: "请输入密码",
                minlength: "你输入密码小于6位"
            },
            VerifyCode: "验证码不能为空"
        }
    });
  $.extend($.validator.messages, {
//	required: '必填',
    equalTo: "请再次输入相同的值"
});  
    
    

//  if ($("[name=isActive]").val()) {
//      $("#register1").hide();
//      $("#register2").hide();
//      $("#register3").hide();
//      $("#register4").show();
//  }

//  Event.ChangeVerifyCode("valiCode");
    $("#changeVerifyCode").click(function () {  //换验证码
        $("#valiCode").attr("src", "/Shared/VerifyCode?time=" + (new Date()).getTime());
    })

    $(".reg-left").mousemove(function () {
        isMobileOrEmail();
    })
    $("[name=UserNo]").keyup(function () {
        isMobileOrEmail();
    });
       $(".must_login").click(function(){
    	$(".code").toggleClass("code2")
    })
    
})
function isMobileOrEmail() {
    if ((ValidateMobile($.trim($("[name=UserNo]").val())))) {
        $("[name=UserNo]").rules("remove");
        $("[name=UserNo]").rules("add", {
            required: true,
            isPhone: true
        });
        isSendSMS = true;
        $(".iphone-but").show();
        $("#SendVerifyCode > p").html("短信验证码");
        $("[name=Emailormobile]").val('mobile');
        if (!isSendSMS) { $("#SendSMSCodeVerify").show(); }
        return;
    }
    else {
        $("[name=UserNo]").rules("remove");
        $("[name=UserNo]").rules("add", {
            required: true,
            isEmail: true
        });
        $("#SendVerifyCode > p").html("验证码");
        $(".iphone-but").hide();
    }
    if (CheckEmail($.trim($("[name=UserNo]").val()))) {
        $("[name=Emailormobile]").val('email');
    }
}
//注册
function Register() {
    var form=$("#formRegister");
    $(".codde").remove();
    $(".erroun").remove();
    if (form.valid()) {
        $.ajax({
            type: "post",
            url: "/user/User/regist",
            data: form.serialize(),
            success: function (data) {
                var data = eval("("+data+")"); //包数据解析为json 格
                if(data.status==1){
                    $("<label class='codde'>"+data.msg+"</label>").insertAfter(".code_text");
                }
                if(data.status==2){
                    $("<label class='erroun'>"+data.msg+"</label>").insertAfter("#errouname");
                }
                if(data.status==3){
                    // $(".show_log").show();
                    // setTimeout(function(){
                    //     $(".show_log").hide();
                    //     window.location.href='/';
                    // }, 2000);
                    window.location.href="/user/User/successgo";

                }
                if(data.status==5){
                    // $(".show_phone").show();
                    // setTimeout(function(){
                    //     $(".show_phone").hide();
                    //     window.location.href='/';
                    // }, 2000);
                    window.location.href="/user/User/successgo";
                }
            }
        })
    }
}

//表单成功后执行
//function DataUpdateds(data) {
//  if (data.IsSuccess) {
//      $("[name=txtVerifyCode]").val("");
//      $("#valiCode").click();
//      $("#register1").hide();
//      $("#userno2").html($.trim($("[name=UserNo]").val()));
//      if (CheckEmail($.trim($("[name=UserNo]").val()))) { $("#register2").show(); }
//      if (ValidateMobile($.trim($("[name=UserNo]").val()))) {
//          $("#register3").show();
//          $("#userno3").html($.trim($("[name=UserNo]").val()));
//          $("#password3").html($.trim($("[name=UserPassword]").val()));
//      }
//  }
//  else {
//      if (data.Message == "userno") { $(".tishi-wz").show(); } else {
//          new $.Zebra_Dialog(data.Message, { 'type': 'error', 'title': '失败' });
//      }
//  }
//}


//注册发送手机验证码
function RegisterSendMesCode() {
    $(".erroun").remove();
    var mobile = $("#errouname").val();
         $.ajax({
               type: "Post",
               url: "/user/User/isPhone",
               contentType:'application/x-www-form-urlencoded; charset=UTF-8',
               data: {"mobile":mobile},
               dataType: "json",
               async:true,
               success: function(data) {
                   if (data.status == 1) {
                    layer.alert('发送成功，请注意查收');
                   } 
                   if (data.status == 2) {
                    $("<label class='erroun'>"+data.msg+"</label>").insertAfter("#errouname");
                   } 
               }
        });
}

//倒计时
var countdown = 60;
function settime(val) {
    if (countdown == 0) {
        $(".iphone-but > a").html("发送手机验证码");
        $(".iphone-but > a").attr("href", "javascript:CheckMesCode()");
        countdown = 60; return false;
    } else {
        $(".iphone-but > a").attr("href", "javascript:void(0)");
        $(".iphone-but > a").css("backgroundColor", "silver")
        $(".iphone-but > a").html("重新发送(" + countdown + ")");
        countdown--;
    }
    setTimeout(function () {
        settime(val)
    }, 1000);
}

//进入邮箱
//function LoginYourEmail() {
//  var UserNo = $("[name=UserNo]").val();
//  var mail_last = UserNo.substring(UserNo.indexOf('@') + 1, UserNo.lenght);
//  var url = "https://www.baidu.com/s?wd=" + mail_last + "邮箱";
//  window.open(url);
//}

//重新发送邮件
//function ResendEmail() {
//  var UserNo = $("[name=UserNo]").val();
//  $.ajax({
//      type: "get",
//      url: "/Account/ResendEmail",
//      beforeSend: function () {
//          $("#mainContent").html("正在加载...");
//      },
//      data: {
//          "UserNo": UserNo
//      },
//      success: function (data) {
//          if (data.IsSuccess) {
//              alert("我们已重新发送邮件，请及时查收");
//          }
//          else {
//              alert(eval(data)[0].Message);
//          }
//      },
//      complete: function () {
//          //alert("我们已重新发送邮件，请及时查收");
//      },
//      error: function (XMLHttpRequest, textStatus, errorThrown) {
//          alert("邮件发送错误。错误代码：" + XMLHttpRequest.status);
//      }
//  })
//}