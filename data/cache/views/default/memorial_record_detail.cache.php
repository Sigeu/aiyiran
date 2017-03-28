<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('inc/memorial_head.html');?>
			<?php if($bio==null) { ?>
			<div class="biography_details">
				<div class="details"  style="margin-bottom: 50px;">
                   	<div class="top_title">
						<h2 style="font-size: 14px;color: #666;">暂无任何内容</h2>
                   	</div>
                   	<div class="details_cont">
                   	</div>
                    <!-- <p class="return_sx"><em class="prov fl"><span>上一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em><em class="next fr"><span>下一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em></p>  -->
                   </div>

			</div>
			<?php } else { ?>
			<div class="biography_details">
				<div class="details" style="margin-bottom: 50px;">
                   	<div class="top_title">
                   		<!-- <a href="/jinian/Jinian/record/mid/<?php echo $mid;?>">返回传记列表页</a> -->
                     	<h2><?php echo Template::addquote($bio['bioname']);?></h2>
                        <p><!-- 发布人：admin -->  阅读(<?php echo Template::addquote($bio['click_nums']);?>) │ 发布时间：<?php echo Template::addquote($bio['createtime']);?></p>
                   	</div>
                   	<div class="details_cont" style="margin-bottom: 30px;">
                   			<?php echo Template::addquote($bio['biocontent']);?>
                   	</div>
                    <!-- <p class="return_sx"><em class="prov fl"><span>上一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em><em class="next fr"><span>下一篇：</span><a href="###">人民心中伟大的领袖毛主席</a></em></p>  -->
                   </div>

			</div>
			<?php } ?>
		</div>
			<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
