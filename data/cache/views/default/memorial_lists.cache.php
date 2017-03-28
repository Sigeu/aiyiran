<?php if(!defined('IN_MAINONE')) exit(); ?>

	<meta charset="UTF-8">
	<title>个人中心--纪念馆管理</title>
	<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
	<link rel="stylesheet" type="text/css" href="/template/default/member/css/memorial_yc.css"/>
	<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<?php include Template::t_include('member/head_top.html');?>

	<div class="wrapCon_yc">
		<h3 class="h3Com_yc"><span></span>纪念馆管理</h3>
		<div class="tabUl_yc">
			<ul class="clearfix">
				<li><a href="/member/memorial/lists" class="active">我的纪念馆</a></li>
				<li><a href="/member/memorial/follow">我关注的馆</a></li>
				<li><a href="/member/memorial/create"><span class="add_yc"></span>创建新馆</a></li>
			</ul>
		</div>
		<div class="memList_yc">
			<ul class="clearfix">
				<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
				<li>
					<div class="yx_yc">
						<a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($v['id']);?>" target="_blank"><img src="<?php echo extends_path($v['userpic'], '/template/default/member/images/default_max.png');?>" width="270" height="270"></a>
					</div>
					<p class="clearfix nameP_yc"><span class="fl"><?php echo Template::addquote($v['personname']);?></span><em class="fr"><a href="/member/memorial/info/mid/<?php echo Template::addquote($v['id']);?>" class="btnCom_yc">管理</a><a href="javascript:;" data="<?php echo Template::addquote($v['id']);?>" class="btnCom2_yc">删除</a></em></p>
				</li>
				<?php $n++;} ?>
			</ul>
		</div>
		<div class="pageF_yc">
			<?php echo $pagestr;?>
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
	$(".btnCom2_yc").click(function(){
		var id = $(this).attr('data');
		layer.confirm('确认删除吗？', {
  			btn: ['确认','取消'] //按钮
		}, function(){
	  		$.ajax({
		        type: "Post",
		        url: "/member/memorial/delMemorial",
		        data: {"id":id},
		        dataType: "json",
		        success: function(data) {
		            if (data.status == 1) {
		                var index = layer.msg(data.msg);
		                setTimeout(function(){window.location="/member/memorial/lists";},2000); 
		            } else {
		                layer.alert(data.msg, {icon: 2,offset: '40%'});
		                return false;
		            };
		        }
	    	});
		}, function(){
		  layer.closeAll();
	});
		
	});
});
</script>

</html>