<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>弹层</title>
    <link rel="stylesheet" type="text/css" href="<?php echo HOST_NAME;?>library/mainone/views/html/css/success.css"/>
    <!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
</head>
<body>
    <div class="bg_yc"></div>
    <div class="bgBox"></div>
    <div class="handleB">
        <div class="handTop">
            <span class="handS">操作成功</span><em class="handEm"></em>
        </div>
        <div class="handBot">
            <span class="spanStyle"></span>
            <p class="handP">操作成功</p>
            <em class="closeEm">（3秒后自动关闭）</em>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-1.11.0.min.js" ></script>
    <script type="text/javascript">
        $(function(){
            // $(".bg_yc,.bgBox,.handleB").hide();
            $(".handEm").click(function(){
                $(".bg_yc,.bgBox,.handleB").hide();
            });
        });
    </script>

<!-- <button id="sub">显示</button> -->

    <script type="text/javascript">
        $(function(){
            $("#sub").click(function(){
                $(".bg_yc,.bgBox,.handleB").show();
            });
        });
    </script>
</body>
</html>