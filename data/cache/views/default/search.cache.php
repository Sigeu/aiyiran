<?php if(!defined('IN_MAINONE')) exit(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/index.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/index.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>


<?php include Template::t_include('head.html');?>

<?php if(($sel==1)) { ?>           
             <div class="tab_cont clearfix">
                <div class="headline">
                <span class="fl">私人纪念馆 <i></i></span>
                <!--<a href="###" class="fr">查看更多<i></i></a>-->
                </div>
                <ul class="list_jn clearfix createData">
                    <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('catid'=>$sel,'keywords'=>$keywords,'return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 20*($currentPage-1);$url = $request_url;$pagesize = 20;$subpage = 10;$pagenum = count($count);$page = new Pages(20,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('catid'=>$sel,'keywords'=>$keywords,'return'=>'data','from'=>$from,'pagesize'=>'20',));?>

                    <?php if(is_array($data)) { ?>
                      <?php $n=1;foreach($data AS $key => $val) { $lastIndex= count($data) == $n;?>
                      <li>
                        <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($val['m_id']);?>" target="_blank">
                              <img src="<?php echo Template::addquote($val['userpic']);?>" />
                              <p class="clearfix"><span class="fl nameA"><?php echo Template::addquote($val['personname']);?></span><span  class="fr"><?php echo Template::addquote($val['persontype_name']);?></span></p>
                        </a>
                      </li>
                      <?php $n++;} ?>
                       <?php } else { ?>
                      没找到信息，请稍后再试
                      <?php } ?>
                    
                </ul>
                <div class="page">
                    <?php echo $pagestr;?>
                </div>
             </div>
<!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>

<?php include Template::t_include('inc/three_inc.html');?>

<!-- 名人纪念馆 -->
<?php } else { ?>
               <div class="tab_cont clearfix">
                <div class="headline">
                <span class="fl">名人纪念馆<i></i></span>
                <!--<a href="###" class="fr">查看更多<i></i></a>-->
                </div>
                <div class="hotP">
                            <ul class="clearfix createData">
                                <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('catid'=>$sel,'keywords'=>$keywords,'return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 20*($currentPage-1);$url = $request_url;$pagesize = 20;$subpage = 10;$pagenum = count($count);$page = new Pages(20,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('catid'=>$sel,'keywords'=>$keywords,'return'=>'data','from'=>$from,'pagesize'=>'20',));?>
                                <?php if(is_array($data)) { ?>
                                <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                <li>
                                    <div class="hotPImg">
                                        <img src="<?php echo Template::addquote($value['userpic']);?>">
                                    </div>
                                    <p class="clearfix hotP_p"><a href="###" class="fl nameA"><?php echo Template::addquote($value['personname']);?></a><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" target="_blank" class="fr quickJS">立即祭拜</a></p>
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
        <?php include Template::t_include('inc/three_inc.html');?>

        <?php } ?>


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
