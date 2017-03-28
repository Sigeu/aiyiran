<?php if(!defined('IN_MAINONE')) exit(); ?>

	<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
	<link rel="stylesheet" type="text/css" href="/template/default/member/css/memorial_yc.css"/>
	<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->

<?php include Template::t_include('member/head_top.html');?>


	<div class="wrapCon_yc">
		<h3 class="h3Com_yc"><span></span>纪念馆管理</h3>
		<div class="tabUl_yc">
			<ul class="clearfix">
				<li><a href="/member/memorial/lists">我的纪念馆</a></li>
				<li><a href="/member/memorial/follow">我关注的馆</a></li>
				<li><a href="/member/memorial/create" class="active"><span class="add_yc"></span>创建新馆</a></li>
			</ul>
		</div>
		<form action="" method="post">
		<div class="form_yc">
			<div class="formList_yc">
				<span class="titS_yc">逝者姓名：</span><input type="text" name="personname" placeholder="逝者姓名" class="inputCom_yc">
				<select name="catid" class="slCom_yc" id="catid">
                    <option value="">请选择纪念馆类型</option>
					<option value="1">私人纪念馆</option>
					<option value="2">名人纪念馆</option>
				</select>
				<select name="persontype" id="persontype" class="slCom_yc">
					<option value="">请选择</option>
					<?php $n=1;foreach($person_type AS $k => $v) { $lastIndex= count($person_type) == $n;?>
					<option value="<?php echo $k;?>"><?php echo $v;?></option>
					<?php $n++;} ?>
				</select>
				<em class="egEm_yc">例：如逝者是您的“<b>祖先</b>”，则选择“<b>祖先</b>”</em>
			</div>
	<!-- 		<div class="formList_yc">
				<span class="titS_yc">纪念馆馆名称：</span><input type="text" name="name" placeholder="名称" class="inputCom_yc"><strong class="jinSt_yc">纪念馆</strong>
			</div> -->
			<div class="formList_yc clearfix">
				<span class="titS_yc fl">模板风格：</span>
				<ul class="clearfix fl mobile_yc" style="height:auto;">
					<?php $n=1;foreach($type_lists AS $k => $v) { $lastIndex= count($type_lists) == $n;?>
					<li data="<?php echo Template::addquote($v['id']);?>">
						<div class="boxD_yc">
							<div class="imgDiv_yc">
								<img src="/static/uploadfile/<?php echo Template::addquote($v['pic']);?>">
							</div>
							<div class="mask_yc">
								<i></i>
							</div>
						</div>
						<p class="clearfix textP_yc"><span class="fl"><?php echo Template::addquote($v['name']);?></span><span class="fr"><a href="javascript:;" class="pvw_yc">预览</a><a href="javascript:;" class="borA_yc"> | 使用</a></span></p>
					</li>
					<?php $n++;} ?>
				</ul>
				<p class="agree_yc"><input type="checkbox" name="is_read" id="is_read" value="1"><label for="is_read">我同意《天堂之网免责声明》</label></p>
				<div class="sucesD_yc" id="memorial_create"><a href="javascript:;" class="success_yc" >完成</a></div>
			</div>
		</div>
		</form>
	</div>
	<div class="wrapS03_yc jbFT_yc">
		<p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
	</div>
	<script>
        $(function (){
            $("#memorial_create").click(function (){
//                var that = this;
//                layer.tips('只想提示地精准些', that); return false;
                var personname = $('input[name="personname"]').val();
                var catid = $('#catid option:selected').val();
                var persontype = $('#persontype option:selected').val();
                // var name = $('input[name="name"]').val();
                var is_read = $('input[name="is_read"]').val();
                var style_id = $('.mobile_yc .active').attr('data');

                var isor = $('#is_read').is(':checked');
                if(isor == false){
                    layer.alert('请同意条款申明', {icon: 2,offset: '40%'});
                            return false; 
                }

                $.ajax({
                    type: "Post",
                    url: "/member/memorial/create",
                    data: {"personname":personname, "catid":catid,
						"name":name, "is_read":is_read, "style_id":style_id, 'persontype':persontype},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            var index = layer.alert(data.msg, {icon: 1,offset: '40%',
                            yes: function(index, layero){
                                window.location.href='/member/memorial/lists';
                                layer.close(index); //如果设定了yes回调，需进行手工关闭
                            }
                            });
                        } else {
                            layer.alert(data.msg, {icon: 2,offset: '40%',
                        
                        });
                            return false;
                        };
                    }
                });

            });
        });
	</script>

<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
<script type="text/javascript" src="/template/default/member/js/common.js" ></script>
<script type="text/javascript">
	$(function(){
		// 模板风格
		$(".boxD_yc,.borA_yc").click(function(){
			var $liP=$(this).parents("li");
			var $othliP=$liP.siblings("li");
			$liP.addClass("active");
			$othliP.removeClass("active");
		});
		// 预览
		$("body").on("click",".pvw_yc",function(){
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
