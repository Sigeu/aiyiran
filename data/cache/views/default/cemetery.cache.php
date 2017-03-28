<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('cemetery/head_cemetery.html');?>
        <!--********************************************-->
        <div class="box_cont_w clearfix">
        <div class="banner_into">
            <div class="left_ban">
              <div class="swiper-container">
                    <div class="swiper-wrapper">
                    <?php $n=1;foreach($lbt AS $k => $v) { $lastIndex= count($lbt) == $n;?>
                        <div class="swiper-slide">
                            <img src="/static/uploadfile<?php echo Template::addquote($v['photo_url']);?>">
                        </div>
                  <?php $n++;} ?>
                    </div>
                    <div class="pagination"></div>
                    <div class="arrow-right"><i>&gt;</i></div>
                    <div class="arrow-left"><i>&lt;</i></div>
               </div>
            </div>
            
                <div class="right_into">
                    <h2><?php echo Template::addquote($content['title']);?></h2>
                    <p><?php echo Template::addquote($content['summary']);?></p>
                    <h3>陵园地址</h3>
                    <p>地址: <?php echo Template::addquote($content['address']);?></p>
                    <h3>联系电话</h3>
                    <p>联系电话: <?php echo Template::addquote($content['tel']);?></p>
               </div>       
        </div>
        <div class="tab_cont clearfix">
            <div class="headline">
            <span class="fl">陵园名人<i></i></span>
            <!--<a href="###" class="fr">查看更多<i></i></a>-->
            </div>
            <div class="hotP">
                <ul class="clearfix">
              <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('catid'=>'1','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 5*($currentPage-1);$url = $request_url;$pagesize = 5;$subpage = 10;$pagenum = count($count);$page = new Pages(5,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('catid'=>'1','return'=>'data','from'=>$from,'pagesize'=>'5',));?>
                <?php $n=1;foreach($HallMan AS $key => $value) { $lastIndex= count($HallMan) == $n;?>
                    <li>
                        <div class="hotPImg">
                            <img src="<?php echo Template::addquote($value['userpic']);?>">
                        </div>
                        <p class="clearfix hotP_p"><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['mid']);?>" target="_blank" class="fl nameA"><?php echo Template::addquote($value['name']);?></a><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['mid']);?>" target="_blank" class="fr quickJS">立即祭拜</a></p>
                        <div class="mainP">
                            <p>享年：<span><?php echo substr(date('Y-m-d', $value['brithdate']),0,4);?>-<?php echo substr(date('Y-m-d', $value['dieddate']),0,4);?></span></p>
                            <p class="introP">简介：<span>（<?php echo date('Y-m-d', $value['brithdate']);?>），<?php echo mb_substr($value['descript'],0,25,'utf-8');?></span></p>
                        </div>
                    </li>
              <?php $n++;} ?>
              
                    </ul>
            </div>
        </div>
        <!-- 公用 star-->
       <div class="three_list">
                <div class="cont_list">
                    <div class="headline">
                        <span class="fl">最新加入<i></i></span>
                        <!--<a href="###" class="jion fr">申请加入</a>-->
                     </div>
                    <ul class="">
              <?php $tag_obj = Load::load_tag('park');if(!is_object($tag_obj)){halt('tag park is exists!');};$data = $tag_obj -> lib_park (array('row'=>'8','return'=>'data',));?>
              <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <li>
                            <a href="###"><?php echo Template::addquote($value['title']);?> </a>
                            <span><?php echo substr($value['addtiem'],0,10);?></span>
                        </li>
              <?php $n++;} ?>
                  
                    </ul>
                </div>
                <div class="cont_list cont_list5">
                    <div class="headline">
                        <span class="fl">热度行榜<i></i></span>
                        <!-- <a href="###" class="fr">参看更多<i></i></a> -->
                     </div>
                    <ul class="">
             <?php $tag_obj = Load::load_tag('park');if(!is_object($tag_obj)){halt('tag park is exists!');};$data = $tag_obj -> lib_park (array('row'=>'8','order'=>'click_nums DESC','return'=>'data',));?>
              <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <?php $key++; ?>
                        <?php if($key < 4) { ?>
                        <li class="active">
                            <em><?php echo $key;?></em>
                        <?php } else { ?>
                        <li class="">
                            <em><?php echo $key;?></em>
                        <?php } ?>
                            <a href="###"><?php echo Template::addquote($value['title']);?> </a>
                            <span>浏览：<?php echo Template::addquote($value['click_nums']);?> </span>
                        </li>
              <?php $n++;} ?>
                         
                    </ul>
                </div>
                <div class="cont_list cont_list3">
                    <div class="headline">
                        <span class="fl">购墓须知<i></i></span>
                     </div>
                     <div class="tell_you">
                     <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'3','cid'=>'329','return'=>'data',));?>
                     <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <a href="<?php echo Template::addquote($value['url']);?>">
                        <h3><?php echo csubstr($value["title"],24);?></h3>
                        <p><?php echo csubstr($value["description"],47);?></p>
                        </a>
                    <?php $n++;} ?>
                    
                     </div>
                </div>
            </div>
        <!-- 公用 end-->

        <div class="link_exchange">
                <span>友情链接：</span>
                <?php $tag_obj = Load::load_tag('friendlink');if(!is_object($tag_obj)){halt('tag friendlink is exists!');};$data = $tag_obj -> lib_friendlink (array('row'=>'100','return'=>'data',));?>
                  <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <a href='<?php echo Template::addquote($value["com_url"]);?>'><?php echo Template::addquote($value["name"]);?></a>
                  <?php $n++;} ?>
                
            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
