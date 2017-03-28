<?php if(!defined('IN_MAINONE')) exit(); ?>
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

                                <?php $tag_obj = Load::load_tag('advertlist');if(!is_object($tag_obj)){halt('tag advertlist is exists!');};$data = $tag_obj -> lib_advertlist (array('row'=>'3','adposid'=>'77','return'=>'data',));?>
                                <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                                    <?php $n=1;foreach($value['adimg'] AS $k => $v) { $lastIndex= count($value['adimg']) == $n;?>

                                <div class="swiper-slide">
                                    <a href="<?php echo Template::addquote($v['link']);?>" target="_blank">
                                        <img src="/static/uploadfile/advert/<?php echo Template::addquote($v['img']['path']);?>">
                                    </a>
                                </div>
                                        <?php $n++;} ?>
                                    <?php $n++;} ?>
                                    
                                </div>
                                <div class="pagination"></div>
                                <div class="arrow-right"><i>&gt;</i></div>
                                <div class="arrow-left"><i>&lt;</i></div>
                           </div>