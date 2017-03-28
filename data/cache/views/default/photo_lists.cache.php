<?php if(!defined('IN_MAINONE')) exit(); ?>

		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<?php include Template::t_include('member/head_left.html');?>

		<!-- 确认删除弹层 -->
		<div class="bg_yc02"></div>
		<div class="bgBox02"></div>
		<div class="notiBox">
			<div class="handTop">
				<span class="handS">操作提示</span><em class="handEm"></em>
			</div>
			<div class="notiBot">
				<p class="handSure">确定删除该相册吗？</p>
				<p class="deleteP">删除后本集中的图片将移至默认相册集。</p>
				<div class="sureD sureD02">
					<a href="javascript:;" class="sure">确认删除</a><a href="javascript:;" class="concle">取消</a>
				</div>
			</div>
		</div>

		<!-- 上传照片弹层 -->
		<div class="bg_yc02 bg_yc022"></div>
		<div class="bgBox03 bgBox032"></div>
		<div class="scPoBox scPoBox2">
			<div class="handTop">
				<span class="handS">上传照片</span><em class="handEm"></em>
			</div>
			<div class="commonBot">
				<form id="formToUpdate" method="post" action="#" enctype="multipart/form-data">
				<ul>
					<li>
						<span class="passSa">名称：</span><input type="text" name="name" placeholder="请输入图片名称" class="passInp">
					</li>
					<li>
						<span class="passSa">选择相册：</span><select name="pid" class="zjSel">
						<option value="<?php echo Template::addquote($default[id]);?>"><?php echo Template::addquote($default['name']);?></option>
						<?php $n=1;foreach($photo_lists AS $k => $v) { $lastIndex= count($photo_lists) == $n;?>
							<option value="<?php echo Template::addquote($v['id']);?>"><?php echo Template::addquote($v['name']);?></option>
						<?php $n++;} ?>
						</select>
					</li>
					<li>
						<input type="hidden" name="mid" value="<?php echo $mid;?>">
						<span class="passSa">选择照片：</span><input type="text" class="passInp loadpic"><a href="javascript:;" class="fileA"><input type="file" name="photo" class="scInp">上传</a>
					</li>
					<li>
						<div class="liBtn">
							<a href="javascript:;" class="poSuc" id="photoUpload">上传照片</a><a href="javascript:;" class="poFai">取消</a>
						</div>
					</li>
				</ul>
				</form>
			</div>
		</div>
		<script>
			$(function(){
                $("#photoUpload").click(function(){
                    $('.loadpic').val('上传中..');
                    $("#formToUpdate").ajaxSubmit({
                        type:'post',
                        url:'/member/Memorial/photoUpload',
                        success:function(data){
                            var member = eval("("+data+")"); //包数据解析为json 格
                            if(member.status ==1){
//                                layer.alert(member.message, {icon: 1,offset: '40%'});
                                setTimeout("window.location.href='/member/memorial/photo/mid/<?php echo $mid;?>'",2000);
                            }else{
                                layer.alert(member.message, {icon: 2,offset: '40%'});
                            }
                        }
                    });
                });
			})
		</script>
		<!-- 上传照片弹层结束 -->

		<!--设置照片弹出层-->
		<div class="bg_yc02 bg_yc021"></div>
		<div class="bgBox03 bgBox031"></div>
		<div class="scPoBox scPoBox1">
			<div class="handTop">
				<span class="handS">修改相册</span><em class="handEm"></em>
			</div>
			<div class="commonBot">
				<form id="updateCate" method="post" action="#" enctype="multipart/form-data">
					<ul>
						<li>
							<span class="passSa">新的名称：</span><input type="text" name="name" id="name_set" placeholder="请输入图片名称" class="passInp">
						</li>
						<li>
							<span class="passSa">公开方式：</span><select name="auth" id="auth_cate" class="zjSel">
							<option value="1">完全公开</option>
							<option value="2">仅馆主可见</option>
						</select>

						<li>
							<div class="liBtn">
								<a href="javascript:;" class="poSuc" id="photoCate">确定</a><a href="javascript:;" class="poFai">取消</a>
							</div>
						</li>
					</ul>
				</form>
			</div>
		</div>
		<script>
            $(function(){
                // 照片设置
                $(".greenA1").click(function(){
                    $("#name_set").val(''); //清空name值
                    var setID = $(this).attr('data');//获取设置相册分类的id

                    $(".bg_yc021,.bgBox031,.scPoBox1").show();
					$("#photoCate").click(function(){
                        var auth =$('#auth_cate').find("option:selected").val() //获取权限
						var name= $("#name_set").val();
						$("#updateCate").ajaxSubmit({
							type:'post',
							url:'/member/Memorial/updateCate',
							data:{'id':setID,'name':name,'auth':auth},
							success:function(data){
								var member = eval("("+data+")"); //包数据解析为json 格
								if(member.status ==1){
	                                layer.alert(member.message, {icon: 1,offset: '40%'});
									setTimeout("window.location.href='/member/memorial/photo/mid/<?php echo $mid;?>'",2000);
								}else{
									layer.alert(member.message, {icon: 2,offset: '40%'});
								}
							}
						});
					});
                });
            })
		</script>
		<!--设置照片弹结束-->



			<div class="conRig_yc">
				<h3 class="dwH3_yc">相册视频管理</h3>
				<div class="filePo">
					<a href="javascript:;" class="poSuc clickSC">上传照片</a><a href="/member/Memorial/createPhoto/mid/<?php echo $mid;?>" class="poCre">创建相册</a>
				</div>

				<ul class="clearfix photoUl">
					<li>
						<div class="photoD">
							<a href="/member/Memorial/photoInfo/mid/<?php echo $mid;?>/default/<?php echo Template::addquote($default['id']);?>"><img src="/template/default/member/images/photo.jpg"></a>
						</div>
						<p class="photoP">默认相册</p>
						<div class="photoBox">
							<!-- <a href="javascript:;" class="greenA">设置</a><a href="javascript:;" class="redA removeA">删除</a> -->
						</div>
					</li>
					<?php $n=1;foreach($photo_lists AS $k => $v) { $lastIndex= count($photo_lists) == $n;?>
					<li>
						<div class="photoD">
							<a href="/member/Memorial/photoInfo/mid/<?php echo $mid;?>/id/<?php echo Template::addquote($v['id']);?>"><img src="<?php echo Template::addquote($v['cover']);?>" height="220" width="220" /></a>
						</div>
						<p class="photoP"><?php echo Template::addquote($v['name']);?></p>
						<div class="photoBox">
							<a href="javascript:;" class="greenA greenA1" data="<?php echo Template::addquote($v['id']);?>">设置</a><a href="javascript:;" class="redA removeA" data="<?php echo Template::addquote($v['id']);?>" mid="<?php echo $mid;?>">删除</a>
						</div>
					</li>
					<?php $n++;} ?>
				</ul>
				<div class="pageF_yc">
					<?php echo $pagestr;?>
				</div>
				<!-- <div class="filePo">
					<a href="javascript:;" class="poSuc">上传视频</a>
				</div>
				<ul class="clearfix photoUl">
					<li>
						<div class="videoD">
							<a href="javascript:;" class="viedoA">
								<img src="images/video.png">
							</a>
						</div>
						<p class="photoP">视频1</p>
						<div class="photoBox">
							<a href="javascript:;" class="greenA">设置</a><a href="javascript:;" class="redA">使用</a>
						</div>
					</li>
					<li>
						<div class="videoD">
							<a href="javascript:;" class="viedoA">
								<img src="images/video.png">
							</a>
						</div>
						<p class="photoP">视频1</p>
						<div class="photoBox">
							<a href="javascript:;" class="greenA">设置</a><a href="javascript:;" class="redA">删除</a>
						</div>
					</li>
				</ul> -->
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
			// 删除照片分类
			$(".removeA").click(function(){
				var $this=$(this);
				var id = $this.attr('data');
				var mid = $this.attr('mid');
				$(".bg_yc02,.bgBox02,.notiBox").show();
				$(".sure").unbind("click").click(function(){
                    $.ajax({
                        type: "Post",
                        url: "/member/memorial/delPhotoCat",
                        data: {'id':id, 'mid':mid},
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 1) {
                                layer.alert(data.message, {icon: 1,offset: '40%'});
                                $(".bg_yc02,.bgBox02,.notiBox").hide();
                                $this.parents("li").remove();
                            } else {
                                layer.alert(data.message, {icon: 2,offset: '40%'});
                                return false;
                            };
                        }
                    });

				});
				$(".concle").unbind("click").click(function(){
					$(".bg_yc02,.bgBox02,.notiBox").hide();
				});
			});
			// 上传照片
			$(".clickSC").click(function(){
				$(".bg_yc022,.bgBox032,.scPoBox2").show();
			});

			// 公共弹层关闭
			$(".handEm").click(function(){
				$(".bg_yc02,.bgBox02,.notiBox,.bgBox03,.scPoBox").hide();
			});
		});
	</script>
</html>
