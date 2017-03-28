<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('inc/memorial_head.html');?>

			<!--***古人简介*******************************-->
			<div class="introduc">
				<span class="head_left fl">
					<img src="<?php echo Template::addquote($info['userpic']);?>" />
					<a href="/jinian/Jinian/index/mid/<?php echo $mid;?>">点击祭拜</a>
				</span>
				<h3><?php echo Template::addquote($desc['person']);?></h3>
				<p>(<?php echo Template::addquote($desc['m_year']);?>-<?php echo Template::addquote($desc['m_month']);?>-<?php echo Template::addquote($desc['m_day']);?> — <?php echo Template::addquote($desc['d_year']);?>-<?php echo Template::addquote($desc['d_month']);?>-<?php echo Template::addquote($desc['d_day']);?>)</p>
				<dl>
					<dd>性别：<?php if($desc['sex']==1) { ?>男<?php } else { ?>女<?php } ?></dd>
					<dd>民族：<?php echo Template::addquote($desc['nation']);?></dd>
					<dd>籍贯：<?php echo Template::addquote($sheng['area_name']);?>省<?php echo Template::addquote($shi['area_name']);?>市<?php echo Template::addquote($desc['origind']);?></dd>
					<dd>职业：<?php echo Template::addquote($desc['careers']);?></dd>
				</dl>
				<dl>
					<dd>生辰：<?php echo Template::addquote($desc['m_year']);?>年<?php echo Template::addquote($desc['m_month']);?>月<?php echo Template::addquote($desc['m_day']);?>日</dd>
					<dd>忌日：<?php echo Template::addquote($desc['d_year']);?>年<?php echo Template::addquote($desc['d_month']);?>月<?php echo Template::addquote($desc['d_day']);?>日</dd>
					<dd>出生地址：<?php echo Template::addquote($sheng2['area_name']);?>省<?php echo Template::addquote($shi2['area_name']);?>市<?php echo Template::addquote($desc['brithc']);?></dd>
					<dd>安葬地址：<?php echo Template::addquote($cemetery['title']);?></dd>
				</dl>
				<dl>
					<dd>纪念馆号：<?php echo Template::addquote($desc['mid']);?></dd>
					<dd>纪念馆地址：http://ariyiran.com/<?php echo Template::addquote($desc['mid']);?></dd>
				</dl>
			</div>
			<div class="details_box">
				<div class="headline">
				<span class="fl">故人简介<i></i></span>
				<!--<a href="###" class="fr">参看更多<i></i></a>-->
				</div>
				<div class="details_jj">
				     <?php echo Template::addquote($desc['descript']);?>
				</div>


			</div>
		</div>
			<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
