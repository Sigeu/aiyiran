<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>爱依然</title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/mausoleum.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/scenes.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/scence.js" ></script>
        <!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>
        <script type="text/javascript">
            $(function(){
                $(function(){
                $(".rep").each(function(){
                    $(this).click(function(){
                     $(this).parents().next().next().slideToggle(200);

                    });
                });
                $(".list_message ul li").hover(function(){
                    $(this).addClass("active");
                  },function(){
                    $(this).removeClass("active");
                  });
//              $(".list_message ul li:last").css("border","none")

            })
            })
        </script>
    </head>
    <body  class="memorial">
        <div class="box_top">
            <div class="box_top_cont">
                <ul class="fl">
                    <li><a href="/">网站首页</a></li>
                    <li><a href="javascript:setHomepage()" >设为首页</a></li>
                </ul>
                <ul class="fr">
                    <li><a href="/category/Category/index/cid/281">帮助中心</a></li>
                    <li><a href="/category/Category/index/cid/53">关于我们</a></li>
                    <li><a href="/member/Systeminfo/lists">消息</a></li>
                    <?php if($GLOBALS['username']) { ?>
                        <li class="user_name"><a href="/member/Index/index"><?php echo Template::addquote($GLOBALS['username']);?></a></li>
                    <?php } else { ?>
                        <li class="user_name"><a href="/user/Login/login2">登录</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="mausoleum clearfix">
            <div class="nav_x">
                 
              
            </div>

<script type="text/javascript">
    // 关注
    function caretomb(mid){

        $.ajax({
            type: "Post",
            url: "/jinian/Jinian/caretomb",
            data: {'mid':mid},
            dataType: "json",
            success: function(data) {
                if (data.status == 1) {
                   $(".addtimo").text('取消关注');
                   location.reload();
                } else {
                    isLogin();
                    return false;
                };
            }
        });
    }

    // 取消关注

    function clearcaretomb(mid){
        $.ajax({
            type: "Post",
            url: "/jinian/Jinian/clearcaretomb",
            data: {'mid':mid},
            dataType: "json",
            success: function(data) {
                if (data.status == 1) {
                   $(".addtimo").text('加入关注');
                   $("onclick").attr('clearcaretomb');
                   location.reload();
                } else {
                    isLogin();
                    return false;
                };
            }
        });
    }

</script>

<script type="text/javascript">
//设为主页
function setHomepage() {
if (document.all) {
   document.body.style.behavior = 'url(#default#homepage)';
   document.body.setHomePage('http://www.tsingming.com/');
} else if (window.sidebar) {
   if (window.netscape) {
       try {
           netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
       } catch (e) {
           alert("该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true");
       }
   }
   var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
   prefs.setCharPref('browser.startup.homepage', window.location.href);
} else {
   alert('您的浏览器不支持自动自动设置首页, 请使用浏览器菜单手动设置!');
}
}
</script>

            <?php if($bio==null) { ?>
            <div class="biography_details">
                <div class="details">
                    <div class="" style="width: 1200px; height: 100px; text-align: center; line-height: 100px;">
                        <h2 style="font-size: 14px;color: #666;"><?php echo $error;?><a href="/" style="color: #01d590;text-decoration: underline;">其他场馆</a> </h2>
                    </div>
                    <div class="details_cont">
                    </div>
                    <!-- <p class="return_sx"><em class="prov fl"><span>上一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em><em class="next fr"><span>下一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em></p>  -->
                   </div>

            </div>
            <?php } else { ?>
            <div class="biography_details">
                <div class="details">
                    <div class="top_title">
                        <!-- <a href="/jinian/Jinian/record/mid/<?php echo $mid;?>">返回传记列表页</a> -->
                        <h2><?php echo Template::addquote($bio['bioname']);?></h2>
                        <p><!-- 发布人：admin -->  阅读(<?php echo Template::addquote($bio['click_nums']);?>) │ 发布时间：<?php echo Template::addquote($bio['createtime']);?></p>
                    </div>
                    <div class="details_cont">
                            <?php echo Template::addquote($bio['biocontent']);?>
                    </div>
                    <!-- <p class="return_sx"><em class="prov fl"><span>上一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em><em class="next fr"><span>下一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em></p>  -->
                   </div>

            </div>
            <?php } ?>
        </div>
            <!--********footer***************************************-->
<?php include Template::t_include('inc/memorial_footer.html');?>
