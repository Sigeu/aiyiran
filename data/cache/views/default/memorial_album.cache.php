<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('inc/memorial_head.html');?>
		<script type="text/javascript" src="<?php echo JS_PATH;?>/xiangce.js"></script>

			<div class="Photo_album clearfix">
				<div class="headline">
				<span class="fl">相册集<i></i></span>
				</div>
				<dl class="title_head">
					<dt>
						<?php if($photo_cat['cover']) { ?>
							<img src="<?php echo Template::addquote($photo_cat['cover']);?>" />
						<?php } else { ?>
							<img src="/template/default/member/images/photo.jpg" />
						<?php } ?>
					</dt>
					<dd>
						<h3><?php echo Template::addquote($photo_cat['name']);?></h3>
						<p>创建时间：<?php echo date('Y-m-d', $photo_cat['addtime']);?> &nbsp;&nbsp;&nbsp;&nbsp;  照片数量<?php echo $count;?>张 &nbsp;&nbsp;&nbsp;&nbsp; 浏览量：<?php echo Template::addquote($photo_cat['click_nums']);?></p>
					    <a href="/jinian/Jinian/albumLists/mid/<?php echo $mid;?>"><span>返回相册列表></span></a>
					</dd>
				</dl>
				<!--***************-->
					<div class="center clearfix">
						<?php $n=1;foreach($photo AS $k => $v) { $lastIndex= count($photo) == $n;?>
						<a href="###">
							<img src="<?php echo Template::addquote($v['photo']);?>"/>
							<p><?php echo Template::addquote($v['name']);?></p>
						</a>
						<?php $n++;} ?>
					</div>
					<div class="popup"></div>
					<div class="show">
						<img class="big" src=""/>
						<p class="cont_dete"></p>
						<a href="###" class="arrow left"></a>
						<a href="###" class="arrow right"></a>
					    <span class="close"></span>
					</div>
				<div class="page">
		     		<?php echo $showPage;?>
		     	</div>
	<!--***************-->		

				
			</div>
		</div>	
			<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
