<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo Template::addquote($info['name']);?>纪念馆</title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/mausoleum.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/scenes.css"/>
        <script src='/template/default/js/jquery.1.7.2.js'></script>
        <!--<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.7.2/jquery.min.js" ></script>-->
        <script src="/template/default/js/jquery.qqFace.js"></script>

        <script type="text/javascript" src="<?php echo JS_PATH;?>/scence.js" ></script>
        <!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>
        <script type="text/javascript">
            $(function(){
                $(function(){
                $(".rep").each(function(){
                    var _this = this;
                    $(this).click(function(){
                     $(this).parents().next().next().slideToggle(200);

                    });
                    //关闭回复框
                    $(this).parents().next().next().find('.cancelinfo').click(function(){
                        $(_this).trigger("click");
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

            /*关闭留言*/
            function outRep()
            {
               $(this).parent('.form-control').hide();
            }
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
                    <?php if($GLOBALS['username']) { ?>
                    <li><a href="/member/Systeminfo/lists">消息</a></li>
                    <li class="user_name"><a href="/member/Index/index"><?php echo Template::addquote($GLOBALS['username']);?></a></li>
                    <?php } else { ?>
                        <li class="user_name"><a href="/user/Login/login2">登录</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="mausoleum clearfix">
            <div class="nav_x">
                 <div class="nav_xcont">
                    <div class="user_hall fl" id="aCare" mid="<?php echo Template::addquote($info['id']);?>">
                        <h3><span><?php echo Template::addquote($info['name']);?></span><em>（馆号：<?php echo Template::addquote($info['id']);?>）</em></h3>
                        <p>http://www.aiyiran.com/jinian/Jinian/index/mid/<?php echo Template::addquote($info['id']);?></p>
                        <?php if($guanzhu) { ?>
                            <a href="javascript:;" onclick="clearcaretomb(<?php echo $mid;?>)" class="addtimo">取消关注</a>
                        <?php } else { ?>
                            <a href="javascript:;" onclick="caretomb(<?php echo $mid;?>)" class="addtimo">加入关注</a>
                        <?php } ?>
                    </div>
                    <div class="share_box fr">
                        <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_kaixin001" data-cmd="kaixin001" title="分享到开心网"></a></div>
                        <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":["mshare","qzone","weixin","tqq","kaixin001","tqf","tieba","douban","bdhome","sqq","thx","meilishuo","mogujie"],"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                    </div>
                 </div>
                 <div class="nav_small">
                    <ul>
                        <li <?php if($isNav==1) { ?> class="active" <?php } ?> ><a href="/jinian/Jinian/index/mid/<?php echo $mid;?>">首页</a></li>
                        <li <?php if($isNav==2) { ?> class="active" <?php } ?> ><a href="/jinian/Jinian/intro/mid/<?php echo $mid;?>">故人简介</a></li>
                        <li <?php if($isNav==3) { ?> class="active" <?php } ?> ><a href="/jinian/Jinian/recordConn/mid/<?php echo $mid;?>">传    记 </a></li>
                        <!-- <li><a href="">祭文悼词</a></li> -->
                        <li <?php if($isNav==4) { ?> class="active" <?php } ?> ><a href="/jinian/Jinian/albumLists/mid/<?php echo $mid;?>">视频相册</a></li>
                        <li <?php if($isNav==5) { ?> class="active" <?php } ?> ><a href="/jinian/Jinian/funeral/mid/<?php echo $mid;?>">纪念祭文</a></li>
                        <li <?php if($isNav==6) { ?> class="active" <?php } ?> ><a href="/jinian/Jinian/worship/mid/<?php echo $mid;?>">祭拜记录</a></li>
                        <li <?php if($isNav==7) { ?> class="active" <?php } ?> ><a href="/jinian/Jinian/comment/mid/<?php echo $mid;?>">追思留言</a></li>
                    </ul>
                 </div>
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
