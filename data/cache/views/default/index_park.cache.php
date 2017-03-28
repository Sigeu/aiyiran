<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/lm.css"/>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
<script type="text/javascript">
    $(function(){
        // banner轮播
        var banSwiper = new Swiper('.cemetery_ban .swiper-container',{
            pagination: '.cemetery_ban .swiper-container .pagination',
            loop:true,
            grabCursor: true,
            paginationClickable: true,
            autoplay : 7000,
            speed:1000,
            autoplayDisableOnInteraction: false
        });
        $('.cemetery_ban .arrow-left').on('click', function(e){
            e.preventDefault()
            banSwiper.swipePrev();
        });
        $('.cemetery_ban .arrow-right').on('click', function(e){
            e.preventDefault()
            banSwiper.swipeNext();
        });
        $(".cemetery_ban").hover(function(){
            banSwiper.stopAutoplay();
        },function(){
            banSwiper.startAutoplay();
        });
    })
</script>

        <style>
            .seleBox select{width: 118px; height: 34px;}
        </style>

    
        <!--*******************************-->
        <div class="box_cont clearfix">
            <div class="cemetery_ban">
                <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="<?php echo IMG_PATH;?>/lm_03.jpg" />
                            </div>
                            <div class="swiper-slide">
                                <img src="<?php echo IMG_PATH;?>/lm_03.jpg" />
                            </div>
                            <div class="swiper-slide">
                                <img src="<?php echo IMG_PATH;?>/lm_03.jpg" />
                            </div>
                        </div>
                        <div class="pagination"></div>
                        <div class="arrow-right"><i>&gt;</i></div>
                        <div class="arrow-left"><i>&lt;</i></div>
                   </div>
            </div>
            <div class="three_icont">
                <ul>
                    <li class="icon_1">
                        <span></span>
                        <h3>代客祭扫服务</h3>
                        <p>远在他乡也能到陵园鲜花，扫墓。寄托思念</p>
                    </li>
                    <li class="icon_2">
                        <span></span>
                        <h3>在线祭拜</h3>
                        <p>无论在何时何地都能祭奠故人，并留下思念悼文</p>
                    </li>
                    <li class="icon_3">
                        <span></span>
                        <h3>微信祭拜</h3>
                        <p>结合微信来祭奠故人，并能分享哀思</p>
                    </li>
                </ul>
            </div>

   <form action="" method="get" name=form1>
            <div class="hunt_box">
                <b>公园陵墓</b>
                <em>省份：</em>
                <div class="seleBox fl">
             <select name="province" id="originp" date-city="originc">
                <option value="" selected>选择省份</option>
                <?php $n=1;foreach($area AS $key => $value) { $lastIndex= count($area) == $n;?>
                    <option value="<?php echo Template::addquote($value['area_id']);?>" 
                    <?php if($province == $value['area_id']) { ?>
                    selected=""
                    <?php } ?> 

                    ><?php echo Template::addquote($value['area_name']);?></option>
                <?php $n++;} ?>
            </select>
                </div>
                <em>城市：</em>
                <div class="seleBox fl">
                       <select name="city" id="originc">
                            <option value="" selected>选择城市</option>
                                <?php if($info) { ?>
                                <?php $n=1;foreach($info AS $k => $v) { $lastIndex= count($info) == $n;?>
                                    <option value="<?php echo Template::addquote($v['area_id']);?>"
                                    <?php if($v['area_id'] == $city) { ?> selected="" <?php } ?>
                                    ><?php echo Template::addquote($v['area_name']);?></option>
                                <?php $n++;} ?>
                                <?php } ?>
                        </select>
                </div>
                <div class="seek_box fl">
                    <input name="keywords" id="" value="<?php echo $keywords;?>" class="l_input" placeholder="请输入标题或内容" type="text">
                    <input type="submit" value="搜索" class="r_but" type="button">
                </div>
            </div>
    </form>
<script type="text/javascript">
$(function(){
    // 阻止多次请求 unbind
$('#originp').unbind('change').bind('change',function(){
            $("#originc").html('');
     var baseUrl = "/search2/search/area";
        var va = $(this).val();
        var idConn = $(this).attr("date-city");
        //alert(idConn);
        $.get(baseUrl,{id:va},function(data){
             var str = "<option value=''>请选择</option>";

                   for(var i=0; i<data.data.length; i++){
                    str += "<option value="+data.data[i].area_id+">"+data.data[i].area_name+"</option>";
                    }
                   str += "";
          $("#originc").append(str);
        },"json");
      });
});
</script>
            <div class="tomb_list clearfix">
                <ul class="clearfix">
             <?php $tag_obj = Load::load_tag('park');if(!is_object($tag_obj)){halt('tag park is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_park (array('row'=>'100','province'=>$province,'city'=>$city,'keywords'=>$keywords,'return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 25*($currentPage-1);$url = $request_url;$pagesize = 25;$subpage = 10;$pagenum = count($count);$page = new Pages(25,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_park (array('row'=>'100','province'=>$province,'city'=>$city,'keywords'=>$keywords,'return'=>'data','from'=>$from,'pagesize'=>'25',));?>
             <?php if(!empty($data)) { ?>
                <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <li>
                        <a href="/content/Content/cemetery/id/<?php echo Template::addquote($value['id']);?>" target="_blank">
                            <img  class="lazy" src='/template/default/member/images/default_max.png' data-original="<?php echo Template::addquote($value['photo_url']);?>" title="<?php echo Template::addquote($value['title']);?>" width="216" height="216" />
                            <p><?php echo Template::addquote($value['title']);?></p>
                        </a>
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
            <div class="three_list">
                <div class="cont_list">
                    <div class="headline">
                        <span class="fl">最新加入<i></i></span>
                        <a href="###" class="jion fr">申请加入</a>
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
            <div class="link_exchange">
                <span>友情链接：</span><a href="###">中国民政部</a>  
                <a href="###">中国殡葬协会  </a>  
                <a href="###">国际殡葬协会 </a>  
                <a href="###">中国文明网  </a>  
                <a href="###">中国红十字会  </a>  
                <a href="###">中华慈善总会 </a>  
                <a href="###">中国文化部  </a>  
                <a href="###">清明网  </a>  
                <a href="###">中国历史  </a>  
                <a href="###">39心理网  </a>  
                <a href="###">农历网  </a>  
                <a href="###">安康视窗  </a>  
                <a href="###">徐州民生网</a>  
            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
