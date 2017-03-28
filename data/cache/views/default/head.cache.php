<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo Template::addquote($seo['title']);?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <script src='/template/default/js/jquery.1.7.2.js'></script>

    </head>
    <body>
        <div class="box_top">
            <div class="box_top_cont">
                <ul class="fl">
                    <li><a href="/">网站首页</a></li>
                    <li><a href="javascript:setHomepage()">设为首页</a></li>
                </ul>
                <ul class="fr">
                    <li><a href="/category/Category/index/cid/281">帮助中心</a></li>
                    <li><a href="/category/Category/index/cid/53">关于我们</a></li>
                    <?php if($GLOBALS['username']) { ?>
                    <li><a href="/member/Systeminfo/lists" target="_blank">消息</a></li>
                    <li class="user_name"><a href="/member/Index/index"><?php echo Template::addquote($GLOBALS['username']);?></a></li>
                    <?php } else { ?>
                        <li class="user_name"><a href="/user/Login/login2">登录</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="header">
            <div class="head_search">
                <a href="/" class="logo fl"><img src="<?php echo IMG_PATH;?>/logo_02.png"></a>
                <span class="dt_pic fl"><img src="<?php echo IMG_PATH;?>/logod.gif"/></span>
                <!-- <form action="/comment/comment/searchs" method="post"> -->
                <div class="search fl">
                    <div class="seleBox fl">
                        <p><?php if(isset($sel) && $sel==2) { ?>名人纪念馆<?php } else { ?>私人纪念馆<?php } ?></p><i class="jt_1"></i>
                        <ul class="sel_list">
                            <li data="1">私人纪念馆</li>
                            <li data="2">名人纪念馆</li>
                        </ul>
                    </div>
                    <input type="hidden" name="hiddens" value="1">
                    <input class="text_cont fl" type="text" id="kds" name="keywords" placeholder="请输入搜索内容" />
                    <input class="but_search fl" type="button" id="tijiao"  value="搜索" />
                    <p class="hot_seek fl"><span>热门搜索：</span>
                        <?php $tag_obj = Load::load_tag('memorial');if(!is_object($tag_obj)){halt('tag memorial is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memorial (array('catid'=>'2','field'=>'name','order'=>'click_num desc','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 5*($currentPage-1);$url = $request_url;$pagesize = 5;$subpage = 10;$pagenum = count($count);$page = new Pages(5,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memorial (array('catid'=>'2','field'=>'name','order'=>'click_num desc','return'=>'data','from'=>$from,'pagesize'=>'5',));?>
                        <?php $n=1;foreach($data AS $key => $val) { $lastIndex= count($data) == $n;?>
                        <a href="/search/Search/searchs2/sel/2/keywords/<?php echo Template::addquote($val['name']);?>"><?php echo Template::addquote($val['name']);?></a>
                        <?php $n++;} ?>
                        
                    </p>
                </div>
            <!-- </form> -->

<script type="text/javascript">
$(function(){
    var sel = 1;
    $(".sel_list li").click(function(){
     sel = $(this).attr('data');
    });
        $("#tijiao").click(function(){
            var keywords = $("#kds").val();
             window.location.href="/search/Search/searchs2/sel/"+sel+"/keywords/"+keywords;
        })
});

</script>

            </div>
            <div class="nav_box">
                <div class="nav">
                    <ul class="fl navUl_yc">
                        <li class="bgnav <?php if($cid==0) { ?>active1<?php } ?>"><a href="/" class="active">首页</a></li>
                        <?php $tag_obj = Load::load_tag('navigation');if(!is_object($tag_obj)){halt('tag navigation is exists!');};$return = $tag_obj -> lib_navigation (array('row'=>'9','type'=>'top','order'=>'ordernum asc',));?>
                            <?php $n=1;if(is_array($return)) foreach($return AS $v) { ?>
                                    <?php if($v['id']=='304') { ?>
                                    <li  class="bgnav <?php if($cid==305) { ?>active1<?php } ?>" ><a  href="<?php echo getMoreUrl(305);?>"><?php echo Template::addquote($v['catname']);?></a>
                                    <?php } else { ?>
                                    <li  class="bgnav <?php if($cid==$v['id']) { ?>active1<?php } ?>" ><a  href="<?php echo getMoreUrl($v['id']);?>"><?php echo Template::addquote($v['catname']);?></a>
                                    <?php } ?>
                                        <dl class="memNav_yc" style="display: none;">
                                        <?php $soncateTree = getCateTree($v['id'],1); ;?>
                                            <?php $n=1;foreach($soncateTree AS $sonk => $sonv) { $lastIndex= count($soncateTree) == $n;?>
                                                <?php if($sonv['id']=='312') { ?>
                                                <?php } elseif ($sonv['id']=='311') { ?>
                                                <?php } elseif ($sonv['id']=='310') { ?>
                                                <?php } elseif ($sonv['id']=='320') { ?>
                                                <?php } elseif ($sonv['id']=='319') { ?>
                                                <?php } elseif ($sonv['id']=='318') { ?>
                                                <?php } elseif ($sonv['id']=='317') { ?>
                                                <?php } elseif ($sonv['id']=='316') { ?>
                                                <?php } elseif ($sonv['id']=='329') { ?>
                                                <?php } elseif ($sonv['id']=='330') { ?>
                                                <?php } else { ?>
                                                <dd><a target="_blank" href="<?php echo getMoreUrl($sonv['id']);?>"><?php echo Template::addquote($sonv['catname']);?></a></dd>
                                                <?php } ?>
                                            <?php $n++;} ?>
                                        </dl>
                                    </li>
                            <?php $n++;} ?>
                        
                    </ul>
                    <span class="fl"><i></i>400-800-6666</span>
                </div>
            </div>
        </div>
<script type="text/javascript">
//设为主页
function setHomepage() {
if (document.all) {
   document.body.style.behavior = 'url(#default#homepage)';
   document.body.setHomePage('http://www.aiyiran.com/');
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


