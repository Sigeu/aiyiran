<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/ly.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/xiangce.js"></script>
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
                    <h3>陵园景观</h3>
                    <ul class="clearfix">
                   
                        <li class="active"><a href="/content/Content/scenry/id/<?php echo Template::addquote($content['id']);?>">-陵园景观相册</a></li>

                    </ul>
                </div>
                <div class="right_cont clearfix">
                    <!-- <dl class="title_head">
                    <dt><img src="images/yx07.png" /></dt>
                    <dd>
                        <h3>默认相册</h3>
                        <p>创建时间：2015-12-05 &nbsp;&nbsp;&nbsp;&nbsp;  照片数量45张 &nbsp;&nbsp;&nbsp;&nbsp; 浏览量：424521123</p>
                        <span>返回相册列表></span>
                    </dd>
                </dl> -->
                <!--****************-->
                    <div class="center clearfix">
                        <?php $n=1;foreach($pohots AS $key => $v) { $lastIndex= count($pohots) == $n;?>
                        <a href="###">
                            <img src="/static/uploadfile<?php echo Template::addquote($v['photo_url']);?>"/>
                            <!-- <p>1开国大典阅兵</p> -->
                        </a>
                        <?php $n++;} ?>
                     
                    </div>
                    <div class="popup"></div>
                    <div class="show">
                        <img class="big" src=""/>
                        <p class="cont_dete"></p>
                        <a href="###" class="arrow left"></a>
                        <a href="###" class="arrow right"></a>
                        <span class="close"></span>
                    </div>
<div class="page">
                            <?php echo $showPage;?>
             <!-- <?php echo $pagestr;?> -->
                </div>
<!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>
    <!--***************-->          
                    
                    
                </div>  
            </div>
        </div>
        
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
