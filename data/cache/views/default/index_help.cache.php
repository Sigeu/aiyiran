<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/help.css"/>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
<script type="text/javascript">
    $(function(){
//              $(".vtitle").hover(function(){
//                  $(this).addClass("active");
//              },function(){
//                  $(this).removeClass("active");
//              });
//


        //菜单隐藏展开
        // $(".menu_op_clo .vcon:first").show();
        // var tabs_i=0
        // $('.vtitle').click(function(){
        //     $(this).addClass("active").siblings().removeClass("active");
        //     var _self = $(this);
        //     var j = $('.vtitle').index(_self);
        //     if( tabs_i == j ) return false; tabs_i = j;
        //     $('.vtitle em').each(function(e){
        //         if(e==tabs_i){
        //             $('em',_self).removeClass('v01').addClass('v02');
        //         }else{
        //             $(this).removeClass('v02').addClass('v01');
        //         }
        //     });
        //     $('.vcon').slideUp().eq(tabs_i).slideDown();
        // });
    })
</script>
    
        <div class="box_cont_w clearfix">
          <div class="w_1200 clearfix">
            <div class="left_menu" style="height: 130px;">
                <h3>帮助中心</h3>
                <ul class="clearfix">
                    <li class="active"><a href="/category/Category/index/cid/281">-常见问题</a></li>
                    <!--<li><a href="###">-在线咨询</a></li>-->
                </ul>
            </div>
            <div class="right_cont">
                <h2 class="title_c">常见问题</h2>
                <div class="Search_box">
                <form action="" method="get">
                    <input type="text" name="keywords" id="" class="text_sr" value="<?php echo $keywords;?>" placeholder="请输入帮助中心的关键词，如微信支付功能" />
                    <input type="submit" id="" class="search_an" value="搜索" /> 
                    <p>热搜关键词：<a href="/category/Category/index/cid/281?keywords=纪念馆"><em>纪念馆</em></a>，
                    <a href="/category/Category/index/cid/281?keywords=如何登录" style="color:#999;">如何登录</a>，
                    <a href="/category/Category/index/cid/281?keywords=删除留言" style="color:#999;">删除留言</a>，
                    <a href="/category/Category/index/cid/281?keywords=支付流程" style="color:#999;">支付流程</a>
                </form>
                </div>
                <div class="menu_op_clo clearfix">
             <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$cid = $_GET["cid"];$cidinfo = cid2info($cid);$request_url = getPageUrl($cidinfo,"page");$count = $tag_obj -> lib_articlelist (array('cid'=>'281','keywords'=>$keywords,'cont'=>$keywords,'order'=>'sortnum desc','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 15*($currentPage-1);$url = $request_url;$pagesize = 15;$subpage = 10;$pagenum = count($count);$page = new Pages(15,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_articlelist (array('cid'=>'281','keywords'=>$keywords,'cont'=>$keywords,'order'=>'sortnum desc','return'=>'data','from'=>$from,'pagesize'=>'15',));?>
             <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <div class="vtitle"><a href="/category/Category/helpContent/id/<?php echo Template::addquote($value['id']);?>">·<?php echo csubstr($value["title"],25);?> </a></div>
             <?php $n++;} ?>
             <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$return = $tag_obj -> lib_articlelist (array());?>
             <div class="page">
                    <?php echo $pagestr;?>
            </div>
<!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>
                    
                </div>
            </div>
          </div>
        </div>
        
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
