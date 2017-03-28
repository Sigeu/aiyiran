<?php if(!defined('IN_MAINONE')) exit(); ?>
        <link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
        <link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
        <?php include Template::t_include('member/head_top.html');?>
        <div class="wrapW">
        <?php include Template::t_include('member/user_view/user_inc.html');?>
            <div class="conRig_yc">
                <h3 class="dwH3_yc">个人资料</h3>
                <form id="infoform"  method="post" enctype="multipart/form-data">
                <ul class="deadList_yc">
                    <li>
                        <span class="deadS_yc">头像：</span>
                        <img src="<?php echo Template::addquote($info['user_photo']);?>" class="ftx_yc" id="pic_show">
                        <a href="javascript:;" class="txBtn_yc ml6" id="pic">上传头像</a>
                        <input type="file" name="user_photo" id="upload"  style="display: none">
                    </li>
<script type="text/javascript">
$(function() {
    $("#pic").click(function () {
        $("#upload").click(); //隐藏了input:file样式后，点击头像就可以本地上传
        $("#upload").on("change",function(){
            var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
            if (objUrl) {
                $("#pic_show").attr("src", objUrl) ; //将图片路径存入src中，显示出图片
            }
        });
    });
});
 
//建立一個可存取到該file的url
function getObjectURL(file) {
    var url = null ;
    if (window.createObjectURL!=undefined) { // basic
    url = window.createObjectURL(file) ;
    } else if (window.URL!=undefined) { // mozilla(firefox)
    url = window.URL.createObjectURL(file) ;
    } else if (window.webkitURL!=undefined) { // webkit or chrome
    url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
}
</script>
                    <li>
                        <span class="deadS_yc"><i>*</i>昵称：</span>
                        <input type="text" name="nickname" value="<?php echo Template::addquote($info['nickname']);?>" class="deadIn_yc deadIn01_yc">
                        <strong class="ml6 xingSt"><i>*</i>昵称填写须知：不能重复填写一样的昵称</strong>
                    </li>
                    <li>
                        <span class="deadS_yc">姓名：</span>
                        <input type="text" name="name" value="<?php echo Template::addquote($info['name']);?>" class="deadIn_yc deadIn01_yc">
                    </li>
                    <li>
                        <span class="deadS_yc">性别：</span>
                        <select name="sex" class="deadSel_yc deadSel01_yc">
                            <option value="">请选择</option>
                            <option value="1" <?php if($info['sex']==1) { ?> selected=""<?php } ?> 
                            >男</option>
                            <option value="2" <?php if($info['sex']==2) { ?> selected=""<?php } ?> 
                            >女</option>
                        </select>
                    </li>
                    <li>
                        <span class="deadS_yc">生日：</span>
                        <select name="brith_year" class="deadSel_yc deadSel04_yc">
                            <option value="0">不详</option>
                            <?php $n=1;foreach($times['year'] AS $k => $v) { $lastIndex= count($times['year']) == $n;?>
                            <option value="<?php echo $v;?>" <?php if($birthYear==$v) { ?>selected=''<?php } ?>
                            ><?php echo $v;?></option>
                            <?php $n++;} ?>

                        </select>
                        <span class="dateS_yc">年</span>
                        <select name="brith_math" class="deadSel_yc deadSel04_yc">
                            <option value="0">不详</option>
                            <?php $n=1;foreach($times['math'] AS $k => $v) { $lastIndex= count($times['math']) == $n;?>
                            <option value="<?php echo $v;?>" <?php if($birthMath==$v) { ?>selected=''<?php } ?>
                            ><?php echo $v;?></option>
                            <?php $n++;} ?>
                        </select>
                        <span class="dateS_yc">月</span>
                        <select name="brith_day" class="deadSel_yc deadSel04_yc">
                            <option value="0">不详</option>
                            <?php $n=1;foreach($times['day'] AS $k => $v) { $lastIndex= count($times['day']) == $n;?>
                            <option value="<?php echo $v;?>" <?php if($birthDay==$v) { ?>selected=''<?php } ?>
                            ><?php echo $v;?></option>
                            <?php $n++;} ?>
                        </select>
                        <span class="dateS_yc">日</span>
                    </li>
                    <li>
                        <span class="deadS_yc">籍贯：</span>
                        <select name="brithp" id="brithp" date-city="brithd" class="deadSel_yc deadSel02_yc">
                            <option value="" >选择省份</option>
                            <?php $n=1;foreach($area AS $k => $v) { $lastIndex= count($area) == $n;?>
                            <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($info['brithp']==$v['area_id']) { ?>selected=''<?php } ?>
                            ><?php echo Template::addquote($v['area_name']);?></option>
                            <?php $n++;} ?>
                        </select>
                        <select name="brithd" id="brithd" class="deadSel_yc deadSel02_yc ml6">
                            <option value="" >选择城市</option>
                            <?php $n=1;foreach($brithps AS $k => $v) { $lastIndex= count($brithps) == $n;?>
                            <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($info['brithd'] == $v['area_id']) { ?>selected=''<?php } ?>
                            ><?php echo Template::addquote($v['area_name']);?></option>
                            <?php $n++;} ?>
                        <input type="text" name="brithc" value="<?php echo Template::addquote($info['brithc']);?>" placeholder="地区" class="deadIn_yc deadIn02_yc ml6">
                    </li>
                    <li>
                        <span class="deadS_yc">居住地：</span>
                        <select name="live_sheng" id="live_sheng" class="deadSel_yc deadSel02_yc">
                            <option value="" >选择省份</option>
                            <?php $n=1;foreach($area AS $k => $v) { $lastIndex= count($area) == $n;?>
                            <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($info['live_sheng']==$v['area_id']) { ?>selected=''<?php } ?>
                            ><?php echo Template::addquote($v['area_name']);?></option>
                            <?php $n++;} ?>
                        </select>
                        <select name="live_shi" id="live_shi" class="deadSel_yc deadSel02_yc ml6">
                            <option value="" >选择城市</option>
                            <?php $n=1;foreach($places AS $k => $v) { $lastIndex= count($places) == $n;?>
                            <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($info['live_shi'] == $v['area_id']) { ?>selected=''<?php } ?>
                            ><?php echo Template::addquote($v['area_name']);?></option>
                            <?php $n++;} ?>
                        </select>
                        <input type="text" name="live_diqu" value="<?php echo Template::addquote($info['live_diqu']);?>" placeholder="地区" class="deadIn_yc deadIn02_yc ml6">
                    </li>
                    <li>
                        <div class="deadBtn_yc">
                            <input type="hidden" name="uid" value="<?php echo Template::addquote($info['id']);?>">
                            <a href="javascript:;" class="success_yc" id="info_add">保存</a>
                        </div>
                    </li>
                </ul>
                </form>
            </div>
        </div>
        <div class="wrapS03_yc jbFT_yc">
            <p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
        </div>
    </body>
    <script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
    <script type="text/javascript" src="/template/default/member/js/common.js" ></script>

        <script>
                
            $(function(){
                var baseUrl = "/member/User/area";
                $("#brithp").change(function(){
                    $("#brithd").html('');
                    var va = $(this).val();
                    $.ajax({
                        type: "Post",
                        url: baseUrl,
                        data: {'id':va},
                        dataType: "json",
                        success: function(data) {
                            var str = "<option value=''>请选择</option>";
                                for(var i=0; i<data.length; i++){
                                 str += "<option value="+data[i].area_id+">"+data[i].area_name+"</option>";
                                 }
                                str += "";
                            $("#brithd").append(str);
                        }
                    });
                });
            })

            $(function(){
                var baseUrl = "/member/User/area";
                $("#live_sheng").change(function(){
                    $("#live_shi").html('');
                    var va = $(this).val();
                    $.ajax({
                        type: "Post",
                        url: baseUrl,
                        data: {'id':va},
                        dataType: "json",
                        success: function(data) {
                            var str = "<option value=''>请选择</option>";
                                for(var i=0; i<data.length; i++){
                                 str += "<option value="+data[i].area_id+">"+data[i].area_name+"</option>";
                                 }
                                str += "";
                            $("#live_shi").append(str);
                        }
                    });
                });
            })


            $(function () {
                $("#info_add").click(function () {
                    $("#infoform").ajaxSubmit({
                        type: "Post",
                        url: "/member/User/userinfo",
                        data: $("form").serialize(),
                        success: function(data) {
                            var member = eval("("+data+")"); //包数据解析为json 格
                            if (member.status == 1) {
                                layer.alert(member.message, {icon: 1,offset: '40%'});
                            } else {
                                layer.alert(member.message, {icon: 2,offset: '40%'});
                                return false;
                            }
                        }
                    });
                });
            });

        </script>
</html>
