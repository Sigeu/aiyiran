<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('cemetery/head_cemetery.html');?>

		<!--********************************************-->
		<div class="box_cont_w clearfix">
			<div class="w_1200 clearfix">
				<div class="left_menu clearfix">
					<h3>陵园服务</h3>
					<ul class="clearfix">
						<li class="active"><a href="/content/Content/server/id/<?php echo Template::addquote($content['id']);?>">-陵园服务</a></li>
					</ul>
				</div>
				<div class="right_cont">
					<!-- <h2 class="ly_tiele"><?php echo Template::addquote($content['title']);?></h2> -->
					<div class="into_cont clearfix">
						<?php echo $summary;?>
					</div>
				</div>	
			</div>
		</div>
		
		<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
