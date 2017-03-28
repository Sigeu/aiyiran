<?php if(!defined('IN_MAINONE')) exit(); ?>
<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->

<?php include Template::t_include('member/head_left.html');?>

			<div class="conRig_yc">
				<h3 class="dwH3_yc">留言管理</h3>
				<!-- <div class="mt20"><a href="/member/memorial/eulogyAdd/mid/<?php echo $mid;?>" class="btnCom_yc"><i></i>添加</a></div> -->
				<table class="table_yc">
					<thead>
						<tr>
							<td><span>留言内容</span></td>
							<td><span>发布时间</span></td>
							<!-- <td><span>操作</span></td> -->
						</tr>
					</thead>
					<tbody>
					<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
						<tr>
							<td><span><?php echo csubstr($v['content'],20);?></span></td>
							<td><span><?php echo date('Y-m-d h:i:s', $v['addtime']);?></span></td>
							<!-- <td>
								<a href="javascript:;" data="<?php echo Template::addquote($v['id']);?>" class="delMessage"> 删除 </a>
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

		<script>
			$(function () {
				$(".delMessage").click(function () {
                    var $this=$(this);
                    var id = $(this).attr('data');
                    layer.confirm('确认删除吗？', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        $.ajax({
                            type: "Post",
                            url: "/member/memorial/message",
                            data: {'id':id},
                            dataType: "json",
                            success: function(data) {
                                if (data.status == 1) {
                                    layer.msg(data.msg, {icon: 1, offset: '40%'});
                        			$this.parent().parent().remove();
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
