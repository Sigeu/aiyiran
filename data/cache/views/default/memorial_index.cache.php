<?php if(!defined('IN_MAINONE')) exit(); ?>

<?php include Template::t_include('inc/memorial_head.html');?>

<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>
<style>
    .page a{
        cursor: pointer;}
</style>

			<!--**********************************-->
			<div class="set_worship" style="background: url(/static/uploadfile<?php echo Template::addquote($style['pic']);?>) no-repeat bottom left;">
				<div class="scenes_container">
					<div class="epitaph">
						<div class="left_mzm">
						<?php echo Template::addquote($muzhimin['epitaph']);?>
						</div>
						<div class="mid_head">
							<img src="<?php echo Template::addquote($info['userpic']);?>" />
							<div class="user_n">
								<?php echo Template::addquote($info['name']);?> <span>之墓</span>
							</div>
						</div>
						<div class="right_set_p">
							<span style="display: block; margin-bottom: 10px;">立碑人</span><?php echo Template::addquote($muzhimin['steleauthor']);?>
						</div>
					</div>

					<!-- 已购买的商品，在纪念堂展示 -->
					<?php $n=1;foreach($goods AS $k => $v) { $lastIndex= count($goods) == $n;?>
											<!-- bid就是已购买的商品主键id -->
					<?php if($v['uid']==$uid) { ?>
						<div class="drag_img drag_img2" bid="<?php echo Template::addquote($v['id']);?>"
					<?php } else { ?>
						<div class="drag_img"
					<?php } ?>

					<?php if($v['goods_x']) { ?>style="left:<?php echo Template::addquote($v['goods_x']);?>px; top:<?php echo Template::addquote($v['goods_y']);?>px"
					<?php } else { ?><?php } ?>
					>
						<img src="<?php echo Template::addquote($v['goods_img']);?>">
					</div>
					<?php $n++;} ?>

				</div>
				<div class="r_menu">
					<ul>
						<?php $n=1;foreach($goods_list AS $k => $v) { $lastIndex= count($goods_list) == $n;?>
						<?php $k++; ?>
						<li class="jp_<?php echo $k;?>"><a href="javascript:;"><i></i><?php echo Template::addquote($v['cate']);?></a></li>
						<?php $n++;} ?>
					</ul>
					<?php if($uid) { ?>
						<span class="jp_6 jp_7"><a href="javascript:;">祭品箱</a></span>
					<?php } else { ?>
						<span class="jp_6"><a href="javascript:;" onclick="isLogin();">祭品箱</a></span>
					<?php } ?>
				</div>
				<?php if($left_info) { ?>
				<div class="music">
					<img src="<?php echo Template::addquote($left_info['user_photo']);?>" />
					<h3 ><span ><?php echo csubstr($left_info["username"],10);?></span>
						<div class="audio_div">
							<input type="button" name="" id="on_off" value="" />
					        <audio id="mp3Btn"
								   <?php if($auto_play['auto_play']==1) { ?>
								   autoplay="autoplay"
									<?php } else { ?>
							<?php } ?>
							>
								<?php $n=1;foreach($getMusicLists AS $k => $v) { $lastIndex= count($getMusicLists) == $n;?>
					        	<source src="<?php echo Template::addquote($v['musicpath']);?>" type="audio/mp3" />
								<?php $n++;} ?> 
					        </audio>
						</div>
					</h3>
					<p><span>元宝：<i><?php echo Template::addquote($left_info['point']);?></i></span><a href="/member/Recharge/online">充值</a></p>
				</div>
				<?php } ?>
		    </div>
		    <div class="shop-content">
		    	<div class="shop-content_box">
		    	<a href="###" class="close">X</a>
		            <ul class="tab">
		            	<li class="all"><a href="###">全部</a></li>
						<?php $n=1;foreach($goods_list AS $k => $v) { $lastIndex= count($goods_list) == $n;?>
						<?php $k++; ?>
						<li class="jp_<?php echo $k;?>"><a href="###"><i></i><?php echo Template::addquote($v['cate']);?></a></li>
						<?php $n++;} ?>
					</ul>

					<!-- 全部商品开始 -->
 		    	<div class="ShopList">
 		    		<ul id="goods_all_pagenum">
 		    			<?php $n=1;foreach($goods_all AS $k => $v) { $lastIndex= count($goods_all) == $n;?>
 		    			<li data-goodsid="<?php echo Template::addquote($v['id']);?>" data-mid="<?php echo $mid;?>" data-gname="<?php echo Template::addquote($v['gname']);?>" data-img="<?php echo Template::addquote($v['pic']);?>" data-price="<?php echo Template::addquote($v['price']);?>" onclick="showBuy(this)">
 		    				<a href="###">
 		    				<img src="<?php echo Template::addquote($v['pic']);?>" />
 		    				<h4><?php echo Template::addquote($v['gname']);?></h4>
 		    				<p><span class="fl"><?php echo Template::addquote($v['gtime']);?>天</span><em class="fr"><?php echo Template::addquote($v['price']);?>元宝</em></p>
 		    				</a>
 		    				<div class="goods_info">
 		    					<h3><?php echo Template::addquote($v['gname']);?></h3>
 		    					<p><?php echo Template::addquote($v['summary']);?></p>
 		    					<span>价格：<?php echo Template::addquote($v['price']);?>元宝</span>
 		    					<em>时效：<?php echo Template::addquote($v['gtime']);?>天</em>
 		    				</div>
 		    			</li>
 		    			<?php $n++;} ?>
 		    		</ul>
 		    		<div class="page">
		     		<?php for($i=1;$i<=$goods_all_pagenum;$i++){ ;?>
                            <a onclick="goods_all_pagenum(<?php echo $i;?>,<?php echo $goods_all_num;?>,<?php echo $mid;?>)"><?php echo $i;?></a>
                    <?php } ;?>
		     	</div>
 		    	</div>
 		    	<!-- 全部商品结束 -->

 		    	<!-- 花朵 -->
 		    	<div class="ShopList">
 		    		<ul id="xianhua">
 		    			<?php $n=1;foreach($xianhua AS $k => $v) { $lastIndex= count($xianhua) == $n;?>
                        <li data-goodsid="<?php echo Template::addquote($v['id']);?>" data-mid="<?php echo $mid;?>" data-gname="<?php echo Template::addquote($v['gname']);?>" data-img="<?php echo Template::addquote($v['pic']);?>" data-price="<?php echo Template::addquote($v['price']);?>" onclick="showBuy(this)">
 		    				<a href="###">
 		    				<img src="<?php echo Template::addquote($v['pic']);?>" />
 		    				<h4><?php echo Template::addquote($v['gname']);?></h4>
 		    				<p><span class="fl"><?php echo Template::addquote($v['gtime']);?>天</span><em class="fr"><?php echo Template::addquote($v['price']);?>元宝</em></p>
 		    				</a>
 		    				<div class="goods_info">
 		    					<h3><?php echo Template::addquote($v['gname']);?></h3>
 		    					<p><?php echo Template::addquote($v['summary']);?></p>
 		    					<span>价格：<?php echo Template::addquote($v['price']);?>元宝</span>
 		    					<em>时效：<?php echo Template::addquote($v['gtime']);?>天</em>
 		    				</div>
 		    			</li>
 		    			<?php $n++;} ?>
 		    		</ul>
 		    		<div class="page">
			     	<?php for($i=1;$i<=$xianhua_pagenum;$i++){ ;?>
                            <a onclick="xianhua_pagenum(<?php echo $i;?>,<?php echo $xianhua_num;?>,<?php echo $mid;?>)"><?php echo $i;?></a>
                    <?php } ;?>
		     		</div>
 		    	</div>

 		    	<!-- 上香 -->
 		    	<div class="ShopList">
 		    		<ul id="shang">
 		    			<?php $n=1;foreach($shang AS $k => $v) { $lastIndex= count($shang) == $n;?>
                        <li data-goodsid="<?php echo Template::addquote($v['id']);?>" data-mid="<?php echo $mid;?>" data-gname="<?php echo Template::addquote($v['gname']);?>" data-img="<?php echo Template::addquote($v['pic']);?>" data-price="<?php echo Template::addquote($v['price']);?>" onclick="showBuy(this)">
 		    				<a href="###">
 		    				<img src="<?php echo Template::addquote($v['pic']);?>" />
 		    				<h4><?php echo Template::addquote($v['gname']);?></h4>
 		    				<p><span class="fl"><?php echo Template::addquote($v['gtime']);?>天</span><em class="fr"><?php echo Template::addquote($v['price']);?>元宝</em></p>
 		    				</a>
 		    				<div class="goods_info">
 		    					<h3><?php echo Template::addquote($v['gname']);?></h3>
 		    					<p><?php echo Template::addquote($v['summary']);?></p>
 		    					<span>价格：<?php echo Template::addquote($v['price']);?>元宝</span>
 		    					<em>时效：<?php echo Template::addquote($v['gtime']);?>天</em>
 		    				</div>
 		    			</li>
 		    			<?php $n++;} ?>
 		    		</ul>
 		    		<div class="page">
			     		<?php for($i=1;$i<=$shang_pagenum;$i++){ ;?>
                            <a onclick="shang(<?php echo $i;?>,<?php echo $shang_num;?>,<?php echo $mid;?>)"><?php echo $i;?></a>
                        <?php } ;?>
		     		</div>
 		    	</div>

 		    	<!-- 点烛 -->
 		    	<div class="ShopList">
 		    		<ul id="dian">
 		    			<?php $n=1;foreach($dian AS $k => $v) { $lastIndex= count($dian) == $n;?>
                        <li data-goodsid="<?php echo Template::addquote($v['id']);?>" data-mid="<?php echo $mid;?>" data-gname="<?php echo Template::addquote($v['gname']);?>" data-img="<?php echo Template::addquote($v['pic']);?>" data-price="<?php echo Template::addquote($v['price']);?>" onclick="showBuy(this)">
 		    				<a href="###">
 		    				<img src="<?php echo Template::addquote($v['pic']);?>" />
 		    				<h4><?php echo Template::addquote($v['gname']);?></h4>
 		    				<p><span class="fl"><?php echo Template::addquote($v['gtime']);?>天</span><em class="fr"><?php echo Template::addquote($v['price']);?>元宝</em></p>
 		    				</a>
 		    				<div class="goods_info">
 		    					<h3><?php echo Template::addquote($v['gname']);?></h3>
 		    					<p><?php echo Template::addquote($v['summary']);?></p>
 		    					<span>价格：<?php echo Template::addquote($v['price']);?>元宝</span>
 		    					<em>时效：<?php echo Template::addquote($v['gtime']);?>天</em>
 		    				</div>
 		    			</li>
 		    			<?php $n++;} ?>
 		    		</ul>
 		    		<div class="page">
			     		<?php for($i=1;$i<=$dian_pagenum;$i++){ ;?>
                            <a onclick="dian(<?php echo $i;?>,<?php echo $shang_num;?>,<?php echo $mid;?>)"><?php echo $i;?></a>
                        <?php } ;?>
		     		</div>
 		    	</div>

 		    	<!-- 祭品 -->
 		    	<div class="ShopList">
 		    		<ul id="jiping">
 		    			<?php $n=1;foreach($jiping AS $k => $v) { $lastIndex= count($jiping) == $n;?>
                        <li data-goodsid="<?php echo Template::addquote($v['id']);?>" data-mid="<?php echo $mid;?>" data-gname="<?php echo Template::addquote($v['gname']);?>" data-img="<?php echo Template::addquote($v['pic']);?>" data-price="<?php echo Template::addquote($v['price']);?>" onclick="showBuy(this)">
 		    				<a href="###">
 		    				<img src="<?php echo Template::addquote($v['pic']);?>" />
 		    				<h4><?php echo Template::addquote($v['gname']);?></h4>
 		    				<p><span class="fl"><?php echo Template::addquote($v['gtime']);?>天</span><em class="fr"><?php echo Template::addquote($v['price']);?>元宝</em></p>
 		    				</a>
 		    				<div class="goods_info">
 		    					<h3><?php echo Template::addquote($v['gname']);?></h3>
 		    					<p><?php echo Template::addquote($v['summary']);?></p>
 		    					<span>价格：<?php echo Template::addquote($v['price']);?>元宝</span>
 		    					<em>时效：<?php echo Template::addquote($v['gtime']);?>天</em>
 		    				</div>
 		    			</li>
 		    			<?php $n++;} ?>
 		    		</ul>
 		    		<div class="page">
			     		<?php for($i=1;$i<=$jiping_pagenum;$i++){ ;?>
                            <a onclick="jiping(<?php echo $i;?>,<?php echo $shang_num;?>,<?php echo $mid;?>)"><?php echo $i;?></a>
                        <?php } ;?>
		     		</div>
 		    	</div>

 		    	<!-- 装饰 -->
 		    	<div class="ShopList">
 		    		<ul id="zhuangshi">
 		    			<?php $n=1;foreach($zhuangshi AS $k => $v) { $lastIndex= count($zhuangshi) == $n;?>
                        <li data-goodsid="<?php echo Template::addquote($v['id']);?>" data-mid="<?php echo $mid;?>" data-gname="<?php echo Template::addquote($v['gname']);?>" data-img="<?php echo Template::addquote($v['pic']);?>" data-price="<?php echo Template::addquote($v['price']);?>" onclick="showBuy(this)">
 		    				<a href="###">
 		    				<img src="<?php echo Template::addquote($v['pic']);?>" />
 		    				<h4><?php echo Template::addquote($v['gname']);?></h4>
 		    				<p><span class="fl"><?php echo Template::addquote($v['gtime']);?>天</span><em class="fr"><?php echo Template::addquote($v['price']);?>元宝</em></p>
 		    				</a>
 		    				<div class="goods_info">
 		    					<h3><?php echo Template::addquote($v['gname']);?></h3>
 		    					<p><?php echo Template::addquote($v['summary']);?></p>
 		    					<span>价格：<?php echo Template::addquote($v['price']);?>元宝</span>
 		    					<em>时效：<?php echo Template::addquote($v['gtime']);?>天</em>
 		    				</div>
 		    			</li>
 		    			<?php $n++;} ?>
 		    		</ul>
 		    		<div class="page">
			     		<?php for($i=1;$i<=$zhuangshi_pagenum;$i++){ ;?>
                            <a onclick="zhuangshi(<?php echo $i;?>,<?php echo $shang_num;?>,<?php echo $mid;?>)"><?php echo $i;?></a>
                        <?php } ;?>
		     		</div>
 		    	</div>



		        </div>
		    </div>

		    <div id="layer-goods" class="buy_goods" data-goodsid="" data-mid="" data-gname="" data-img="" data-price="" style="display: none;">
		    	<div class="buy_cont">
		    		<h3>购买祭品</h3>
		    		<dl>
		    			<dt>
		    				<img src="<?php echo IMG_PATH;?>/scenes/jp_09.png" />
		    				<span>黄玫瑰</span>
		    			</dt>
		    			<dd>
		    				<p><em>数量：</em><!-- <span>-</span> --><input type="text" onkeyup="money_sel(this)" id="money_sel" value="1" /><!-- <span>+</span> --></p>
		    				<p><em>单价：</em><b class="price"></b> 元宝</p>
		    				<p><em>共计：</em><b class="all_price"></b> 元宝</p>
		    				<?php if($uid) { ?>
		    				<p><a href="javascript:;" class="confirm confirm2" >确认购买</a></p>
		    				<?php } else { ?>
		    				<p><a href="javascript:;" class="confirm" onclick="isLogin();">确认购买</a></p>
		    				<?php } ?>
		    			</dd>
		    		</dl>
		    		<a href="javascript:;" class="close" onclick="close_goods()">x</a>
		    	</div>
		    </div>

		    <div class="offer_box">
		    	<div class="offer_list">
		    		<h3 class="title_jpx">我的祭品箱</h3>
		    		<a href="###" class="close">X</a>
		    		<ul id="mybox">
		    		<?php $n=1;foreach($mybox AS $k => $v) { $lastIndex= count($mybox) == $n;?>
                        <!-- 检测纪念馆是否已经放置 -->
                        <?php if($v['place']==2) { ?>
		    			<li onclick="fangzhi(<?php echo Template::addquote($v['goods_id']);?>, <?php echo $mid;?>)" goods_id="<?php echo Template::addquote($v['goods_id']);?>" mid="<?php echo $mid;?>">
                        <a href="javascript:;">
                        <?php } else { ?>
                        <li goods_id="<?php echo Template::addquote($v['goods_id']);?>" mid="<?php echo $mid;?>" >
                        <a href="javascript:;" style="cursor: default;">
                        <?php } ?>
		    					<span><img src="<?php echo Template::addquote($v['pic']);?>" width="120" height="120" /></span>
		    					<h3><?php echo Template::addquote($v['gname']);?></h3>
		    					<p class="jb_who">
		    						<?php if($v['place']!=2) { ?>
		    							已摆放到<?php echo Template::addquote($v['name']);?>纪念堂
		    						<?php } else { ?>
		    							未摆放
		    						<?php } ?>
		    					</p>
		    					<p class="reman">剩余时间：<?php echo Template::addquote($v['end_time']);?></p>
		    					<!-- <p class="reman">剩余时间：22天22小时55分钟26秒</p> -->
		    				</a>
		    			</li>
		    		<?php $n++;} ?>
		    		</ul>
		    		<div class="page">
                        <?php for($i=1;$i<=$pagenum;$i++){ ;?>
                            <a onclick="setPage0(<?php echo $i;?>,<?php echo $pagenum;?>,<?php echo $mid;?>)"><?php echo $i;?></a>
                        <?php } ;?>
		     	</div>
		    	</div>

		    </div>
		    <div class="mask" style="display: none;"></div>
		    <div class="mask2" style="display: none;"></div>

<?php include Template::t_include('inc/inc_comment.html');?>


<!--<script type="text/javascript">-->
<!--$(function(){-->
    <!--function ityzl_SHOW_LOAD_LAYER(){-->
                <!--return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2-->
    <!--}-->
    <!--function ityzl_CLOSE_LOAD_LAYER(index){-->
            <!--layer.close(index);-->
    <!--}-->
    <!--$("#sub").click(function(){-->
        <!--$("#sub").attr("disabled","disabled");//按钮不可用-->
        <!--var content = $("textarea[name='content']").val();-->
        <!--var token_form = $("input[name='token_form']").val();-->
        <!--var VerifyCode = $("input[name='VerifyCode']").val();-->
        <!--var mid = $("input[name='mid']").val();-->
        <!--if(content==""){-->
            <!--layer.msg("请填写内容");-->
            <!--$("#sub").removeAttr("disabled");//按钮可用-->
            <!--return false;-->
        <!--}-->
        <!--// if(VerifyCode==""){-->
        <!--//     layer.msg("验证码不能为空");-->
        <!--//     $("#sub").removeAttr("disabled");//按钮可用-->
        <!--//     return false;-->
        <!--// }-->
         <!--$.ajax({-->
            <!--type: "Post",-->
            <!--url: "/jinian/Jinian/commentInsert",-->
            <!--data: {'content':content,'token_form':token_form,'VerifyCode':VerifyCode,'mid':mid},-->
            <!--dataType: "json",-->
            <!--beforeSend: function () {-->
                <!--i =ityzl_SHOW_LOAD_LAYER();-->
                <!--// $('#sub').val('发表追思留言中...');-->
            <!--},-->
            <!--complete: function () {-->
                 <!--ityzl_CLOSE_LOAD_LAYER(i);-->
                   <!--// $('#sub').val('发表追思留言');-->
            <!--},-->
            <!--success: function(data) {-->
                <!--if (data.status == 1) {-->
                    <!--// layer.msg(data.msg);-->
                    <!--// window.location.reload();-->
                    <!--layer.msg(data.msg, {icon: 1, offset: '40%'},function(){-->
                        <!--location.reload();-->
                    <!--});-->

                    <!--$('#form1')[0].reset();-->
                    <!--$("#sub").removeAttr("disabled");//按钮可用-->
                <!--}else{-->
                   <!--layer.msg(data.msg);-->
                    <!--$("#sub").removeAttr("disabled");//按钮可用-->

                <!--}-->
            <!--}-->
        <!--});-->
    <!--});-->
<!--});-->

    <!--function huan() {-->
        <!--var time = new Date().getTime();//当前时间-->
        <!--$('#yzm').attr("src" , "/static/js/securimage/yzm.php?t=" + time);//验证码切换-->
    <!--}-->
<!--</script>-->


		</div>
	<!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>



<script>
    function setPage0(page,pagenum,mid){
     
    $.post('<?php echo HOST_NAME;?>jinian/Jinian/ajaxjs?page=' + page+'&pagenum='+pagenum+'&mid='+mid,{},function(data)

        {
          
            if(data != '')
            {   
                $('#mybox').html(data);
            }
        });
    }

//鲜花ajax js
function xianhua_pagenum(page,pagenum,mid){
    $.post('<?php echo HOST_NAME;?>jinian/Jinian/xianhuaAjax?page=' + page+'&pagenum='+pagenum+'&mid='+mid,{},function(data)

        {
          
            if(data != '')
            {   
                $('#xianhua').html(data);
            }
        });
    }

//全部商品ajax js
function goods_all_pagenum(page,pagenum,mid){
    $.post('<?php echo HOST_NAME;?>jinian/Jinian/goodsAllAjax?page=' + page+'&pagenum='+pagenum+'&mid='+mid,{},function(data)

        {
          
            if(data != '')
            {   
                $('#goods_all_pagenum').html(data);
            }
        });
    }


//尚香ajax js
function shang(page,pagenum,mid){
    $.post('<?php echo HOST_NAME;?>jinian/Jinian/shangAjax?page=' + page+'&pagenum='+pagenum+'&mid='+mid,{},function(data)

        {
          
            if(data != '')
            {   
                $('#shang').html(data);
            }
        });
    }

//点烛ajax js
function dian(page,pagenum,mid){
    $.post('<?php echo HOST_NAME;?>jinian/Jinian/dianAjax?page=' + page+'&pagenum='+pagenum+'&mid='+mid,{},function(data)

        {
          
            if(data != '')
            {   
                $('#dian').html(data);
            }
        });
    }

//祭品ajax js
function jiping(page,pagenum,mid){
    $.post('<?php echo HOST_NAME;?>jinian/Jinian/jipingAjax?page=' + page+'&pagenum='+pagenum+'&mid='+mid,{},function(data)

        {
          
            if(data != '')
            {   
                $('#jiping').html(data);
            }
        });
    }

//装饰ajax js
function zhuangshi(page,pagenum,mid){
    $.post('<?php echo HOST_NAME;?>jinian/Jinian/zhuangshiAjax?page=' + page+'&pagenum='+pagenum+'&mid='+mid,{},function(data)

        {
          
            if(data != '')
            {   
                $('#zhuangshi').html(data);
            }
        });
    }




//祭品箱子倒计时
function GetRTime(t){
	var EndTime= new Date(t);
	var NowTime = new Date();
	var t =EndTime.getTime() - NowTime.getTime();
	var d=0;
	var h=0;
	var m=0;
	var s=0;
	if(t>=0){
		d=Math.floor(t/1000/60/60/24);
		h=Math.floor(t/1000/60/60%24);
		m=Math.floor(t/1000/60%60);
		s=Math.floor(t/1000%60);
	}


	document.getElementById("t_d").innerHTML = d + "天";
	document.getElementById("t_h").innerHTML = h + "时";
	document.getElementById("t_m").innerHTML = m + "分";
	document.getElementById("t_s").innerHTML = s + "秒";
}
</script>

