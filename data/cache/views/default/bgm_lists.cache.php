<?php if(!defined('IN_MAINONE')) exit(); ?>

		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
        <script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>



<?php include Template::t_include('member/head_left.html');?>

			<div class="conRig_yc">
				<h3 class="dwH3_yc">背景音乐管理</h3>
				<div class="playBox">
					<div class="playDiv">
						<span>自动播放</span><label><input type="radio" name="play" value="1" 
                        class="" onclick="auto_play(1, <?php echo $mid;?>)" <?php if($auto['auto_play']==1) { ?>checked=''<?php } ?>>是</label><label><input type="radio" name="play" value="2" class="" onclick="auto_play(2, <?php echo $mid;?>)"  <?php if($auto['auto_play']==2) { ?>checked=''<?php } ?>>否</label>
					</div>
					<!-- <div class="botPlay playDiv">
						<span>播放形式</span><label><input type="radio" name="style" value="" checked class="">自动播放</label><label><input type="radio" name="style" value="" class="">随机播放</label><label><input type="radio" name="style" value="" class="">单机播放</label>
					</div> -->
				</div>

                <script type="text/javascript">
                    function auto_play(val, mid)
                    {
                        $.ajax({
                            type: "Post",
                            url: "/member/memorial/modMusic",
                            data: {'auto':val,'mid':mid},
                            dataType: "json",
                           
                            success: function(data) {
                                if (data.status == 1) {
                                    // layer.msg(data.msg);
                                    // layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                                    //     location.reload();
                                    // });
                                }else{
                                   

                                }
                            }
                        });
                    }
                </script>
				<div class="clearfix">
					<div class="fl groupBox01">
						<div class="scDiv">
							<!-- <a href="javascript:;" class="scA_yc">上传音乐</a> -->
<input type="file" name="uploadify" id="uploadify"  />

							<span class="scSpan">（只能上传mp3格式音乐，上传完成后不要忘记将歌曲添加至“播放歌单”）</span>

						</div>

						<table class="table_yc">
							<thead>
								<tr>
									<td><span>序号</span></td>
									<td><span>音乐名</span></td>
									<td><span>来源</span></td>
									<td><span>状态</span></td>
									<td><span>操作</span></td>
								</tr>
							</thead>
							<tbody>
							<?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
								<tr>
									<td><span><?php echo Template::addquote($v['id']);?></span></td>
									<td><span><?php echo Template::addquote($v['name']);?></span></td>
									<td><span>
                                            <?php if($v['userid']) { ?>
                                            个人
                                            <?php } else { ?>
                                            系统
                                            <?php } ?>
                                    </span></td>
									<td><span>
										<?php if($v['status']== 1) { ?>
										通过
										<?php } elseif ($v['status']== 2) { ?>
										不通过
										<?php } else { ?>未审核<?php } ?></span>
									</td>
									<td>
										<a href="javascript:;" target="_self" path="<?php echo Template::addquote($v['musicpath']);?>" title="<?php echo Template::addquote($v['name']);?>" class="Audition">试听</a>
										<!-- <a href="javascript:;"> | 添加至歌单</a> -->
										<a href="javascript:;" target="_self" onclick="renameMusic(<?php echo Template::addquote($v['id']);?>, '<?php echo Template::addquote($v['name']);?>')"> | 重命名</a>
                                        <a href="javascript:;" target="_self" onclick="deleteMusic(<?php echo Template::addquote($v['id']);?>)"> | 删除</a>
										<a href="javascript:;" target="_self" onclick="addMusicList(<?php echo Template::addquote($v['id']);?>)"> | 添加至歌单</a>
									</td>
								</tr>
							<?php $n++;} ?>
							</tbody>
						</table>
					</div>
					<div class="fl groupBox02">

						<!-- <div class="playGroup">
							<span class="musicT">当前音乐：<em>远方的朋友</em></span><a href="javascript:;" class="playA"></a><a href="javascript:;" class="nextA"></a><em class="timeEm">01:09</em><div class="bgDiv bgDiv01"><span></span></div><em class="timeEm">03:34</em><a href="javascript:;" class="voiceS"></a><div class="bgDiv bgDiv02"><span></span></div>
						</div> -->

                        <div class="playGroup">
                            <?php include Template::t_include('member/memorial_view/inc_music.html');?>
                        </div>

						<p class="songM">歌单</p>
						<table class="table_yc">
							<thead>
								<tr>
									<td><span>音乐名</span></td>
									<td><span>操作</span></td>
								</tr>
							</thead>
							<tbody>
                            <?php $n=1;foreach($music AS $k => $v) { $lastIndex= count($music) == $n;?>
								<tr>
									<td><span><?php echo Template::addquote($v['name']);?></span></td>
									<td>
										<a href="javascript:;" path="<?php echo Template::addquote($v['musicpath']);?>" title="<?php echo Template::addquote($v['name']);?>" class="Audition">试听</a>
										<a href="javascript:;" onclick="removeMusic(<?php echo Template::addquote($v['id']);?>)"> | 删除</a>
										<!-- <a href="javascript:;"> | 上移</a> -->
										<!-- <a href="javascript:;"> | 下移</a> -->
									</td>
								</tr>
							<?php $n++;} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="wrapS03_yc jbFT_yc">
			<p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
		</div>
	</body>
		<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
		<script type="text/javascript" src="/template/default/member/js/common.js" ></script>
	</html>

		<script type="text/javascript" src="/template/default/member/js/uploadify/jquery.uploadify.js" ></script>
		<link rel="stylesheet" href="/template/default/member/js/uploadify/uploadify.css">

<script>
    //设置一个时间戳
    <?php  $timestamp = time();?>
    $(function(){
        $("#uploadify").uploadify({
            'formData' :{
                'timestamp' : '<?php echo $timestamp;?>', //输入设置好的时间戳
                'token' : '<?php echo md5('unique_salt' . $timestamp);?>', //设置一个md5字符串
				'mid' : '<?php echo $_GET['mid'];?>'
            },
            'auto': true, //是否自动上传
            'debug': false, //是否开启浏览器调试
            'buttonText': '上传音乐', //上传按钮的文字
            'fileTypeExts': '*.mp3', //允许的图片类型
            'fileSizeLimit': '20MB', //单张图片的最大值
            'multi': false, //时运允许多张图片一起上传
            'removeCompleted' : false,
            'swf' : '/template/default/member/js/uploadify/uploadify.swf',
            'uploader' : '/member/Memorial/upBgm',
            'onUploadSuccess' : function(file,data,response){
            	console.log(data);
            	var obj = jQuery.parseJSON(data);
                    console.log(obj);
                    if(obj.code==200){
                        // var str= '<img src="'+obj.savepath+'">';
                        // $("#con").append(str);
                        // $(".uploadify-queue-item").hide();
                        // $(".suc").html('上传成功');
                        setTimeout(function(){location.reload();},1000);
                    }else{
                        alert(obj.errorMsg);
                    }
                }
        });
    });

</script>
