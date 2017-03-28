<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/jw.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
<?php include Template::t_include('head.html');?>

        <!--*****************************************************-->
        <div class="box_cont clearfix">
            <div class="w_1200 clearfix">
                <div class="fl conItem01 clearfix">
                    <div class="list_word4">
                        <div class="headline">
                        <span class="fl"><?php echo cid2name($cid);?><i></i></span>
                        <!-- <a href="<?php echo worldge($cid);?>" class="fr">查看更多<i></i></a> -->
                        </div>
                        <ul class="clearfix">
                            <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$cid = $_GET["cid"];$cidinfo = cid2info($cid);$request_url = getPageUrl($cidinfo,"page");$count = $tag_obj -> lib_articlelist (array('row'=>'15','cid'=>$cid,'order'=>'sortnum desc','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 15*($currentPage-1);$url = $request_url;$pagesize = 15;$subpage = 10;$pagenum = count($count);$page = new Pages(15,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_articlelist (array('row'=>'15','cid'=>$cid,'order'=>'sortnum desc','return'=>'data','from'=>$from,'pagesize'=>'15',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                            <li>
                                <a href="<?php echo Template::addquote($value['url']);?>">
                                    <img src="/static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" />
                                    <h3><?php echo csubstr($value["title"],27);?></h3>
                                    <p><?php echo csubstr($value["description"],100);?></p>
                                </a>
                            </li>
                            <?php $n++;} ?>
                            
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
            <?php include Template::t_include('inc/ganwenRight.html');?>

            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('footer.html');?>
