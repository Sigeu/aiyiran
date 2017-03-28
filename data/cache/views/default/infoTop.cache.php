<?php if(!defined('IN_MAINONE')) exit(); ?>
<div class="cont_list cont_list7">
                    <div class="headline">
                        <span class="fl">最新资讯<i></i></span>
                        <!-- <a href="<?php echo getMoreUrl();?>" class="fr">参看更多<i></i></a> -->
                     </div>
                    <ul class="">
    <!-- 资讯推荐 -->
<?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'10','order'=>'id desc','return'=>'data',));?>
    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
        <li class="active">
            <a href="<?php echo Template::addquote($value['url']);?>" target="_blank"><?php echo csubstr($value["title"],24);?></a>
        </li>
    <?php $n++;} ?>


                    </ul>
                </div>