<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/jw.css"/>
<script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/index.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>


		<!--*****************************************************-->
		<div class="box_cont_w clearfix">
			<div class="w_1200 clearfix">
				<div class="fl conItem01 clearfix">
					<div class="list_word4 clearfix">
						<div class="headline">
						<span class="fl"><?php echo cid2name(311);?><i></i></span>
						<a href="<?php echo worldge(311);?>" class="fr">查看更多<i></i></a>
						</div>
						<ul>
                            <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'4','cid'=>'311','order'=>'sortnum desc','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
							<li>
								<a href="<?php echo Template::addquote($value['url']);?>">
									<img  class="lazy" src='/template/default/member/images/default_max.png' data-original="/static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84" />
									<h3><?php echo csubstr($value["title"],25);?></h3>
									<p><?php echo csubstr($value["description"],100);?></p>
								</a>
							</li>
							<?php $n++;} ?>
                            
						</ul>
					</div>
					<div class="list_word4 clearfix">
						<div class="headline">
						<span class="fl"><?php echo cid2name(312);?><i></i></span>
						<a href="<?php echo worldge(312);?>" class="fr">查看更多<i></i></a>
						</div>
						<ul>
							<?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'4','cid'=>'312','order'=>'sortnum desc','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
							<li>
								<a href="###">
									<img  class="lazy" src='/template/default/member/images/default_max.png' data-original="/static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84" />
									<h3><?php echo csubstr($value["title"],25);?></h3>
									<p><?php echo csubstr($value["description"],100);?></p>
								</a>
							</li>
							<?php $n++;} ?>
                            

						</ul>
					</div>
					<div class="list_word4 clearfix">
						<div class="headline">
						<span class="fl"><?php echo cid2name(310);?><i></i></span>
						<a href="<?php echo worldge(310);?>" class="fr">查看更多<i></i></a>
						</div>
						<ul>
							<?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'4','cid'=>'310','order'=>'sortnum desc','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
							<li>
								<a href="###">
									<img class="lazy" src='/template/default/member/images/default_max.png' data-original="/static/uploadfile/<?php echo Template::addquote($value['thumb']['src']);?>" width="150" height="84" />
									<h3><?php echo csubstr($value["title"],25);?></h3>
									<p><?php echo csubstr($value["description"],100);?></p>
								</a>
							</li>
							<?php $n++;} ?>
                            
						</ul>
					</div>
				</div>
				<div class="fl conItem02 clearfix">
				 <!-- 亲情排行榜 -->
				<?php include Template::t_include('inc/dearRankList.html');?>
				<a href="###" class="double_j"><img src="<?php echo IMG_PATH;?>/jw_12.jpg" /></a>

				<!-- 资讯推荐 -->
				<?php include Template::t_include('inc/infoTop.html');?>
				<!-- 纪念馆访问排行 -->
				<?php include Template::t_include('inc/memorialRankList.html');?>
				<a href="###" class="data_918"><img src="<?php echo IMG_PATH;?>/jw_30.jpg" /></a>
				</div>
		    </div>
		</div>
		<!--********footer***************************************-->
<?php include Template::t_include('footer.html');?>
