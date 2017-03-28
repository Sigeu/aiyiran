<?php if(!defined('IN_MAINONE')) exit(); ?>

		<meta charset="UTF-8">
		<title>祭拜记录--我贡献的祭品</title>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
    <?php include Template::t_include('member/head_top.html');?>

        <div class="wrapW">
            
            <?php include Template::t_include('member/recording_view/recording_inc.html');?>
            <div class="conRig_yc">
                <h3 class="dwH3_yc">我贡献的祭品</h3>
                <table class="table_yc">
                    <thead>
                        <tr>
                            <td><span>祭品物品</span></td>
                            <td><span>纪念馆</span></td>
                            <td><span>贡献时间</span></td>
                            <!-- <td><span>操作</span></td> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
                        <tr>
                            <td class="firstTd_yc"><img src="<?php echo Template::addquote($v['goods_img']);?>" alt="献花"><span><?php echo Template::addquote($v['gname']);?></span></td>
                            <td><span><?php echo Template::addquote($v['name']);?></span></td>
                            <td><span><?php echo date('Y-m-d h:i:s', $v['addtime']);?></span></td>
<!--                             <td>
                                <a href="javascript:;" onclick="clearJipin(<?php echo Template::addquote($v['id']);?>)">撤销祭品</a>
                            </td> -->
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
<script>
    function clearJipin(id)
    {
        layer.confirm('确认撤销吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type: "Post",
                url: "/member/Recharge/clearJipin",
                data: {'id':id},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                             location.reload();
                        });
                    }else{
                        layer.msg(data.msg, {icon: 2, offset: '40%'});
                    }
                }
            });
        }, function(){
            layer.closeAll();
        });
    }
</script>