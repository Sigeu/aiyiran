<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="css/public.css"/>
        <link rel="stylesheet" type="text/css" href="css/ly.css"/>
        <script type="text/javascript" src="js/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript">
            $(function(){
                $(".left_menu ul li:last").css("border","none")
            })
        </script>
<?php include Template::t_include('cemetery/head_cemetery.html');?>
    
        <!--********************************************-->
        <div class="box_cont_w clearfix">
            <div class="w_1200 clearfix">
                <div class="left_menu clearfix">
                    <h3>地理位置</h3>
                    <ul class="clearfix">
                        <li class="active"><a href="###">-地理位置</a></li>
                    </ul>
                </div>
                <div class="right_cont">
                    <h2 class="ly_tiele"><?php echo Template::addquote($content['title']);?></h2>
                    <div class="details_loaction">
                    <p><?php echo Template::addquote($content['summary']);?></p>
                        <p>地址：<?php echo Template::addquote($content['address']);?></p>
                        <p>电话：<?php echo Template::addquote($content['tel']);?></p>
                        <!-- <p>传真：010-69803346</p> -->
                        <!-- <p>邮编：100020</p> -->
                    </div>
                        <style type="text/css">
        body, html {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
        #allmap{width:818px;height:380px;}
        p{margin-left:5px; font-size:14px;}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=UcWpOkDTRFZC7kxTkGCQmwSRNek8kxDf"></script>


            <div class="map_dt"><div id="allmap"></div></div>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");          
    map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);
    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map}
    });
    local.search("<?php echo Template::addquote($content['map_name']);?>");
</script>





                </div>  
            </div>
        </div>
        
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
