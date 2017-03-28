<?php if(!defined('IN_MAINONE')) exit(); ?>

		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->

		<!-- 确认使用弹层 -->
		<div class="bg_yc02"></div>
		<div class="bgBox02"></div>
		<div class="notiBox">
			<div class="handTop">
				<span class="handS">操作提示</span><em class="handEm"></em>
			</div>
			<div class="notiBot">
				<p class="handSure">确定使用该模板吗？</p>
				<div class="sureD">
					<a href="javascript:;" class="sure">确认</a><a href="javascript:;" class="concle">取消</a>
				</div>
			</div>
		</div>
		<!-- 确认使用弹层 -->
<?php include Template::t_include('member/head_left.html');?>

			<div class="conRig_yc">
				<h3 class="dwH3_yc">模板风格管理</h3>
				<ul class="clearfix moduleUl">
					<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
					<li>
						<div class="moduleD">
							<img src="/static/uploadfile<?php echo Template::addquote($v['pic']);?>">
						</div>
						<p class="titleP01"><?php echo Template::addquote($v['name']);?></p>
						<p class="titleP02"><?php if($v['free']==1) { ?>免费<?php } else { ?>收费<?php } ?></p>
						<div class="styleBox">
							<a href="javascript:;" class="greenA">预览</a>
							<?php if($info['style']==$v['id']) { ?>
							<a href="javascript:;" class="yellowA active">使用中</a>
							<?php } else { ?>
							<a href="javascript:;" class="yellowA shiyong" data="<?php echo Template::addquote($v['id']);?>" mid="<?php echo $mid;?>">使用</a>
							<?php } ?>
						</div>
					</li>
					<?php $n++;} ?>
				</ul>
			</div>
		</div>
		<div class="wrapS03_yc jbFT_yc">
			<p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
		</div>
	</body>
	<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/common.js" ></script>
	<script type="text/javascript">
		$(function(){
			// 使用
			$(".shiyong").click(function(){
				var $this=$(this);
				var id = $this.attr('data');
				var mid = $this.attr('mid');
				$(".bg_yc02,.bgBox02,.notiBox").show();
				$(".sure").unbind("click").click(function(){
					$.ajax({
	                    type: "Post",
	                    url: "/member/memorial/setStyle",
	                    data: {"id":id, "mid":mid},
	                    dataType: "json",
	                    success: function(data) {
	                        if (data.status == 1) {
	                            $(".bg_yc02,.bgBox02,.notiBox").hide();
								$(".yellowA").removeClass("active");
								$this.addClass("active");
								$(".yellowA").html("使用");
								$this.html("使用中");
	                        } else {
	                            layer.alert(data.msg, {icon: 2,offset: '40%',
	                        
	                        });
	                            return false;
	                        };
	                    }
                	});

					
				});
				$(".concle").unbind("click").click(function(){
					$(".bg_yc02,.bgBox02,.notiBox").hide();
				});
			});

			// 预览
			$("body").on("click",".greenA",function(){
		        var showimg = $(this).parents("li").find("img").attr("src");
		        var addBox="<div class='bg_yc'></div><div class='picB_yc'><div class='imgBox_yc'><img src='"+showimg+"' /><span class='close_yc'></span></div></div>";
		        $("body").append(addBox);
	        });
	        $("body").on("click",".close_yc",function(){
	            $(".bg_yc").hide();
	            $(".picB_yc").hide();
	        });

		});
	</script>
</html>
