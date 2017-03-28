<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('inc/memorial_head.html');?>
<?php if($funeral==null) { ?>
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
		<div class="biography clearfix">
			    <div class="headline">
				<span class="fl">纪念祭文<i></i></span>
				<!--<a href="###" class="fr">参看更多<i></i></a>-->
				</div>
				<ul class="four_zj clearfix">
					<?php $n=1;foreach($funeral AS $k => $v) { $lastIndex= count($funeral) == $n;?>
					<li>
						<h3><?php echo Template::addquote($v['ename']);?></h3>
						<p><?php echo csubstr($v['econtent'],210);?></p>
					    <h5>阅读(<?php echo Template::addquote($v['click_nums']);?>) │ 评论(<?php echo Template::addquote($v['comments']);?>) │ 发布时间：<?php echo Template::addquote($v['createtime']);?><a href="/jinian/Jinian/funeralConn/mid/<?php echo $mid;?>/id/<?php echo Template::addquote($v['id']);?>">阅读全文>></a></h5>
					</li>
					<?php $n++;} ?>
				</ul>
				<div class="page">
		     		<?php echo $showPage;?>
		     	</div>
			</div>

<?php } ?>
			<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
