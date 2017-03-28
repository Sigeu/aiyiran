<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/index.css"/>
<script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/index.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>


        <div class="content">
            <div class="indexBanner">
              <div class="fl conItem01">
                <div class="section01">
                        <!--banner轮播-->
                            <?php include Template::t_include('inc/lbt.html');?>
                    </div>
              </div>
              <div class="fr conItem02">

                <!-- 登录 -->
                <?php if($GLOBALS['username']) { ?>
                    <?php include Template::t_include('inc/member.html');?>
                <?php } else { ?>
                <!-- 注册 -->
                    <?php include Template::t_include('inc/login.html');?>
                <?php } ?>
              </div>
             </div>
            <div class="main1200 clearfix">
                <div class="fl conItem01">
                    <div class="section section02">
                        <div class="headline">
                        <span class="fl">在线追思<i></i></span>
                        <!--<a href="###" class="fr">参看更多<i></i></a>-->
                        </div>
                        <div class="secLB">
                            <div class="arrow-right arrow_m"><i>&gt;</i></div>
                            <div class="arrow-left arrow_m"><i>&lt;</i></div>
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php $n=1;foreach($online AS $key => $value) { $lastIndex= count($online) == $n;?>
                                    <div class="swiper-slide">
                                        <div class="itemSli">
                                            <div class="itemImg">
                                                <img class="lazy" src='/template/default/member/images/default_max.png' data-original="<?php echo Template::addquote($value['userpic']);?>" width="185" height="185">
                                            </div>
                                            <p class="clearfix"><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['id']);?>" target="_blank" class="fl nameA"><?php echo Template::addquote($value['name']);?></a>
                                                <?php if($value['catid']==1) { ?>
                                                    <a href="/category/Category/index/cid/305" target="_blank" class="fr">私人纪念馆</a>
                                                <?php } elseif ($value['catid']==2) { ?>
                                                    <a href="/category/Category/index/cid/306" target="_blank" class="fr">名人人纪念馆</a>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php $n++;} ?>
                                </div>

                           </div>
                        </div>
                    </div>
                    <div class="section section03">
                        <div class="headline">
                        <span class="fl"><?php echo cid2name(306);?><i></i></span>
                        <a href="<?php echo getMoreUrl(306);?>" class="fr" target="_blank">查看更多<i></i></a>
                        </div>
                        <div class="hotP">
                            <ul class="clearfix">
                                <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('row'=>'10','catid'=>'2','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 4*($currentPage-1);$url = $request_url;$pagesize = 4;$subpage = 10;$pagenum = count($count);$page = new Pages(4,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('row'=>'10','catid'=>'2','return'=>'data','from'=>$from,'pagesize'=>'4',));?>
                                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                        <li style="height: 306px!important;">
                                            <div class="hotPImg">
                                                <img class="lazy" src='/template/default/member/images/default_max.png' data-original="<?php echo Template::addquote($value['userpic']);?>" width="185" height="185">
                                            </div>
                                            <p class="clearfix hotP_p"><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" class="fl nameA" target="_blank"><?php echo Template::addquote($value['m_name']);?></a><a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" target="_blank" class="fr quickJS">立即祭拜</a></p>
                                            <div class="mainP">
                                                <p>享年：<span><?php echo Template::addquote($value['m_year']);?>
                                                -
                                                <?php echo Template::addquote($value['d_year']);?></span></p>
                                                <p class="introP">简介：<span><?php echo csubstr($value['descript'],25);?></span></p>
                                            </div>
                                        </li>
                                    <?php $n++;} ?>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="section04">
                        <img src="<?php echo IMG_PATH;?>/banner02_yc.jpg">
                    </div>
                    <div class="section section05">
                        <div class="headline">
                            <div class="pagination pagination_three_m">
                                <span class="fl active"><?php echo cid2name(311);?><i></i><b>|</b></span>
                                <span class="fl"><?php echo cid2name(312);?><i></i><b>|</b></span>
                                <span class="fl"><?php echo cid2name(310);?><i></i></span>
                            </div>
                        <a href="<?php echo worldge(311);?>" class="fr">查看更多<i></i></a>
                        </div>
                        <div class="swiper-container">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                               <div class="secBot">
                                <div class="secItem clearfix">
                                            <!-- 特殊的地方的文章显示 已排序 倒叙 -->
                                <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'1','cid'=>'311','order'=>'id desc','return'=>'data',));?>
                                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                    <div class="fl secIml">
                                        <div class="secItImg">
                                            <a href="<?php echo Template::addquote($value['url']);?>" target="_blank"><img  class="lazy" src='/template/default/member/images/default_max.png' data-original="static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="390" height="219"></a>
                                        </div>
                                        <h5><?php echo msubstr($value["title"],0,15,'utf-8');?></h5>
                                        <small>By：<span><?php echo Template::addquote($value["username"]);?></span> Tme：<span><?php echo date('Y-m-d',$value["publishtime"]);?></span></small>
                                        <p><?php echo msubstr($value["description"],0,130,'utf-8');?></p>
                                    </div>
                                <?php $n++;} ?>
                                
                                    <div class="fl secImr">
                                        <ul>
                                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'4','cid'=>'311','order'=>'id desc','from'=>'1','return'=>'data',));?>
                                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                                <li class="clearfix">
                                                    <a href="<?php echo Template::addquote($value['url']);?>" target="_blank">
                                                    <div class="fl secimg"><img  class="lazy" src='/template/default/member/images/default_max.png' data-original="static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84"></div>
                                                    <div class="fl secintro">
                                                        <h6><?php echo msubstr($value["title"],0,15,'utf-8');?></h6>
                                                        <p><?php echo msubstr($value["description"],0,40,'utf-8');?></p>
                                                    </div>
                                                    </a>
                                                </li>
                                            <?php $n++;} ?>
                                        
                                        </ul>
                                    </div>
                                </div>
                        </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="secBot">
                                <div class="secItem clearfix">
                                <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'1','cid'=>'312','order'=>'id desc','return'=>'data',));?>
                                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                    <div class="fl secIml">
                                        <div class="secItImg">
                                             <a href="<?php echo Template::addquote($value['url']);?>" target="_blank"><img  class="lazy" src='/template/default/member/images/default_max.png' data-original="static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="390" height="219"></a>
                                        </div>
                                        <h5><?php echo msubstr($value["title"],0,15,'utf-8');?></h5>
                                        <small>By：<span><?php echo Template::addquote($value["username"]);?></span> Tme：<span><?php echo date('Y-m-d',$value["publishtime"]);?></span></small>
                                        <p><?php echo msubstr($value["description"],0,130,'utf-8');?></p>
                                    </div>
                                <?php $n++;} ?>
                                
                                    <div class="fl secImr">
                                        <ul>
                                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'4','cid'=>'312','order'=>'id desc','from'=>'1','return'=>'data',));?>
                                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                                <li class="clearfix">
                                                    <a href="<?php echo Template::addquote($value['url']);?>" target="_blank">
                                                    <div class="fl secimg"><img  class="lazy" src='/template/default/member/images/default_max.png' data-original="static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84"></div>
                                                    <div class="fl secintro">
                                                        <h6><?php echo msubstr($value["title"],0,15,'utf-8');?></h6>
                                                        <p><?php echo msubstr($value["description"],0,40,'utf-8');?></p>
                                                    </div>
                                                    </a>
                                                </li>
                                            <?php $n++;} ?>
                                        
                                        </ul>
                                    </div>
                                </div>
                        </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="secBot">
                                <div class="secItem clearfix">
                                <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'1','cid'=>'310','order'=>'id desc','return'=>'data',));?>
                                <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                    <div class="fl secIml">
                                        <div class="secItImg">
                                              <a href="<?php echo Template::addquote($value['url']);?>" target="_blank"><img  class="lazy" src='/template/default/member/images/default_max.png' data-original="static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="390" height="219"></a>
                                        </div>
                                        <h5><?php echo msubstr($value["title"],0,15,'utf-8');?></h5>
                                        <small>By：<span><?php echo Template::addquote($value["username"]);?></span> Tme：<span><?php echo date('Y-m-d',$value["publishtime"]);?></span></small>
                                        <p><?php echo msubstr($value["description"],0,130,'utf-8');?></p>
                                    </div>
                                <?php $n++;} ?>
                                
                                    <div class="fl secImr">
                                        <ul>
                                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'4','cid'=>'310','order'=>'id desc','from'=>'1','return'=>'data',));?>
                                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                                <li class="clearfix">
                                                    <a href="<?php echo Template::addquote($value['url']);?>" target="_blank">
                                                    <div class="fl secimg"><img  class="lazy" src='/template/default/member/images/default_max.png' data-original="static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84"></div>
                                                    <div class="fl secintro">
                                                        <h6><?php echo msubstr($value["title"],0,15,'utf-8');?></h6>
                                                        <p><?php echo msubstr($value["description"],0,40,'utf-8');?></p>
                                                    </div>
                                                    </a>
                                                </li>
                                            <?php $n++;} ?>
                                        
                                        </ul>
                                    </div>
                                </div>
                        </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="fl conItem02 clearfix">
                <?php if($uid) { ?>
                    <a href="/member/memorial/create" class="set_up"></a>
                <?php } else { ?>
                    <a href="/user/Login/login2" class="set_up"></a>
                <?php } ?>
                    <div class="festa">
                      <div class="headline">
                        <span class="fl">那年今日<i></i></span>
                        <!-- <a href="###" class="fr">参看更多<i></i></a> -->
                      </div>
                      <div class="four_p">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                              <div class="swiper-slide">
                                 <ul class="people_4">
                                <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('day'=>'1','from'=>'0','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 4*($currentPage-1);$url = $request_url;$pagesize = 4;$subpage = 10;$pagenum = count($count);$page = new Pages(4,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('day'=>'1','from'=>$from,'return'=>'data','pagesize'=>'4',));?>
                                <?php if(is_array($data)) { ?>
                                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                    <li>
                                        <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" target="_blank">
                                            <img src="<?php echo Template::addquote($value['userpic']);?>" />
                                            <span class="mask"></span>
                                            <p>
                                                <em class="name"><?php echo Template::addquote($value['personname']);?></em>
                                                <em>生日：<?php echo date('Y-m-d',$value["brithdate"]);?></em>
                                                <em> 忌日：<?php echo date('Y-m-d',$value["dieddate"]);?></em>
                                            </p>
                                        </a>
                                    </li>
                                    <?php $n++;} ?>
                                    <?php } else { ?>
                                没找到信息，请稍后再试
                                <?php } ?>
                                
                                 </ul>
                              </div>
                              <div class="swiper-slide">
                                 <ul class="people_4">
                                    <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('day'=>'1','from'=>'4','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 8*($currentPage-1);$url = $request_url;$pagesize = 8;$subpage = 10;$pagenum = count($count);$page = new Pages(8,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('day'=>'1','from'=>$from,'return'=>'data','pagesize'=>'8',));?>
                                <?php if(is_array($data)) { ?>
                                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                        <li>
                                            <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" target="_blank">
                                                <img src="<?php echo Template::addquote($value['userpic']);?>" />
                                                <span class="mask"></span>
                                                <p>
                                                    <em class="name"><?php echo Template::addquote($value['personname']);?></em>
                                                    <em>生日：<?php echo date('Y-m-d',$value["brithdate"]);?></em>
                                                    <em> 忌日：<?php echo date('Y-m-d',$value["dieddate"]);?></em>
                                                </p>
                                            </a>
                                        </li>
                                        <?php $n++;} ?>
                                         <?php } else { ?>
                                没找到信息，请稍后再试
                                <?php } ?>
                                    
                                 </ul>
                              </div>
                              <div class="swiper-slide">
                                 <ul class="people_4">
                                    <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('day'=>'1','from'=>'8','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 12*($currentPage-1);$url = $request_url;$pagesize = 12;$subpage = 10;$pagenum = count($count);$page = new Pages(12,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('day'=>'1','from'=>$from,'return'=>'data','pagesize'=>'12',));?>
                                <?php if(is_array($data)) { ?>
                                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                        <li>
                                            <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" target="_blank">
                                                <img src="<?php echo Template::addquote($value['userpic']);?>" />
                                                <span class="mask"></span>
                                                <p>
                                                    <em class="name"><?php echo Template::addquote($value['personname']);?></em>
                                                    <em>生日：<?php echo date('Y-m-d',$value["brithdate"]);?></em>
                                                    <em> 忌日：<?php echo date('Y-m-d',$value["dieddate"]);?></em>
                                                </p>
                                            </a>
                                        </li>
                                        <?php $n++;} ?>
                                         <?php } else { ?>
                                没找到信息，请稍后再试
                                <?php } ?>
                                    
                                 </ul>
                              </div>
                            </div>
                          </div>
                          <div class="pagination pagination_nnjr"></div>
                      </div>
                    </div>
                    <div class="adv">
                        <a href="###"><img src="<?php echo IMG_PATH;?>/tj_03.jpg" width="340" height="140" /></a>
                    </div>
                    <div class="hot_w">
                        <div class="headline">
                        <span class="fl">那年今日<i></i></span>
                        <!-- <a href="###" class="fr">参看更多<i></i></a> -->
                         </div>
                        <ul class="list_hot">
                        <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$data = $tag_obj -> lib_memo (array('day'=>'1','limit'=>'5','order'=>'click_num DESC','return'=>'data',));?>
                                <?php if(is_array($data)) { ?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                            <?php $key++; ?>
                            <li class="active">
                                <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['m_id']);?>" target="_blank">
                                    <?php if($key < 4) { ?>
                                    <i><?php echo $key;?></i>
                                    <?php } else { ?>
                                    <i style="background:#666;"><?php echo $key;?></i>
                                    <?php } ?>
                                    <img src="<?php echo Template::addquote($value['userpic']);?>"/>
                                    <p class="from"><span>[<?php echo Template::addquote($value['cat_name']);?>]&nbsp;</span><?php echo Template::addquote($value['person']);?> 纪念馆</p>
                                    <p  class="visits"><em>访问量：<?php echo Template::addquote($value['click_num']);?></em></p>
                                </a>
                            </li>
                            <?php $n++;} ?>
                            <?php } else { ?>
                                没找到信息，请稍后再试
                                <?php } ?>
                        
                        </ul>
                        <a href="<?php echo getMoreUrl(306);?>" class="see_more" target="_blank">查看更多+</a>
                    </div>
                    <div class="adv adv2">
                        <a href="###"><img src="<?php echo IMG_PATH;?>/ln_03.png" width="340" height="140"/></a>
                    </div>
                </div>
            </div>
            <div class="three_list">
                <div class="cont_list">
                    <div class="headline">
                        <span class="fl"><?php echo cid2name(315);?><i></i></span>
                        <a href="<?php echo worldge(315);?>" class="fr">参看更多<i></i></a>
                     </div>
                    <ul class="">
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'10','cid'=>'315','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                <li>
                                    <a href="<?php echo Template::addquote($value['url']);?>" target="_blank">·【民族文化】<?php echo msubstr($value["title"],0,15,'utf-8');?></a>
                                    <span><?php echo date('Y-m-d',$value["publishtime"]);?></span>
                                </li>
                            <?php $n++;} ?>
                        
                    </ul>
                </div>
                <div class="cont_list">
                    <div class="headline">
                        <span class="fl">最新资讯<i></i></span>
                        <a href="<?php echo worldge(327);?>" class="fr" target="_blank">参看更多<i></i></a>
                     </div>
                    <ul class="">
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'10','cid'=>'327','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                <li>
                                    <a href="<?php echo Template::addquote($value['url']);?>" target="_blank"><?php echo msubstr($value["title"],0,15,'utf-8');?></a>
                                    <span><?php echo date('Y-m-d',$value["publishtime"]);?></span>
                                </li>
                         <?php $n++;} ?>
                        
                    </ul>
                </div>
                <div class="cont_list cont_list3">
                    <div class="headline">
                        <span class="fl">最新追思留言<i></i></span>
                        <!-- <a href="###" class="fr">参看更多<i></i></a> -->
                     </div>
                    <ul class="">
                        <?php $tag_obj = Load::load_tag('mese');if(!is_object($tag_obj)){halt('tag mese is exists!');};$data = $tag_obj -> lib_mese (array('limit'=>'10','field'=>'id,message,createtime','return'=>'data','order'=>'id desc',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                <li>
                                    <a href="/jinian/Jinian/comment/mid/<?php echo Template::addquote($value['mid']);?>" target="_blank"><?php echo msubstr($value["content"],0,17,'utf-8');?></a>
                                    <span><?php echo date("Y-m-d ", $value['addtime']);?></span>
                                </li>
                            <?php $n++;} ?>
                        
                    </ul>
                </div>
            </div>
            <div class="link_exchange">
                <span>友情链接：</span>
                <?php $tag_obj = Load::load_tag('friendlink');if(!is_object($tag_obj)){halt('tag friendlink is exists!');};$data = $tag_obj -> lib_friendlink (array('row'=>'100','return'=>'data',));?>
                  <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <a href='<?php echo Template::addquote($value["com_url"]);?>' target="_blank"><?php echo Template::addquote($value["name"]);?></a>
                  <?php $n++;} ?>
                

            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
