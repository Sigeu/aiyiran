<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo Template::addquote($content['title']);?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/ly.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
        <script type="text/javascript">
            $(function(){
                // banner轮播
                var banSwiper = new Swiper('.left_ban .swiper-container',{
                    pagination: '.left_ban .swiper-container .pagination',
                    loop:true,
                    grabCursor: true,
                    paginationClickable: true,
                    autoplay : 7000,
                    speed:1000,
                    autoplayDisableOnInteraction: false
                  });
                  $('.left_ban .arrow-left').on('click', function(e){
                    e.preventDefault()
                    banSwiper.swipePrev();
                  });
                  $('.left_ban .arrow-right').on('click', function(e){
                    e.preventDefault()
                    banSwiper.swipeNext();
                  });
                  $(".left_ban").hover(function(){
                    banSwiper.stopAutoplay();
                  },function(){
                    banSwiper.startAutoplay();
                  });
            })
        </script>
    </head>
    <body>
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
        <div class="ly_top">
            <h2 class="ly_name"><?php echo Template::addquote($content['title']);?></h2>
            <div class="ly_nav">
                <div class="ly_nav_box">
                    <ul>
                    <li <?php if($isNav ==1) { ?> class="active" <?php } ?>><a href="/content/Content/cemetery/id/<?php echo Template::addquote($content['id']);?>">陵园首页</a></li>
                    <li <?php if($isNav ==2) { ?> class="active" <?php } ?>><a href="/content/Content/aboutCem/id/<?php echo Template::addquote($content['id']);?>/info/1">关于陵园</a></li>
                    <li <?php if($isNav ==3) { ?> class="active" <?php } ?>><a href="/content/Content/scenry/id/<?php echo Template::addquote($content['id']);?>">陵园景观</a></li>
                    <li <?php if($isNav ==4) { ?> class="active" <?php } ?>><a href="/content/Content/server/id/<?php echo Template::addquote($content['id']);?>">陵园服务</a></li>
                    <li <?php if($isNav ==5) { ?> class="active" <?php } ?>><a href="/content/Content/map/id/<?php echo Template::addquote($content['id']);?>">地理位置</a></li>
                    <li <?php if($isNav ==6) { ?> class="active" <?php } ?>><a href="/content/Content/information/id/<?php echo Template::addquote($content['id']);?>/info/1">陵园资讯</a></li>
                    <li><a href="/content/Content/index/id/566">客户服务</a></li>
                </ul>
                <a href="/category/Category/index/cid/321" class="return_sy">返回公墓陵园</a>
                </div>
            </div>
        </div>


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
        <script type="text/javascript">
            $('body').on('click', 'a', function(e) {
                e.target.target = '_blank';
            });
        </script>

