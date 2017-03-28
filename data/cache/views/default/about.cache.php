<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('cemetery/head_cemetery.html');?>

		<!--********************************************-->
		<div class="box_cont_w clearfix">
			<div class="w_1200 clearfix">
				<div class="left_menu clearfix">
					<h3>关于陵园</h3>
					<ul class="clearfix">

						<li <?php if($info==1) { ?>class="active"<?php } ?>><a href="/content/Content/aboutCem/id/40/info/1">-陵园简介</a></li>
						<li <?php if($info==2) { ?>class="active"<?php } ?>><a href="/content/Content/aboutCem/id/40/info/2">-陵园荣誉</a></li>
						<li <?php if($info==3) { ?>class="active"<?php } ?>><a href="/content/Content/aboutCem/id/40/info/3">-陵园文化</a></li>
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
