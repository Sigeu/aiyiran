<?php if(!defined('IN_MAINONE')) exit(); ?>
<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
<link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->

<?php include Template::t_include('member/head_left.html');?>


<!-- 图片上传预览 -->

<form id="formINFO"  method="post" enctype="multipart/form-data">
    <div class="conRig_yc">
        <h3 class="dwH3_yc">逝者资料管理</h3>
        <ul class="deadList_yc">
            <li>
                <span class="deadS_yc">头像：</span>
                <?php if($dataInfo['userpic']) { ?>
                <img src="<?php echo Template::addquote($dataInfo['userpic']);?>" class="ftx_yc" id="pic_show">
                <?php } else { ?>
                <img src="/template/default/member/images/default_min.jpg" class="ftx_yc" id="pic_show">
                <?php } ?>
                <!--<a href="javascript:;" class="txBtn_yc ml6">上传头像</a>-->
                <a href="javascript:;" class="txBtn_yc ml6" id="pic">上传头像</a>
                <input type="file" name="userpic"  value="上传头像" id="upload"  style="display: none">
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
                <span class="deadS_yc"><i>*</i>姓名：</span>
                <input type="text" name="person" class="deadIn_yc deadIn01_yc" value="<?php echo Template::addquote($dataInfo['person']);?>">
            </li>
            <li>
                <span class="deadS_yc">性别：</span>
                <select name="sex" class="deadSel_yc deadSel01_yc">
                    <option value="">请选择</option>
                    option
                    <option value="1" <?php if($dataInfo['sex']==1) { ?>selected=''<?php } ?>
                    >男</option>
                    <option value="2" <?php if($dataInfo['sex']==2) { ?>selected=''<?php } ?>
                    >女</option>
                </select>
            </li>
            <li>
                <span class="deadS_yc">民族：</span>
                <select name="nation" class="deadSel_yc deadSel01_yc">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($nation AS $k => $v) { $lastIndex= count($nation) == $n;?>
                    <option value="<?php echo $v;?>"
                    <?php if($dataInfo['nation']==$v) { ?>selected=''<?php } ?>
                    ><?php echo $v;?></option>
                    <?php $n++;} ?>
                </select>
            </li>
            <li>
                <span class="deadS_yc">籍贯：</span>
                <select name="originp" id="originp" date-city="originc" class="deadSel_yc deadSel02_yc">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($area AS $k => $v) { $lastIndex= count($area) == $n;?>
                    <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($dataInfo['originp']==$v['area_id']) { ?>selected=''<?php } ?>
                    ><?php echo Template::addquote($v['area_name']);?></option>
                    <?php $n++;} ?>
                </select>
                <select name="originc" id="originc" class="deadSel_yc deadSel02_yc ml6">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($originInfo AS $k => $v) { $lastIndex= count($originInfo) == $n;?>
                    <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($dataInfo['originc']==$v['area_id']) { ?>selected=''<?php } ?>
                    ><?php echo Template::addquote($v['area_name']);?></option>
                    <?php $n++;} ?>
                </select>
                <input type="text" name="origind" value="<?php echo Template::addquote($dataInfo['origind']);?>" placeholder="地区" class="deadIn_yc deadIn02_yc ml6">
            </li>
            <li>
                <span class="deadS_yc">职业：</span>
                <input type="text" name="careers" value="<?php echo Template::addquote($dataInfo['careers']);?>" placeholder="如：作家、演员" class="deadIn_yc deadIn02_yc ml6" style="margin-left:0;">
            </li>
            <li>
                <span class="deadS_yc">与逝者关系：</span>
                <select name="relationship" class="deadSel_yc deadSel01_yc">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($person_type AS $k => $v) { $lastIndex= count($person_type) == $n;?>
                    <option value="<?php echo $k;?>" <?php if($dataInfo['relationship']==$k) { ?>selected=''<?php } ?>
                    ><?php echo $v;?></option>
                    <?php $n++;} ?>
                </select>
                <strong class="ml6">例：如果逝者是您的“<b>祖先</b>”，则选择“<b>祖先</b>”</strong>
            </li>
            <li>
                <span class="deadS_yc">生辰：</span>
                <select name="brith" class="deadSel_yc deadSel03_yc">
                    <option value="">不详</option>
                    <option value="1" <?php if($dataInfo['brith']==1) { ?>selected=''<?php } ?>
                    >公元</option>
                    <option value="2" <?php if($dataInfo['brith']==2) { ?>selected=''<?php } ?>
                    >公元前</option>
                </select>
                <select name="brith_year" class="deadSel_yc deadSel04_yc ml6">
                    <option value="0">不详</option>
                    <?php $n=1;foreach($times['year'] AS $k => $v) { $lastIndex= count($times['year']) == $n;?>
                     <option value="<?php echo $v;?>" <?php if($birthYear==$v) { ?>selected=''<?php } ?>><?php echo $v;?></option>
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
                <span class="deadS_yc">忌日：</span>
                <select name="died" class="deadSel_yc deadSel03_yc">
                    <option value="">不详</option>
                    <option value="1" <?php if($dataInfo['died']==1) { ?>selected=''<?php } ?>
                    >公元</option>
                    <option value="2" <?php if($dataInfo['died']==2) { ?>selected=''<?php } ?>
                    >公元前</option>
                </select>
                <select name="died_year" class="deadSel_yc deadSel04_yc ml6">
                    <option value="">不详</option>
                    <?php $n=1;foreach($times['year'] AS $k => $v) { $lastIndex= count($times['year']) == $n;?>
                    <option value="<?php echo $v;?>" <?php if($v==$diedYear) { ?>selected=''<?php } ?>
                    ><?php echo $v;?></option>
                    <?php $n++;} ?>
                </select>
                <span class="dateS_yc">年</span>
                <select name="died_math" class="deadSel_yc deadSel04_yc">
                    <option value="">不详</option>
                    <?php $n=1;foreach($times['math'] AS $k => $v) { $lastIndex= count($times['math']) == $n;?>
                    <option value="<?php echo $v;?>" <?php if($v==$diedMath) { ?>selected=''<?php } ?>
                    ><?php echo $v;?></option>
                    <?php $n++;} ?>
                </select>
                <span class="dateS_yc">月</span>
                <select name="died_day" class="deadSel_yc deadSel04_yc">
                    <option value="">不详</option>
                    <?php $n=1;foreach($times['day'] AS $k => $v) { $lastIndex= count($times['day']) == $n;?>
                    <option value="<?php echo $v;?>" <?php if($v==$diedDay) { ?>selected=''<?php } ?>
                    ><?php echo $v;?></option>
                    <?php $n++;} ?>
                </select>
                <span class="dateS_yc">日</span>
            </li>
            <li>
                <span class="deadS_yc">出生地：</span>
                <select name="brithp" id="brithp" date-city="brithd" class="deadSel_yc deadSel02_yc">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($area AS $k => $v) { $lastIndex= count($area) == $n;?>
                    <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($dataInfo['brithp']==$v['area_id']) { ?>selected=''<?php } ?>
                    ><?php echo Template::addquote($v['area_name']);?></option>
                    <?php $n++;} ?>
                </select>
                <select name="brithd" id="brithd" class="deadSel_yc deadSel02_yc ml6">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($brithpInfo AS $k => $v) { $lastIndex= count($brithpInfo) == $n;?>
                    <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($dataInfo['brithd']==$v['area_id']) { ?>selected=''<?php } ?>
                    ><?php echo Template::addquote($v['area_name']);?></option>
                    <?php $n++;} ?>
                </select>
                <input type="text" name="brithc" value="<?php echo Template::addquote($dataInfo['brithc']);?>" placeholder="地区" class="deadIn_yc deadIn02_yc ml6">
            </li>
            <li>
                <span class="deadS_yc">安葬地：</span>
                <select name="diedp" id="diedp" date-city="diedd" class="deadSel_yc deadSel02_yc">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($area AS $k => $v) { $lastIndex= count($area) == $n;?>
                    <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($dataInfo['diedp']==$v['area_id']) { ?>selected=''<?php } ?>
                    ><?php echo Template::addquote($v['area_name']);?></option>
                    <?php $n++;} ?>
                </select>
                <select name="diedd" id="diedd" class="deadSel_yc deadSel02_yc ml6">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($diedpInfo AS $k => $v) { $lastIndex= count($diedpInfo) == $n;?>
                    <option value="<?php echo Template::addquote($v['area_id']);?>" <?php if($dataInfo['diedd']==$v['area_id']) { ?>selected=''<?php } ?>
                    ><?php echo Template::addquote($v['area_name']);?></option>
                    <?php $n++;} ?>
                </select>
                <input type="text" name="diedc" value="<?php echo Template::addquote($dataInfo['diedc']);?>" placeholder="地区" class="deadIn_yc deadIn02_yc ml6">
            </li>
            <li>
                <span class="deadS_yc">所葬陵园：</span>
                <select name="cemetery" class="deadSel_yc deadSel01_yc">
                    <option value="">请选择</option>
                    <?php $n=1;foreach($came AS $k => $v) { $lastIndex= count($came) == $n;?>
                    <option value="<?php echo Template::addquote($v['id']);?>" <?php if($v['id']==$dataInfo['cemetery']) { ?>selected=''<?php } ?>
                    ><?php echo Template::addquote($v['title']);?></option>
                    <?php $n++;} ?>
                </select>
            </li>
            <li>
                <span class="deadS_yc">逝者简介：</span>
                <textarea class="texta_yc" name="descript"><?php echo Template::addquote($dataInfo['descript']);?></textarea>
            </li>
            <li class="clearfix">
                <span class="deadS_yc fl">墓志铭：</span>
                <textarea class="texta_yc texta2_yc fl ml4" id="add_mu" name="epitaph"><?php echo Template::addquote($muzhiming_this['epitaph']);?></textarea>
                <div class="demoBox_yc fl" id="mzm">
                    <p>悼词参考范例</p>
                    <dl>
                        <?php $n=1;foreach($muzhiming_list AS $k => $v) { $lastIndex= count($muzhiming_list) == $n;?>
                        <dd data="<?php echo Template::addquote($v['content']);?>"><?php echo Template::addquote($v['name']);?></dd>
                        <?php $n++;} ?>
                    </dl>
                </div>
            </li>
            <li class="clearfix">
                <span class="deadS_yc fl">立碑人：</span>
                <textarea class="texta_yc texta2_yc fl ml4" id="add_lbr" name="steleauthor"><?php echo Template::addquote($muzhiming_this['steleauthor']);?></textarea>
                <div class="demoBox_yc fl" id="lbr">
                    <p>立碑人范例</p>
                    <dl>
                        <?php $n=1;foreach($libeiren AS $k => $v) { $lastIndex= count($libeiren) == $n;?>
                        <dd data="<?php echo Template::addquote($v['content']);?>"><?php echo Template::addquote($v['name']);?></dd>
                        <?php $n++;} ?>
                    </dl>
                </div>
            </li>
            <li>
                <input type="hidden" name="mid" value="<?php echo $mid;?>">
                <div class="deadBtn_yc">
                    <a href="javascript:;" class="success_yc mr20" id="add_sub">保存</a>
                    <!--<input type="submit" value="保存" class="cancel_yc">-->
                    <a href="javascript:;" class="cancel_yc">取消</a>
                </div>
            </li>
        </ul>
    </div>
</form>
</div>
<div class="wrapS03_yc jbFT_yc">
    <p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
</div>
</body>
<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
<script type="text/javascript" src="/template/default/member/js/common.js" ></script>

<!--省市选择-->
<script type="text/javascript">
$(function(){
    //籍贯
    var baseUrl = "/member/User/area";
    $("#originp").change(function(){
        var va = $(this).val();
        $.ajax({
            type: "Post",
            url: baseUrl,
            data: {'id':va},
            dataType: "json",
            success: function(data) {
                $("#originc").html('');
                var str = "<option value=''>请选择</option>";
                    for(var i=0; i<data.length; i++){
                     str += "<option value="+data[i].area_id+">"+data[i].area_name+"</option>";
                     }
                    str += "";
                $("#originc").append(str);
            }
        });
    });

        //出生地
    var baseUrl = "/member/User/area";
    $("#brithp").change(function(){
        var va = $(this).val();
        $.ajax({
            type: "Post",
            url: baseUrl,
            data: {'id':va},
            dataType: "json",
            success: function(data) {
                 $("#brithd").html('');
                var str = "<option value=''>请选择</option>";
                    for(var i=0; i<data.length; i++){
                     str += "<option value="+data[i].area_id+">"+data[i].area_name+"</option>";
                     }
                    str += "";
                $("#brithd").append(str);
            }
        });
    });

        //安葬地
    var baseUrl = "/member/User/area";
    $("#diedp").change(function(){
        var va = $(this).val();
        $.ajax({
            type: "Post",
            url: baseUrl,
            data: {'id':va},
            dataType: "json",
            success: function(data) {
                 $("#diedd").html('');
                var str = "<option value=''>请选择</option>";
                    for(var i=0; i<data.length; i++){
                     str += "<option value="+data[i].area_id+">"+data[i].area_name+"</option>";
                     }
                    str += "";
                $("#diedd").append(str);
            }
        });
    });
})

    //墓志铭
    $(function(){
       $("#mzm dl dd").click(function () {
         var content = $(this).attr('data');
         if(content=='' || content==null) return;
         $("#add_mu").val(content);
       });
    });

    //立碑人
    $(function(){
        $("#lbr dl dd").click(function () {
            var content = $(this).attr('data');
            if(content=='' || content==null) return;
            $("#add_lbr").val(content);
        });
    });

    $(function () {
       $("#add_sub").click(function () {
           $("#formINFO").ajaxSubmit({
               type: "Post",
               url: "/member/memorial/updateinfo",
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
