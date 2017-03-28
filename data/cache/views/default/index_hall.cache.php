<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/index.css"/>
<script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/index.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
    
        <!--**********************************************************-->
        <div class="box_cont clearfix">
            <div class="family_name">
                <span class="title_xszc fl">
                    姓氏宗祠
                </span>
                <form action="" method="get">
                <div class="input_group fr">
                    <input id="searchMuseumkey" class="form-control fl" name="keywords" value="<?php echo $keywords;?>" placeholder="输入需要查找的内容" type="text">
                    <span><i></i><input type="submit"  id="" class="input-group-addon fl" value="搜索" /></span>
                </div>
                </form>
            </div>
            <div class="list_ancestral clearfix">
                <ul class="list_zc clearfix">
              <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$cid = $_GET["cid"];$cidinfo = cid2info($cid);$request_url = getPageUrl($cidinfo,"page");$count = $tag_obj -> lib_articlelist (array('cid'=>'314','keywords'=>$keywords,'order'=>'sortnum desc','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 9*($currentPage-1);$url = $request_url;$pagesize = 9;$subpage = 10;$pagenum = count($count);$page = new Pages(9,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_articlelist (array('cid'=>'314','keywords'=>$keywords,'order'=>'sortnum desc','return'=>'data','from'=>$from,'pagesize'=>'9',));?>
                <?php if(!empty($data)) { ?>
                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <li>
                        <img class="lazy" src='/template/default/member/images/default_max.png' data-original="/static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="250" height="250"/>
                        <h3><?php echo csubstr($value["title"],10);?></h3>
                        <p><?php echo csubstr($value["description"],95);?></p>
                        <span>建立时间：<?php echo substr(date('Y-m-d', $value['publishtime']),0,10);?></span>
                        <a href="<?php echo Template::addquote($value['url']);?>" target="_blank">查看宗祠</a>
                    </li>
                    <?php $n++;} ?>
                 <?php } else { ?>
                 没找到信息，稍后再试
                 <?php } ?>
              
                </ul>
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
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
