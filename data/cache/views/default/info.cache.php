<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="css/public.css"/>
        <link rel="stylesheet" type="text/css" href="css/ly.css"/>
        <script type="text/javascript" src="js/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript">
            $(function(){
                $(".left_menu ul li:last").css("border","none")
            })
        </script>
<?php include Template::t_include('cemetery/head_cemetery.html');?>

        <!--********************************************-->
        <div class="box_cont_w clearfix">
            <div class="w_1200 clearfix">
                <div class="left_menu clearfix">
                    <h3>陵园资讯</h3>
                    <ul class="clearfix">
                        <li <?php if($info==1) { ?>class="active"<?php } ?>><a href="/content/Content/information/id/40/info/1">-购墓须知</a></li>
                        <li <?php if($info==2) { ?>class="active"<?php } ?>><a href="/content/Content/information/id/40/info/2">-陵园通告</a></li>
                    </ul>
                </div>
                <div class="right_cont">
                <?php if($info==1) { ?>
                    <ul class="lyzx_list clearfix">
                <?php $tag_obj = Load::load_tag('cemeinfo');if(!is_object($tag_obj)){halt('tag cemeinfo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_cemeinfo (array('cemeid'=>$id,'categoryid'=>'329','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 8*($currentPage-1);$url = $request_url;$pagesize = 8;$subpage = 10;$pagenum = count($count);$page = new Pages(8,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_cemeinfo (array('cemeid'=>$id,'categoryid'=>'329','return'=>'data','from'=>$from,'pagesize'=>'8',));?>
                        <?php if(!empty($data)) { ?>
                        <?php $n=1;foreach($data AS $key => $v) { $lastIndex= count($data) == $n;?>
                        <li><a href="/content/Content/index/id/<?php echo Template::addquote($v['id']);?>">· <?php echo Template::addquote($v['title']);?></a><span><?php echo date('Y-m-d',$v["publishtime"]);?></span></li>
                         <?php $n++;} ?>
                        <?php } else { ?>
                            没找到信息，稍后再试
                        <?php } ?>
                
                    </ul>
                <?php } else { ?>
                    <ul class="lyzx_list clearfix">
                    <?php $tag_obj = Load::load_tag('cemeinfo');if(!is_object($tag_obj)){halt('tag cemeinfo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_cemeinfo (array('cemeid'=>$id,'categoryid'=>'330','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 8*($currentPage-1);$url = $request_url;$pagesize = 8;$subpage = 10;$pagenum = count($count);$page = new Pages(8,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_cemeinfo (array('cemeid'=>$id,'categoryid'=>'330','return'=>'data','from'=>$from,'pagesize'=>'8',));?>
                            <?php if(!empty($data)) { ?>
                            <?php $n=1;foreach($data AS $key => $v) { $lastIndex= count($data) == $n;?>
                            <li><a href="/content/Content/index/id/<?php echo Template::addquote($v['id']);?>">· <?php echo Template::addquote($v['title']);?></a><span><?php echo date('Y-m-d',$v["publishtime"]);?></span></li>
                             <?php $n++;} ?>
                            <?php } else { ?>
                                没找到信息，稍后再试
                            <?php } ?>
                    
                        </ul>
                <?php } ?>
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

        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
