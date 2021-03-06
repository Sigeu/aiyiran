<?php if(!defined('IN_MAINONE')) exit(); ?>

		<meta charset="UTF-8">
		<title>资金管理--消费记录</title>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
	<?php include Template::t_include('member/head_top.html');?>
	
		<div class="wrapW">
			<?php include Template::t_include('member/money_view/money_inc.html');?>
			
			<div class="conRig_yc">
				<h3 class="dwH3_yc">消费记录</h3>
				<!-- <div class="timeBox">
					<span>选择日期：</span>
					<strong><input type="text" class="moneyIn"><i class="timeIcon"></i></strong>
					<span class="ml6">到</span>
					<strong class="ml6"><input type="text" class="moneyIn"><i class="timeIcon"></i></strong>
					<a href="javascript:;" class="timeA ml6">全部</a>
					<a href="javascript:;" class="timeA ml18">最近一周</a>
					<a href="javascript:;" class="timeA ml18">最近一个月</a>
					<a href="javascript:;" class="timeCX ml6">查询</a>
				</div> -->
				<table class="table_yc">
					<thead>
						<tr>
							<td><span>消费项目</span></td>
							<td><span>元宝</span></td>
							<td><span>操作时间</span></td>
						</tr>
					</thead>
					<tbody>
					<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
						<tr>
							<td><span>在<?php echo Template::addquote($v['memorial_name']);?>纪念馆购买了<?php echo Template::addquote($v['gname']);?> x<?php echo Template::addquote($v['num']);?></span></td>
							<td><span><?php echo Template::addquote($v['price']);?></span></td>
							<td><span><?php echo date('Y-m-d h:i:s', $v['addtime']);?></span></td>
						</tr>
					<?php $n++;} ?>
					</tbody>
				</table>
				<div class="pageF_yc">
					<?php echo $pagestr;?>
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
</html>
