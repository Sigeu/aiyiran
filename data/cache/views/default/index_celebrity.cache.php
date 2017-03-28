<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/index.css"/>
<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/index.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
        <style>
            .createData li:hover{border: solid #01d590 1px;}
        </style>
        <div class="box_cont clearfix">
            <div class="indexBanner">
              <div class="fl conItem01">
                <div class="section01">
                        <!--banner轮播-->
                            <?php include Template::t_include('inc/lbt.html');?>
                    </div>
              </div>
              <div class="fr conItem02">
                 <div class="cont_list cont_list4">
                    <div class="headline">
                        <span class="fl">最新记录<i></i></span>
                        <!--<a href="###" class="fr">参看更多<i></i></a>-->
                     </div>
                    <ul class="">
                     <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'10','cid'=>'315','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <li>
                            <a href="<?php echo Template::addquote($value['id']);?>"><?php echo msubstr($value["title"],0,19,'utf-8');?></a>
                            <span><?php echo wordTime($value["publishtime"]);?></span>
                        </li>
                           <?php $n++;} ?>
                    
                    </ul>

                </div>
                  <?php include Template::t_include('inc/inc_create.html');?>
              </div>
             </div>
             <div class="Search_box">
                <div class="SearchMuseum">
                      <form action="" method="get">
                        <div class="input_group">
                            <input id="searchMuseumkey" class="form-control fl" name="keywords" placeholder="输入需要查找的内容" type="text" value="<?php echo $keywords;?>">
                            <span><i></i><input type="button" onclick="sousuos(2);"   class="input-group-addon fl" value="搜索" /></span>
                        </div>
                      </form>
                        <p class="as_per">按字母搜索：</p>
                        <ul class="rank">
                            <?php $n=1;if(is_array($zimu)) foreach($zimu AS $v) { ?>
                            <li><a href="javascript:;" onclick="sousuos2('<?php echo $v;?>', 2, 2);"><?php echo $v;?></a></li>
                            <?php $n++;} ?>
                        </ul>
                    </div>
             </div>
             <div class="tab_cont clearfix">
                <div class="headline">
                <span class="fl">名人纪念馆<i></i></span>
                <!--<a href="###" class="fr">查看更多<i></i></a>-->
                </div>
                <div class="hotP">
                            <ul class="clearfix createData">
                                <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('catid'=>'2','letter'=>$letter,'keywords'=>$keywords,'return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 20*($currentPage-1);$url = $request_url;$pagesize = 20;$subpage = 10;$pagenum = count($count);$page = new Pages(20,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('catid'=>'2','letter'=>$letter,'keywords'=>$keywords,'return'=>'data','from'=>$from,'pagesize'=>'20',));?>
                                <?php if(is_array($data)) { ?>
                                <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                <li>
                                    <div class="hotPImg">
                                        <img src="<?php echo Template::addquote($value['userpic']);?>" width="214" height="214">
                                    </div>
                                    <p class="clearfix hotP_p"><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" class="fl nameA"><?php echo Template::addquote($value['personname']);?></a><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" class="fr quickJS" target="_blank">立即祭拜</a></p>
                                    <div class="mainP">
                                        <p>享年：<span><?php echo Template::addquote($value['m_year']);?>-<?php echo Template::addquote($value['d_year']);?></span></p>
                                        <p class="introP">简介：<span><?php echo csubstr($value['descript'],35);?></span></p>
                                    </div>
                                </li>
                                <?php $n++;} ?>
                                 <?php } else { ?>
                                没找到信息，请稍后再试
                                <?php } ?>
                                

                            </ul>
                        </div>
                <!--<div class="page">-->
                    <!--<?php echo $pagestr;?>-->
                <!--</div>-->
<!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>
             </div>

             <div class="link_exchange">
                <span>友情链接：</span><a href="###">中国民政部</a>
                <?php $tag_obj = Load::load_tag('friendlink');if(!is_object($tag_obj)){halt('tag friendlink is exists!');};$data = $tag_obj -> lib_friendlink (array('row'=>'100','return'=>'data',));?>
                  <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <a href='<?php echo Template::addquote($value["com_url"]);?>'><?php echo Template::addquote($value["name"]);?></a>
                  <?php $n++;} ?>
                
            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
