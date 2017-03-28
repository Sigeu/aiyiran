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
        <div class="box_cont clearfix">
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
             <!--****************************************************-->
             <div class="main1200 clearfix">
                <div class="fl conItem01 clearfix">
                    <div class="SearchMuseum">
             <form action="" method="get">
                        <div class="input_group">
                            <input id="searchMuseumkey" name="keywords" value="<?php echo $keywords;?>" class="form-control fl" placeholder="输入需要查找的内容" type="text">
                            <span><i></i><input type="button" onclick="sousuo(1);" class="input-group-addon fl" value="搜索" /></span>
                        </div>
                </form>

                        <p class="as_per">按字母搜索：</p>
                        <ul class="rank">
                        <?php $n=1;if(is_array($zimu)) foreach($zimu AS $v) { ?>
                            <li <?php if($letter == $v) { ?> class="active" <?php } ?>><a href="javascript:;" onclick="sousuo2('<?php echo $v;?>', 2, 1);"><?php echo $v;?></a></li>
                        <?php $n++;} ?>
                        </ul>
                    </div>
                </div>
                <div class="year_today">
                  <h3>那年今日</h3>
                  <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('day'=>'1','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 2*($currentPage-1);$url = $request_url;$pagesize = 2;$subpage = 10;$pagenum = count($count);$page = new Pages(2,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('day'=>'1','return'=>'data','from'=>$from,'pagesize'=>'2',));?>
                                <?php if(is_array($data)) { ?>

                                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <dl>
                        <dt>
                            <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['mid']);?>">
                            <img src="<?php echo Template::addquote($value['userpic']);?>" />
                            <p><?php echo Template::addquote($value['personname']);?></p>
                            </a>
                        </dt>
                        <dd>生日：<?php echo date('Y-m-d',$value["brithdate"]);?></dd>
                        <dd>忌日：<?php echo date('Y-m-d',$value["dieddate"]);?></dd>
                    </dl>

                         <?php $n++;} ?>
                        <?php } else { ?>
                                没找到信息，请稍后再试
                                <?php } ?>
                    
                </div>
             </div>
             <!--*****************************-->
            <script>
                window.onload = function(){
                    sousuo2('all', 4, 1);
                }
            </script>
             <div class="tab_box">
                <ul>
                    <li  class="active" ><a href="javascript:;" onclick="sousuo2('all', 4, 1);" >全部 </a></li>
                    <?php $persontype = get_config('common','person_type_admin','home');  ;?>
                    <!--<li  <?php if($persontype == 1) { ?> class="active" <?php } ?>><a href="?persontype=1">纪念先祖</a></li>-->
                    <!--<li  <?php if($persontype == 2) { ?> class="active" <?php } ?>><a href="?persontype=2" >纪念姐妹 </a></li>-->
                    <!--<li  <?php if($persontype == 3) { ?> class="active" <?php } ?>><a href="?persontype=3" >缅怀亲人</a></li>-->
                    <!--<li  <?php if($persontype == 4) { ?> class="active" <?php } ?>><a href="?persontype=4" >纪念友人</a></li>-->
                    <!--<li  <?php if($persontype == 5) { ?> class="active" <?php } ?>><a href="?persontype=5" >纪念同事</a></li>-->
                    <!--<li  <?php if($persontype == 6) { ?> class="active" <?php } ?>><a href="?persontype=6" >纪念老师</a></li>-->
                    <!--<li  <?php if($persontype == 7) { ?> class="active" <?php } ?>><a href="?persontype=7" >纪念爱人</a></li>-->
                    <!--<li  <?php if($persontype == 8) { ?> class="active" <?php } ?>><a href="?persontype=8" >纪念兄弟</a></li>-->
                    <?php $n=1;foreach($persontype AS $k => $v) { $lastIndex= count($persontype) == $n;?>
                    <?php if($k<=7) { ?>
                        <li onclick="sousuo2('<?php echo $k;?>', 3, 1);"><a href="javascript:;" ><?php echo $v;?></a></li>
                    <?php } ?>
                    <?php $n++;} ?>

                </ul>
                <!-- <a href="###" class="fr">参看更多<i></i></a> -->
             </div>
             <!-- form="/search/searchs/lists" -->
             <div class="tab_cont clearfix" style="min-height: 370px!important;">
                <div class="headline">
                <span class="fl">私人纪念馆<i></i></span>
                <!--<a href="###" class="fr">查看更多<i></i></a>-->
                </div>
                <ul class="list_jn clearfix createData">

                </ul>
                <!--<div class="page">-->
                    <!--<?php echo $pagestr;?>-->
                <!--</div>-->
             </div>
<!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>

<?php include Template::t_include('inc/three_inc.html');?>
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
