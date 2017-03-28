<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/bzyp.css" />
<script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
<script type="text/javascript">
    $(function(){
        $(".classify span").click(function(){
            $(".classify p").toggleClass("active")
        });
        // banner轮播
        var banSwiper = new Swiper('.top_lb .swiper-container',{
//                  pagination: '.top_lb .swiper-container .pagination',
            loop:true,
            grabCursor: true,
            paginationClickable: true,
            autoplay : 7000,
            speed:1000,
            autoplayDisableOnInteraction: false
        });
        $('.top_lb .arrow-left').on('click', function(e){
            e.preventDefault()
            banSwiper.swipePrev();
        });
        $('.top_lb .arrow-right').on('click', function(e){
            e.preventDefault()
            banSwiper.swipeNext();
        });
        $(".top_lb").hover(function(){
            banSwiper.stopAutoplay();
        },function(){
            banSwiper.startAutoplay();
        });


    })
</script>

        <!--**************************************-->       
        <div class="box_cont_w clearfix">
            <div class="w_1200 clearfix">
                <div class="lef_min">
                    <div class="top_lb">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                            <?php $n=1;foreach($goodsablum AS $k => $v) { $lastIndex= count($goodsablum) == $n;?>
                                <div class="swiper-slide">
                                    <img src="<?php echo Template::addquote($v['photo']);?>">
                                </div>
                              <?php $n++;} ?>
                            </div>
                            <div class="arrow-right"><i>&gt;</i></div>
                            <div class="arrow-left"><i>&lt;</i></div>
                       </div>
                       <div class="details_w">
                        <h3><?php echo Template::addquote($goods['goodsname']);?></h3>
                        <div class="w_gs"><?php echo Template::addquote($goods['brief']);?></div>
                        <a href="/category/Category/index/cid/53/id/568" target="_blank">在线联系</a>
                       </div>
                    </div>
                    <div class="bot_deatli">
                        <div class="headline">
                        <span class="fl">产品详情<i></i></span>
                        <!--<a href="###" class="fr">参看更多<i></i></a>-->
                        </div>
                        <ul class="cp_deat clearfix">

                            <?php $n=1;foreach($goods['attr'] AS $k => $v) { $lastIndex= count($goods['attr']) == $n;?>
                            <li><?php echo $k;?>:  <?php echo $v;?></li>
                            <?php $n++;} ?>
                            
                        </ul>
                        <div class="cp_deat_cont"><?php echo Template::addquote($goods['content']);?></div>
                    </div>
                </div>
                <div class="right_cp_list">
                    <div class="headline">
                    <span class="fl">其他产品<i></i></span>
                    </div>
                    <ul>
                    <?php $tag_obj = Load::load_tag('goods');if(!is_object($tag_obj)){halt('tag goods is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_goods (array('order'=>'brandid','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 3*($currentPage-1);$url = $request_url;$pagesize = 3;$subpage = 10;$pagenum = count($count);$page = new Pages(3,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_goods (array('order'=>'brandid','return'=>'data','from'=>$from,'pagesize'=>'3',));?>
                    <?php if(!empty($data)) { ?>
                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?> 
                        <li>
                        <a href="<?php echo Template::addquote($value['url']);?>">
                            <img src="/static/uploadfile/goods/<?php echo Template::addquote($value['photo'][0]['photo']);?>" alt="<?php echo Template::addquote($value["goodsname"]);?>" title="<?php echo Template::addquote($value["goodsname"]);?>" />
                            <p><?php echo Template::addquote($value["goodsname"]);?></p>
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
        <!--**************************************-->       
<?php include Template::t_include('head_footer.html');?>
