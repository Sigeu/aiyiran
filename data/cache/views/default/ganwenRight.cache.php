<?php if(!defined('IN_MAINONE')) exit(); ?>
                <div class="fl conItem02 clearfix">
                    <div class="cont_list cont_list6">
                    <div class="headline">
                        <span class="fl">资讯热度排行<i></i></span>
                        <!-- <a href="" class="fr">参看更多<i></i></a> -->
                     </div>
                    <ul class="">
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'10','order'=>'hits desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                            <?php $key++; ?>
                            <?php if($key < 4) { ?>
                            <li class="active">
                            <em><?php echo $key;?></em>
                            <?php } else { ?>
                            <li class="">
                            <em><?php echo $key;?></em>
                            <?php } ?>
                            <a href="<?php echo Template::addquote($value['url']);?>"><?php echo csubstr($value["title"],23);?></a>
                        </li>
                        <?php $n++;} ?>
                        
                    </ul>
                </div>
                <a href="###" class="double_j"><img src="<?php echo IMG_PATH;?>/jw_12.jpg" /></a>
                <div class="cont_list cont_list7">
                    <div class="headline">
                        <span class="fl">资讯推荐<i></i></span>
                        <!-- <a href="###" class="fr">参看更多<i></i></a> -->
                     </div>
                    <ul class="">
                    <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'10','order'=>'hits desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <li class="active">
                            <a href="<?php echo Template::addquote($value['url']);?>"><?php echo csubstr($value["title"],24);?></a>
                        </li>

                        <?php $n++;} ?>
                    
                    </ul>
                </div>
                <div class="cont_list cont_list6">
                    <div class="headline">
                        <span class="fl">纪念馆访问排行<i></i></span>
                        <!--<a href="###" class="fr">参看更多<i></i></a>-->
                     </div>
                    <ul class="">

                    <?php $tag_obj = Load::load_tag('memorial');if(!is_object($tag_obj)){halt('tag memorial is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memorial (array('dearrank'=>'1','field'=>'id,personname','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 10*($currentPage-1);$url = $request_url;$pagesize = 10;$subpage = 10;$pagenum = count($count);$page = new Pages(10,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memorial (array('dearrank'=>'1','field'=>'id,personname','return'=>'data','from'=>$from,'pagesize'=>'10',));?>
                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <?php $key++; ?>
                        <?php if($key < 4) { ?>
                        <li class="active">
                            <em><?php echo $key;?></em>
                        <?php } else { ?>
                        <li class="">
                            <em><?php echo $key;?></em>
                        <?php } ?>
                            <a href=""><?php echo Template::addquote($value['personname']);?> </a>
                        </li>

                    <?php $n++;} ?>
                    
                    </ul>
                </div>
                <a href="###" class="data_918"><img src="<?php echo IMG_PATH;?>/jw_30.jpg" /></a>
                </div>