<?php if(!defined('IN_MAINONE')) exit(); ?>
<form id="form1">
    <div class="leave_message clearfix">
        <h4>追思留言/Message</h4>
        <textarea name="content"  id="content" class="leave_message"></textarea>
        <input type="hidden" name="token_form" value="<?php echo $set_token;?>">
        <input type="hidden" name="mid" value="<?php echo $mid;?>">
        <div class="add_face">
            <!-- 验证码 -->
            <!--   <input type="text" name="VerifyCode" style="border:solid red 1px;">
              <img src="/static/js/securimage/yzm.php" alt="" id="yzm" >
              <a id="changeVerifyCode" onclick="huan()" href="javascript:;"> 换一张</a> -->
            <!-- 验证码 -->

            <span class="add fl emotion"><i></i>添加表情</span>
            <?php if($_SESSION['front_login_info']['id']) { ?>
            <span class="publish fr"><em class="fl">还可以输入<i>300字符</i></em><input type="button" value="发表追思留言" class="fb" id="sub" /></span>
            <?php } else { ?>
            <span class="publish fr"><em class="fl">还可以输入<i>400字符</i></em><input type="button" value="发表追思留言" class="fb" onclick="isLogin();" /></span>
            <?php } ?>
        </div>
    </div>
</form>
<div class="list_message clearfix">
    <ul class="clearfix">
        <?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
        <li>
            <img src="<?php echo Template::addquote($v['user_photo']);?>" />
            <h3><span><?php echo Template::addquote($v['username']);?></span><em><?php echo Template::addquote($v['addtime']);?></em><i class="rep">回复</i></h3>
            <p class="paces"><?php echo ubbReplace($v['content']);?></p>
            <div class="replys" style="display:none;">
                <textarea  class="form-control" id="conn_<?php echo Template::addquote($v['id']);?>"></textarea>
                <div class="liu-icon"><a href="javascript:;" id="stop_<?php echo Template::addquote($v['id']);?>" onclick="rep(<?php echo Template::addquote($v['id']);?>, '<?php echo Template::addquote($v['username']);?>', <?php echo $mid;?>)" class="btn btn-primary">评论</a><a href="javascript:;" class="btn btn-default cancelinfo">取消</a></div>
            </div>
            <b class="floor"><?php echo Template::addquote($v['f']);?>F</b>
            <?php if($v['child']) { ?>
            <?php $n=1;foreach($v['child'] AS $s => $b) { $lastIndex= count($v['child']) == $n;?>
            <div class="my_message">
                <?php if($b['user_pic']) { ?>
                <img src="<?php echo Template::addquote($b['user_pic']);?>" alt="">
                <?php } else { ?>
                <img src="/template/default/member/images/default_min.jpg" alt="">
                <?php } ?>
                <p><?php echo Template::addquote($b['username']);?>：<?php echo Template::addquote($b['content']);?></p>
            </div>
            <?php $n++;} ?>
            <?php } ?>
        </li>
        <?php $n++;} ?>
    </ul>
    <div class="page">
        <?php echo $showPage;?>
    </div>
</div>
</div>
<!--********footer***************************************-->


<script type="text/javascript">
    function ityzl_SHOW_LOAD_LAYER(){
        return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    }
    function ityzl_CLOSE_LOAD_LAYER(index){
        layer.close(index);
    }
    //回复留言
    function rep(id, username, mid) {
        var text = $('#conn_'+id).val();
        if(text ==""){
            layer.msg('内容不能为空', {icon: 2});return false;
        }
        $.ajax({
            type: "Post",
            url: "/jinian/Jinian/commentInsert2",
            data: {'content':text,'mid':mid,'top_id':id},
            dataType: "json",
            beforeSend: function () {
                $("#stop_"+id).attr('onclick','');
                i =ityzl_SHOW_LOAD_LAYER();
            },
            complete: function () {
                ityzl_CLOSE_LOAD_LAYER(i);
            },
            success: function(data) {
                if (data.status == 1) {
                    layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                        location.reload();
                    });
                }else{
                    layer.msg(data.msg);
                    $("#sub").removeAttr("disabled");//按钮可用
                }
            }
        });
    }


    $(function(){

        $("#sub").click(function(){
            //$("#sub").attr("disabled","disabled");//按钮不可用
            var content = $("textarea[name='content']").val();
            var token_form = $("input[name='token_form']").val();
            var VerifyCode = $("input[name='VerifyCode']").val();
            var mid = $("input[name='mid']").val();
            if(content ==""){
                layer.msg('内容不能为空', {icon: 2});return false;
            }

            // if(VerifyCode==""){
            //     layer.msg("验证码不能为空");
            //     $("#sub").removeAttr("disabled");//按钮可用
            //     return false;
            // }
            $.ajax({
                type: "Post",
                url: "/jinian/Jinian/commentInsert",
                data: {'content':content,'token_form':token_form,'VerifyCode':VerifyCode,'mid':mid},
                dataType: "json",
                beforeSend: function () {
                    i =ityzl_SHOW_LOAD_LAYER();
                    // $('#sub').val('发表追思留言中...');
                },
                complete: function () {
                    ityzl_CLOSE_LOAD_LAYER(i);
                    // $('#sub').val('发表追思留言');
                },
                success: function(data) {
                    if (data.status == 1) {
                        // layer.msg(data.msg);
                        // window.location.reload();
                        layer.msg(data.msg, {icon: 1, offset: '40%'},function(){
                            location.reload();
                        });

                        // $('#form1')[0].reset();
                        // $("#sub").removeAttr("disabled");//按钮可用
                    }else{
                        layer.msg(data.msg, {icon: 2, offset: '40%'},function(){
                            location.reload();
                        });
//                        $("#sub").removeAttr("disabled");//按钮可用

                    }
                }
            });
        });
    });

    function huan() {
        var time = new Date().getTime();//当前时间
        $('#yzm').attr("src" , "/static/js/securimage/yzm.php?t=" + time);//验证码切换
    }
</script>



<!--qq表情-->
<script>
    $(function(){
        $('.emotion').qqFace({

            id : 'facebox',

            assign:'content',

            path:'/template/default/images/arclist/'	//表情存放的路径

        });

        $(".sub_btn").click(function(){

            var str = $("#saytext").val();

            $("#show").html(replace_em(str));

        });

        $(".paces img").css({'width':'24px', 'height':'24px', 'margin':'0', 'margin-right':'1px'});

    });

    //查看结果

    function replace_em(str){

        str = str.replace(/\</g,'&lt;');

        str = str.replace(/\>/g,'&gt;');

        str = str.replace(/\n/g,'<br/>');

        str = str.replace(/\[em_([0-9]*)\]/g,'<img src="arclist/$1.gif" border="0" />');

        return str;

    }
</script>
<!--qq表情结束-->


<!--留言框剩余字数-->
<script>
$(function(){
    $('.leave_message textarea ').keyup(function(){
        //输入字符后键盘up时触发事件
        var txtLeng = $('.leave_message textarea ').val().length;      //把输入字符的长度赋给txtLeng
        //拿输入的值做判断
        if( txtLeng>300 ){
        //输入长度大于300时span显示0
        $('.publish i').text(' 0 ');
        //截取输入内容的前300个字符，赋给fontsize
        var fontsize = $('.leave_message textarea ').val().substring(0,300);
        //显示到textarea上
        $('.leave_message textarea ').val( fontsize );
        }else{
        //输入长度小于300时span显示300减去长度
        $('.publish em i').text(300-txtLeng);
        }
    });
});

</script>
<!--留言框剩余字数-->

