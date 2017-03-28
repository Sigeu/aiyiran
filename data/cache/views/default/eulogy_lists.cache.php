<?php if(!defined('IN_MAINONE')) exit(); ?>
<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->


    <?php include Template::t_include('member/head_left.html');?>
			<div class="conRig_yc">
				<h3 class="dwH3_yc">纪念祭文</h3>
				<div class="mt20"><a href="/member/memorial/eulogyAdd/mid/<?php echo $mid;?>" class="btnCom_yc"><i></i>添加</a></div>
				<table class="table_yc">
					<thead>
						<tr>
							<td><span>标题名称</span></td>
							<td><span>分类名称</span></td>
							<td><span>发布时间</span></td>
							<td><span>操作</span></td>
						</tr>
					</thead>
					<tbody>
					<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
						<tr>
							<td><span><?php echo Template::addquote($v['ename']);?></span></td>
							<td><span>
							<?php $n=1;foreach($catList AS $k => $c) { $lastIndex= count($catList) == $n;?>
								<?php if($v['cid'] ==$c['id']) { ?><?php echo Template::addquote($c['name']);?><?php } ?>
							<?php $n++;} ?>
							</span></td>
							<td><span><?php echo Template::addquote($v['createtime']);?></span></td>
							<td>
								<a href="/member/memorial/eulogyUpdate/mid/<?php echo $mid;?>/id/<?php echo Template::addquote($v['id']);?>">修改</a>
								<a href="javascript:;" class="delEulogy" data="<?php echo Template::addquote($v['id']);?>"> | 删除</a>
							</td>
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
        $(".delEulogy").click(function () {
            var $this=$(this);

            var id = $(this).attr('data');
            layer.confirm('确认删除吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    type: "Post",
                    url: "/member/memorial/eulogyDel",
                    data: {'id':id},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                                $this.parent().parent().remove();
                            });
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
