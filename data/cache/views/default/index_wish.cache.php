<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/m_wishes.css"/>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/parabola.js"></script>
<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>

<script type="text/javascript">
    $(function(){
        $(".wishes p span").each(function(){
            $(this).click(function(){
                $(".wishes p span").removeClass("active");
                $(this).addClass("active");
            });
        });
        $(".make_box a").click(function(){
            $('.mask').show(1);
            $('.wishes').show(1);
        });
        $('.wishes .close').click(function(){
            $('.mask').hide();
            $('.wishes').hide();
        });

        $(".masage_yw .list_message ul li").hover(function(){
            // $(this).addClass("active");  //回复的js
        },function(){
            $(this).removeClass("active");
        });
        $(".rep").each(function(){
            $(this).click(function(){
                $(this).parents(".gai_shu").next().slideToggle(200);

            });
        });
    });
</script>

        <!--*******************************-->
        <div class="box_cont">
            <div class="make_box">
                <a href="javascript:;" target="_self">开始许愿</a>
                <span id="shopCart" class="shopCart"></span>
            </div>
            <div class="time_box">
                <!-- <a href="###" class="defolt fl">默认排序</a> -->
                <!-- <div class="seleBox fl">
                    <p>发布时间</p><i class="jt_1"></i>
                    <ul class="sel_list">
                        <li>名人纪念馆</li>
                        <li>名人纪念馆</li>
                    </ul>
                </div> -->
    <form action="" method="get">
                <div class="seek_box fr">
                    <input type="text" name="keywords" value="<?php echo $keywords;?>" class="l_input" placeholder="请输入标题或内容" />
                    <input type="submit" value="搜索" class="r_but" />
                </div>
    </form>
            </div>
            <div class="masage_yw clearfix">
            <div class="list_message clearfix">
                <ul class="clearfix" id="ul1">
                <?php $tag_obj = Load::load_tag('wish');if(!is_object($tag_obj)){halt('tag wish is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_wish (array('row'=>'100','keywords'=>$keywords,'message'=>'1','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 8*($currentPage-1);$url = $request_url;$pagesize = 8;$subpage = 10;$pagenum = count($count);$page = new Pages(8,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_wish (array('row'=>'100','keywords'=>$keywords,'message'=>'1','return'=>'data','from'=>$from,'pagesize'=>'8',));?>
                <?php if(!empty($data)) { ?>
                <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>

                    <li>
                        <?php if($value['is_open']==1) { ?>
                            <img src="<?php echo Template::addquote($value['userPhoto']);?>" width="110" height="110" />
                        <?php } else { ?>
                            <img src="<?php echo IMG_PATH;?>/wdl_03.png" />
                        <?php } ?>
                        <h3><span><?php echo Template::addquote($value['title']);?></span></h3>
                        <p><?php echo Template::addquote($value['content']);?></p>
                        <p class="gai_shu">
                        <!-- 公开用户名 -->
                        <?php if($value['is_open']==1) { ?>
                            <?php echo Template::addquote($value['username']);?> <?php echo date('Y/m/d i:s',$value['addtime']);?>
                        <?php } else { ?>
                            匿名：<?php echo date('Y/m/d i:s',$value['addtime']);?>
                        <?php } ?>
                        <i class="rep">回复</i></p>

                        <!-- 回复表单 -->
                        <div class="replys" style="display:none;">
                            <textarea  class="form-control" id="<?php echo Template::addquote($value['id']);?>_reply" name="reply" cols="50" rows="5"
    onblur="if(this.value == ''){this.style.color = '#ACA899'; this.value = '回复<?php echo Template::addquote($value['username']);?>：'; }"
    onfocus="if(this.value == '回复<?php echo Template::addquote($value['username']);?>：'){this.value =''; this.style.color = '#000000'; }"
                                style="color:#ACA899;">回复<?php echo Template::addquote($value['username']);?>：</textarea>
                            <div class="liu-icon"><a href="javascript:;" class="btn btn-primary addmsg" data="<?php echo Template::addquote($value['id']);?>" >评论</a><a href="###" class="btn btn-default">取消</a></div>
                        </div>
                        <!-- 回复表单 -->

                    <?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
                        <?php if($v['pid'] == $value['id']) { ?>
                            <div class="my_message">
                                <img src="<?php echo IMG_PATH;?>/yx02.png"/>
                                <p><?php echo Template::addquote($v['username']);?> 回复<?php echo Template::addquote($value['username']);?>：<?php echo Template::addquote($v['content']);?></p>
                            </div>
                        <?php } ?>
                    <?php $n++;} ?>
                    </li>
                <?php $n++;} ?>
                <?php } else { ?>
                    没找到信息，稍后再试
                <?php } ?>
                
                </ul>
<script type="text/javascript">
    $(".addmsg").click(function(){
        var pid = $(this).attr('data');
        var reply = $("#"+pid+"_reply").val();

        $.ajax({
              type: "Post",
              url: "/comment/comment/ajaxwish",
              data: {"pid":pid, "reply":reply},
              dataType: "json",
              success: function(data) {
                  if (data.status == 1) {
                    alert(data.msg);
                    setTimeout("history.go(0)",2000);
                  } else {
                    alert(data.msg);
                  };
              }
            });
    })

</script>

                <div class="page">
                            <?php echo $pagestr;?>
                </div>
<!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>
            </div>
            </div>
        </div>

<?php if($GLOBALS['username']) { ?>
    <form action="" id="form1">
        <div class="mask" style=" display: none;"></div>
        <div class="wishes" style=" display: none;">
            <a href="javascript:;" class="close" target="_self"></a>
            <input type="text" name="comment_title" id="title" value="" placeholder="许愿标题" />
            <textarea name="comment_content" id="content" rows="" cols="" placeholder="许愿内容"></textarea>
            <div class="wish_error" style="display: none;"><i></i></div>

            <p class="radio_p">
                <label><input type="radio" name="isopen" value="1" checked="" /> 公开</label>

                <label><input type="radio" name="isopen" value="2" /> 匿名</label>

            </p>
            <p class="sure_an2">
                <a href="javascript:;" class="undo" target="_self">取消</a>
                <a href="javascript:;" class="put_in" target="_self" onclick="loginForm()">提交</a>
            </p>
        </div>
    </form>
<?php } else { ?>
        <div class="mask" style=" display: none;"></div>
        <div class="wishes" style=" display: none;">
            <a href="###" class="close"></a>
            <input type="text" name="comment_title"  value="" placeholder="许愿标题" />
            <textarea name="comment_content"  rows="" cols="" placeholder="许愿内容"></textarea>
            <!--<input type="text" name="comment_title" style="border:solid red 1px" />-->

            <p class="radio_p">
                <label><input type="radio" name="isopen" value="1" checked="" /> 公开</label>
                <label><input type="radio" name="isopen" value="2" /> 匿名</label>

            </p>
            <p class="sure_an2">
                <a href="###" class="undo">取消</a>
                <input type="submit" class="put_in btnCart" id="loginForm" onclick="javacript:alert('请先登录');" value="提交">
            </p>
        </div>
        <?php } ?>
        <div id="flyItem" class="fly_item"><img src="<?php echo IMG_PATH;?>/heart1.png" width="70" height="70"></div>

        <script>
            function ityzl_SHOW_LOAD_LAYER(){
                return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
            }
            function ityzl_CLOSE_LOAD_LAYER(index){
                layer.close(index);
            }
                function loginForm() {
                    var title = $("#title").val();
                    var content = $("#content").val();
                    var is_open = $('input:radio[name="isopen"]:checked').val();
                    if (title == "") {
                        $('.wish_error').show();
                        $('.wish_error i').html('标题不能为空');
                        return false;
                    }
                    if (content == "") {
                        $('.wish_error').show();
                        $('.wish_error i').html('内容不能为空');
                        return false;
                    }
                    if (title && content) {
                        $('.wish_error').hide();
                    }
                    $.ajax({
                        type: "Post",
                        url: "/comment/Comment/addwish",
                        data: {"comment_title": title, "comment_content": content, "is_open": is_open},
                        dataType: "json",
                        beforeSend: function () {
                            i =ityzl_SHOW_LOAD_LAYER();
                            // $('#sub').val('发表追思留言中...');
                        },
                        complete: function () {
                            ityzl_CLOSE_LOAD_LAYER(i);
                            // $('#sub').val('发表追思留言');
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                $('.mask').hide();
                                $('.wishes').hide();
                                layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                                    location.reload();
                                });
                                shooop();
                            } else {
                                layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                                    location.reload();
                                });
                            }
                        }
                    });
                }


            function shooop(){

                // 元素以及其他一些变量
                var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document.querySelector("#shopCart");
                var numberItem = 0;
                // 抛物线运动
                var myParabola = funParabola(eleFlyElement, eleShopCart, {
                    speed:10, //抛物线速度
                    curvature:0.0009, //控制抛物线弧度
                    complete: function() {
                        eleFlyElement.style.visibility = "hidden";
//                      eleShopCart.querySelector("span").innerHTML = ++numberItem;
                    }
                });
                // 绑定点击事件
                if (eleFlyElement && eleShopCart) {

                    [].slice.call(document.getElementsByClassName("btnCart")).forEach(function(button) {
                        button.addEventListener("click", function(event) {
                            // 滚动大小
                            var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,
                                scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
                            eleFlyElement.style.left = event.clientX + scrollLeft + "px";
                            eleFlyElement.style.top = event.clientY + scrollTop + "px";
                            eleFlyElement.style.visibility = "visible";
                            myParabola.position().move();
                        });
                    });
                }
            }
        </script>

        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
