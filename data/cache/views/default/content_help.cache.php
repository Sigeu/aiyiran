<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/help.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
        <script type="text/javascript">
            $(function(){
//              $(".vtitle").hover(function(){
//                  $(this).addClass("active");
//              },function(){
//                  $(this).removeClass("active");
//              });
//              
                
                
                //菜单隐藏展开
                // $(".menu_op_clo .vcon:first").show();
                // var tabs_i=0
                // $('.vtitle').click(function(){
                //     $(this).addClass("active").siblings().removeClass("active");
                //     var _self = $(this);
                //     var j = $('.vtitle').index(_self);
                //     if( tabs_i == j ) return false; tabs_i = j;
                //     $('.vtitle em').each(function(e){
                //         if(e==tabs_i){
                //             $('em',_self).removeClass('v01').addClass('v02');
                //         }else{
                //             $(this).removeClass('v02').addClass('v01');
                //         }
                //     });
                //     $('.vcon').slideUp().eq(tabs_i).slideDown();
                // });
            })
        </script>
<?php include Template::t_include('head.html');?>
    
        <div class="box_cont_w clearfix">
          <div class="w_1200 clearfix">
            <div class="left_menu">
                <h3>帮助中心</h3>
                <ul class="clearfix">
                    <li class="active"><a href="http://jisi2.com/category/Category/index/cid/281">-常见问题</a></li>
                    <li><a href="###">-在线咨询</a></li>
                </ul>
            </div>
                
            <div class="right_cont">
                <div class="details">
                    <div class="top_title">
                        <!--<a href="###">返回表页</a>-->
                        <h2><?php echo Template::addquote($content['title']);?></h2>
                    </div>
                    <div class="details_cont">
                          <?php echo Template::addquote($content['content']);?>
                    </div>
                    <p class="return_sx"><em class="prov fl"><span>上一篇：</span><a href="<?php echo Template::addquote($shang_title['url']);?>"><?php echo csubstr($shang_title['title'],25);?></a></em><em class="next fr"><span>下一篇：</span><a href="<?php echo Template::addquote($xia_title['url']);?>"><?php echo csubstr($xia_title['title'],25);?></a></em></p>   
                   </div>
            </div>

          </div>
        </div>
        
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
