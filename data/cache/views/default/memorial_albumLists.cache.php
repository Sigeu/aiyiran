<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('inc/memorial_head.html');?>

			<div class="video_photo clearfix">
				<div class="photo_box clearfix">
					<div class="headline">
					<span class="fl">相册集<i></i></span>
					</div>	
					<ul class="photo_list">
						<?php $n=1;foreach($photo_cat AS $k => $v) { $lastIndex= count($photo_cat) == $n;?>
						<li>
							<a href="/jinian/Jinian/album/mid/<?php echo $mid;?>/id/<?php echo Template::addquote($v['id']);?>">
								<?php if($v['cover']) { ?>
									<img src="<?php echo Template::addquote($v['cover']);?>" />
								<?php } else { ?>
									<img src="/template/default/member/images/photo.jpg" />
								<?php } ?>
								<p><span class="fl"><?php echo Template::addquote($v['name']);?></span><em class="fr">（<?php echo Template::addquote($v['count']);?>）</em></p>
							</a>
						</li>
						<?php $n++;} ?>
					</ul>
				</div>
		<!-- 		<div class="photo_box video_box clearfix">
					<div class="headline">
					<span class="fl">视频集<i></i></span>
					</div>	
					<ul class="photo_list">
						<li>
							<a href="###">
								<img src="images/ly_03.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="images/ly_09.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="images/ly_11.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="images/ly_05.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="images/ly_07.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="images/ly_09.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="images/ly_07.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="images/ly_09.jpg" />
								<p>开国大典大阅兵</p>
								<span class="videoplay"></span>
							</a>
						</li>
					</ul>
				</div> -->
			</div>
		</div>	
	<!--***************-->			
				
			</div>
		</div>	
			<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
