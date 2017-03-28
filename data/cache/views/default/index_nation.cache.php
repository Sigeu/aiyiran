<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/mzwh.css"/>
        <!--<script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>-->
        <script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
        <script type="text/javascript">
            $(function(){
                // banner轮播
                var banSwiper = new Swiper('.section01 .swiper-container',{
                    pagination: '.section01 .swiper-container .pagination',
                    loop:true,
                    grabCursor: true,
                    paginationClickable: true,
                    autoplay : 7000,
                    speed:1000,
                    autoplayDisableOnInteraction: false
                  });
                  $('.section01 .arrow-left').on('click', function(e){
                    e.preventDefault()
                    banSwiper.swipePrev();
                  });
                  $('.section01 .arrow-right').on('click', function(e){
                    e.preventDefault()
                    banSwiper.swipeNext();
                  });
                  $(".section01").hover(function(){
                    banSwiper.stopAutoplay();
                  },function(){
                    banSwiper.startAutoplay();
                  });
            })
        </script>

        <!--*************************-->
        <div class="box_cont clearfix">
            <div class="w_1200 clearfix">
                <div class="ban_reco">
                    <div class="section01">
                        <!--banner轮播-->
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <!--<div class="swiper-slide">-->
                                    <!--<img src="<?php echo IMG_PATH;?>/banner01_yc.png">-->
                                <!--</div>-->
                                <!--<div class="swiper-slide">-->
                                    <!--<img src="<?php echo IMG_PATH;?>/banner01_yc.png">-->
                                <!--</div>-->
                                <!--<div class="swiper-slide">-->
                                    <!--<img src="<?php echo IMG_PATH;?>/banner01_yc.png">-->
                                <!--</div>-->
                                <?php $tag_obj = Load::load_tag('advertlist');if(!is_object($tag_obj)){halt('tag advertlist is exists!');};$data = $tag_obj -> lib_advertlist (array('row'=>'3','adposid'=>'78','return'=>'data',));?>
                                <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                <?php $n=1;foreach($value['adimg'] AS $k => $v) { $lastIndex= count($value['adimg']) == $n;?>

                                <div class="swiper-slide">
                                    <a href="<?php echo Template::addquote($v['link']);?>" target="_blank"><img src="/static/uploadfile/advert/<?php echo Template::addquote($v['img']['path']);?>"></a>
                                </div>
                                <?php $n++;} ?>
                                <?php $n++;} ?>
                                
                            </div>
                            <div class="pagination"></div>
                            <div class="arrow-right"><i>&gt;</i></div>
                            <div class="arrow-left"><i>&lt;</i></div>
                       </div>
                    </div>
                    <div class="reco_info">
                        <div class="headline">
                        <b>推荐资讯</b>
                        </div>
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'328','row'=>'3','order'=>'id desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <a href="<?php echo Template::addquote($value['url']);?>">
                            <h3><?php echo csubstr($value["title"],24);?></h3>
                            <p><?php echo csubstr($value["description"],135);?></p>
                        </a>
                         <?php $n++;} ?>
                        
                    </div>
                </div>
                <div class="fl conItem01 clearfix">
                    <div class="culture fl">
                        <div class="headline">
                        <span class="fl"><?php echo cid2name(316);?><i></i></span>
                        <a href="/category/Category/list/cid/316" class="fr">查看更多<i></i></a>
                        </div>
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'316','row'=>'1','order'=>'id desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <a href="<?php echo Template::addquote($value['url']);?>" class="head_line">
                            <img class="lazy" src='/template/default/member/images/default_max.png' data-original="<?php echo UPLOAD_PATH;?>/<?php echo Template::addquote($value['thumb']['src']);?>" width="140" height="79"/>
                            <h4><?php echo csubstr($value["title"],13);?></h4>
                            <p><?php echo csubstr($value["description"],31);?></p>
                        </a>
                        <?php $n++;} ?>
                        
                        <ul class="culture_list">
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'316','row'=>'6','order'=>'id desc','from'=>'1','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                            <li><a href="<?php echo Template::addquote($value['url']);?>"><?php echo csubstr($value["title"],13);?></a><span><?php echo substr(date('Y.m.d', $value['publishtime']),0,10);?></span></li>
                        <?php $n++;} ?>
                        
                        </ul>
                    </div>
                    <div class="culture culture2 fl">
                        <div class="headline">
                        <span class="fl"><?php echo cid2name(317);?><i></i></span>
                        <a href="<?php echo worldge(317);?>" class="fr">查看更多<i></i></a>
                        </div>
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'317','row'=>'2','order'=>'id desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <a href="<?php echo Template::addquote($value['url']);?>" class="pichline">
                            <img class="lazy" src='/template/default/member/images/default_max.png' data-original="<?php echo UPLOAD_PATH;?>/<?php echo Template::addquote($value['thumb']['src']);?>" width="175" height="98"/>
                            <p><?php echo csubstr($value["title"],10);?></p>
                        </a>
                        <?php $n++;} ?>
                        

                     
                        <ul class="culture_list">
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'317','row'=>'5','from'=>'2','order'=>'id desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                            <li><a href="<?php echo Template::addquote($value['url']);?>"><?php echo csubstr($value["title"],13);?></a><span><?php echo substr(date('Y.m.d', $value['publishtime']),0,10);?></span></li>
                        <?php $n++;} ?>
                        
                        </ul>
                    </div>
                    <div class="list_word4 fl clearfix">
                        <div class="headline">
                        <span class="fl">风水知识<i></i></span>
                        <a href="<?php echo worldge(319);?>" class="fr">查看更多<i></i></a>
                        </div>
                        <ul class="clearfix">
                              <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'319','row'=>'4','order'=>'sortnum desc','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                            <li>
                                <a href="<?php echo Template::addquote($value['url']);?>">
                                    <img class="lazy" src='/template/default/member/images/default_max.png' data-original="/static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84"/>
                                    <h3><?php echo csubstr($value["title"],27);?></h3>
                                    <p><?php echo csubstr($value["description"],100);?></p>
                                </a>
                            </li>
                            <?php $n++;} ?>
                            
                        </ul>
                    </div>
                    <div class="list_word4 fl clearfix">
                        <div class="headline">
                        <span class="fl">孝爱传承<i></i></span>
                        <a href="<?php echo worldge(320);?>" class="fr">查看更多<i></i></a>
                        </div>
                        <ul class="clearfix">
                            <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'320','row'=>'4','order'=>'sortnum desc','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                            <li>
                                <a href="<?php echo Template::addquote($value['url']);?>">
                                    <img class="lazy" src='/template/default/member/images/default_max.png' data-original="/static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84"/>
                                    <h3><?php echo csubstr($value["title"],27);?></h3>
                                    <p><?php echo csubstr($value["description"],100);?></p>
                                </a>
                            </li>
                            <?php $n++;} ?>
                            
                        </ul>
                    </div>
                </div>
                <div class="fl conItem02 clearfix">
                    <div class="cont_list cont_list3">
                    <div class="headline">
                        <span class="fl">丧葬文化<i></i></span>
                        <a href="<?php echo worldge(318);?>" class="fr">参看更多<i></i></a>
                     </div>
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'318','row'=>'1','order'=>'id desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                     <a href="<?php echo Template::addquote($value['url']);?>" class="head_line2">
                        <img src="<?php echo IMG_PATH;?>/mz_09.png"/>
                        <h3><?php echo csubstr($value["title"],18);?></h3>
                        <p><?php echo csubstr($value["description"],20);?></p>
                     </a>
                      <?php $n++;} ?>
                      
                    <ul class="">
                        <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('cid'=>'318','row'=>'10','from'=>'1','order'=>'id desc','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <li>
                            <a href="<?php echo Template::addquote($value['url']);?>"><?php echo csubstr($value["title"],17);?> </a>
                            <span><?php echo substr(date('Y.m.d', $value['publishtime']),0,10);?></span>
                        </li>
                     <?php $n++;} ?>
                    
                    </ul>
                </div>
                    <a href="###" class="double_j"><img src="<?php echo IMG_PATH;?>/jw_12.jpg" /></a>
                    <a href="###" class="data_918"><img src="<?php echo IMG_PATH;?>/jw_30.jpg" /></a>
                    
                </div>
                
            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
