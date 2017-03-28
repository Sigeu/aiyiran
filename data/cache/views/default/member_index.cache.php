<?php if(!defined('IN_MAINONE')) exit(); ?>

	<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
	<link rel="stylesheet" type="text/css" href="/template/default/member/css/index_yc.css"/>
	<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->

	<?php include Template::t_include('member/head_top.html');?>
	<div class="wrapCon_yc">
		<div class="wrapS01_yc clearfix">
			<div class="wItem wItem01_yc clearfix">
				<div class="fl wsec01_yc">
					<div class="tx_yc">
						<img src="<?php echo extends_path($_SESSION['front_login_info']['user_photo'], '/template/default/member/images/tx_yc.png');?>" width="120" height="120">
					</div>
					<!-- <a href="/member/User/cutavatar" class="btnCom_yc">修改头像</a> -->
				</div>
				<div class="fl wsec02_yc">
					<h4><span class="name_yc"><?php echo Template::addquote($GLOBALS['username']);?></span><em class="num_yc">(<?php echo Template::addquote($_SESSION['front_login_info']['id']);?>)</em><i class="icon5_yc"></i>
                </h4>
					<a href="/member/User/userinfo" class="btnCom_yc" target="_blank">完善资料</a>
				</div>
			</div>
			<div class="wItem wItem02_yc wItemMar10">
				<p class="itemP_yc"><i class="icon7_yc"></i><span>元宝：</span></p>
				<div class="itemD_yc"><em class="nmb01_yc"><?php echo Template::addquote($yuanbao['point']);?></em><a href="/member/Recharge/online" class="btnCom2_yc" target="_blank">充值元宝</a></div>
			</div>
			<div class="wItem wItem03_yc wItemMar10">
				<p class="messP_yc">
                <a href="/member/Systeminfo/lists"><i class="icon6_yc"></i></a>
                    未读消息：</p>
				<div class="messD_yc"><em class="nmb02_yc"><?php echo $nums;?></em><span>条消息</span><a href="/member/Systeminfo/lists" class="btnCom_yc" target="_blank">查看消息</a></div>
			</div>
		</div>
		<div class="wrapS02_yc clearfix">
			<div class="wList01_yc fl">
				<div class="listCon_yc listBor_yc">
					<h3 class="h3Com_yc"><span></span>我创建的场馆</h3>
					<ul class="clearfix listUl_yc">
						<?php $n=1;foreach($memorial_lists AS $k => $v) { $lastIndex= count($memorial_lists) == $n;?>
						<li class="clearfix">
							<div class="listImg_yc fl">
								<a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($v['id']);?>" target="_blank"><img src="<?php echo extends_path($v['userpic'], '/template/default/member/images/default_max.png');?>" width="160" height="160"></a>
							</div>
							<div class="listMain fl">
								<h5><?php echo Template::addquote($v['name']);?>纪念馆</h5>
								<a href="/member/memorial/info/mid/<?php echo Template::addquote($v['id']);?>" target="_blank" class="btnCom_yc">管理场馆</a>
								<p>访问量：<em><?php echo Template::addquote($v['click_num']);?></em></p>
							</div>
						</li>
						<?php $n++;} ?>
					</ul>
				</div>
				<div class="listCon_yc">
					<h3 class="h3Com_yc"><span></span>我关注的场馆</h3>
					<ul class="clearfix listUl_yc">
						<?php $n=1;foreach($follow AS $k => $v) { $lastIndex= count($follow) == $n;?>
						<li class="clearfix" style="width:440px;!important;">
               				<a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($v['id']);?>" target="_blank">
							<div class="listImg_yc fl">
								<img src="<?php echo extends_path($v['userpic'], '/template/default/member/images/default_max.png');?>" width="160" height="160">
							</div>
							</a>
							<div class="listMain fl">
								<h5><?php echo Template::addquote($v['name']);?>纪念馆</h5>
								<p class="persP_yc">建馆人：<em><?php echo Template::addquote($v['fllow_name']);?></em></p>
								<a href="javascript:;" class="btnCom2_yc delguanzhu" data="<?php echo Template::addquote($v['id']);?>">取消关注</a>
							</div>
						</li>
						<?php $n++;} ?>
					</ul>
				</div>
			</div>
			<div class="divJX_yc fl"></div>
			<div class="wList02_yc fl">
				<h3 class="h3Com_yc"><span></span>我的祭拜记录<a href="/member/Recharge/sacrifice" class="lookMore">查看更多<em>&gt;</em></a></h3>
				<ul class="floUl_yc">
					<?php $n=1;foreach($sacrifice AS $k => $v) { $lastIndex= count($sacrifice) == $n;?>
					<li class="clearfix">
						<div class="flo_yc fl">
							<img src="<?php echo Template::addquote($v['goods_img']);?>">
						</div>
						<p class="fl flowP_yc"><em><?php echo date('Y-m-d H:i:s',$v['addtime']);?><em>向场馆<span><?php echo Template::addquote($v['name']);?></span>使用【<span><?php echo Template::addquote($v['gname']);?></span>】</p>
					</li>
					<?php $n++;} ?>

				</ul>
			</div>
		</div>
	</div>
    <div class="wrapS03_yc jbFT_yc">
        <p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
    </div>
</body>
	<script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/common.js" ></script>
<script type="text/javascript">
	$(function(){
		// js解决间隙问题
		function divH(){
			var $hgP=$(".wrapS02_yc").height();
			$(".divJX_yc").height($hgP);
		}
		divH();
		$(window).resize(function(){
			divH();
		});
	});

        $(function () {
            $(".delguanzhu").click(function () {
                var mid = $(this).attr('data');
                layer.confirm('确认取消关注吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: "Post",
                        url: "/jinian/Jinian/clearcaretomb",
                        data: {'mid':mid},
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 1) {
                                layer.msg(data.msg, {icon: 1, offset: '40%'});
								setTimeout("history.go(0)",2000);
                            }else{
                                layer.msg(data.msg, {icon: 2, offset: '40%'});
                            }
                        }
                    });
                }, function(){
                    layer.closeAll();
                });

            });
        });
	</script>
</html>
