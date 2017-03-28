<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('inc/memorial_head.html');?>
<?php if($lists==null) { ?>
			<div class="biography_details">
				<div class="details">
                   	<div class="top_title">
						<h2 style="font-size: 14px;color: #666;">暂无任何内容</h2>
                   	</div>
                   	<div class="details_cont">
                   	</div>
                    <!-- <p class="return_sx"><em class="prov fl"><span>上一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em><em class="next fr"><span>下一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em></p>  -->
                   </div>

			</div>
			<?php } else { ?>
			<div class="worship_list clearfix">
				<div class="headline">
				<span class="fl">祭拜记录<i></i></span>
				</div>	
				<ul class="prop_list clearfix">
				<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
					<li>
						<em><?php echo Template::addquote($v['username']);?></em> 使用了祭拜物品 <span><?php echo Template::addquote($v['gname']);?> x<?php echo Template::addquote($v['num']);?></span>    <i><?php echo date('Y-m-d h:i:s', $v['addtime']);?></i>
					</li>
				<?php $n++;} ?>
				</ul>
				<div class="page">
		     		<?php echo $showPage;?>
		     	</div>
			</div>
		</div>	
<?php } ?>

			<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
