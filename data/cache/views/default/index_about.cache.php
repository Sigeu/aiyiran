<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/help.css"/>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
	
		<div class="box_cont clearfix">
			<div class="w_1200 clearfix">
			  	<div class="left_menu">
					<h3>关于我们</h3>
					<ul class="clearfix">
						<li class="active"><a href="/category/Category/index/cid/53">-爱依然网介绍</a></li>
						<li><a href="/category/Category/index/cid/53/id/568">-联系我们</a></li>
					</ul>
				</div>
				<div class="right_cont">
					<h3 class="int"><span></span><?php echo Template::addquote($lists['title']);?></h3>
					<div class="liet_sm">
						<?php echo $content;?>
					</div>
					
					
				</div>	
			</div>
	    </div>
	<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
