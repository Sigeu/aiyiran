<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/idangerous.swiper.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/index.css"/>
<script src='/template/default/js/jquery.1.7.2.js'></script>

<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/idangerous.swiper.min.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/index.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>

        <div class="box_cont clearfix">
            <div class="indexBanner">
              <div class="fl conItem01">
                <div class="section01">
                        <!--banner轮播-->
                            <?php include Template::t_include('inc/lbt.html');?>

                    </div>
              </div>
              <div class="fr conItem02">
                 <div class="cont_list cont_list4">
                    <div class="headline">
                        <span class="fl">最新记录<i></i></span>
                        <!--<a href="###" class="fr">参看更多<i></i></a>-->
                     </div>
                    <ul class="">
                     <?php $tag_obj = Load::load_tag('articlelist');if(!is_object($tag_obj)){halt('tag articlelist is exists!');};$data = $tag_obj -> lib_articlelist (array('row'=>'10','cid'=>'315','return'=>'data',));?>
                            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                        <li>
                            <a href="<?php echo Template::addquote($value['id']);?>"><?php echo msubstr($value["title"],0,19,'utf-8');?></a>
                            <span><?php echo wordTime($value["publishtime"]);?></span>
                        </li>
                           <?php $n++;} ?>
                    
                    </ul>

                </div>
                  <?php include Template::t_include('inc/inc_create.html');?>
              </div>
             </div>
             <div class="Search_box">
                <div class="SearchMuseum">
                      <form action="" method="get">
                        <div class="input_group">
                            <input id="searchMuseumkey" class="form-control fl" name="keywords" placeholder="输入需要查找的内容" type="text" value="<?php echo $keywords;?>">
                            <span><i></i><input type="button" onclick="sousuos(2);"  class="input-group-addon fl" value="搜索" /></span>
                        </div>
                      </form>
                        <p class="as_per">按字母搜索：</p>
                        <ul class="rank">
                            <?php $n=1;if(is_array($zimu)) foreach($zimu AS $v) { ?>
                             <li ><a href="javascript:;" onclick="sousuos2('<?php echo $v;?>', 2, 2);"><?php echo $v;?></a></li>
                            <?php $n++;} ?>
                        </ul>
                    </div>
             </div>
             <div class="tab_cont clearfix">
                <div class="headline">
                <span class="fl">英烈纪念馆<i></i></span>
                <!--<a href="###" class="fr">查看更多<i></i></a>-->
                </div>
                 <script>
                     window.onload = function(){
                         sousuos2('all', 4, 2);
                     }
                 </script>
                <div class="hotP">
                            <ul class="clearfix createData">

                            </ul>
                        </div>
                <!--<div class="page">-->
                    <!--<?php echo $pagestr;?>-->
                <!--</div>-->
<!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>
             </div>
<!-- <script type="text/javascript">
        //默认自动加载
        $(function(){
            search_name('all');
        });

        //初始化清空
        function chushi(){
            $(".createData").html('');
        }
        // 字母搜索
      function search_letter(s){
              chushi();
             $.ajax({
              type: "Post",
              url: "/search2/search/letter",
              contentType:'application/x-www-form-urlencoded; charset=UTF-8',
              data: {"text":s},
              dataType: "json",
              async:true,
              // jsonp:"jsoncallback",
              beforeSend:function(){
                 var index = layer.load(2, {shade: false}); //0代表加载的风格，支持0-2
             },
              success: function(data) {
                  if (data.status == 1) {
                    var str = "<li>";
                   for(var i=0; i<data.data.length; i++){
                             str += "<div class='hotPImg'>";
                             str += "<img src="+data.data[i].userpic+">";
                             str += "</div>";
                             str += "<p class='clearfix hotP_p'><a href='' class='fl nameA'>"+data.data[i].personname+"</a><a href='#' class='fr quickJS'>立即祭拜</a></p>";
                             str += "<div class='mainP'>";
                             str += "<p>享年：<span>"+data.data[i].brithdate+" - "+data.data[i].dieddate+"</span></p>";
                             str += "<p class='introP'>简介：<span>（"+data.data[i].brithdates+"），"+data.data[i].descript+"</span></p>";
                             str += "</div>";
                             str += "<li>";
                    }
                    $(".createData").append(str);
                     layer.closeAll();
                  } else {
                    $(".createData").fadeIn().append(data.msg);
                   layer.closeAll();
                  };
              }
            });
         }

         // 名称搜索
          function search_name(s){
             var text = $("#searchMuseumkey").val();
             if(text == ''){
                // 搜索全部
                search_all2('all');return;
             }
              chushi();
             $.ajax({
              type: "Post",
              url: "/search2/search/celebrity",
              contentType:'application/x-www-form-urlencoded; charset=UTF-8',
              data: {"text":text},
              dataType: "json",
              async:true,
              // jsonp:"jsoncallback",
                beforeSend:function(){
                 var index = layer.load(2, {shade: false}); //0代表加载的风格，支持0-2
             },
              success: function(data) {
                  if (data.status == 1) {
                    var str = "<li>";
                   for(var i=0; i<data.data.length; i++){
                             str += "<div class='hotPImg'>";
                             str += "<img src="+data.data[i].userpic+" width='214' height='214'>";
                             str += "</div>";
                             str += "<p class='clearfix hotP_p'>";
                             str += "<a href='' class='fl nameA'>"+data.data[i].personname+"</a><a href='#' class='fr quickJS'>立即祭拜</a>";
                             str += "</p>";
                             str += "<div class='mainP'>";
                             str += "<p>享年：<span>"+data.data[i].brithdate+" - "+data.data[i].dieddate+"</span></p>";
                             str += "<p class='introP'>简介：<span>（"+data.data[i].brithdates+"），"+data.data[i].descript+"</span></p>";
                             str += "</div>";
                             str += "</li>";
                    }
                    $(".createData").append(str);
                   layer.closeAll();
                  } else {
                    $(".createData").fadeIn().append(data.msg);
                   layer.closeAll();
                  };
              }
            });
         }

         // 搜索全部，搜索内容为空
          function search_all2(s){
              chushi();
             $.ajax({
              type: "Post",
              url: "/search2/search/celebrity",
              contentType:'application/x-www-form-urlencoded; charset=UTF-8',
              data: {"text":s},
              dataType: "json",
              async:true,
              // jsonp:"jsoncallback",
              beforeSend:function(){
                 var index = layer.load(2, {shade: false}); //0代表加载的风格，支持0-2
             },
              success: function(data) {
                  if (data.status == 1) {
                    var str = "<li>";
                   for(var i=0; i<data.data.length; i++){
                             str += "<div class='hotPImg'>";
                             str += "<img src="+data.data[i].userpic+" width='214' height='214'>";
                             str += "</div>";
                             str += "<p class='clearfix hotP_p'><a href='' class='fl nameA'>"+data.data[i].personname+"</a><a href='#' class='fr quickJS'>立即祭拜</a></p>";
                             str += "<div class='mainP'>";
                             str += "<p>享年：<span>"+data.data[i].brithdate+" - "+data.data[i].dieddate+"</span></p>";
                             str += "<p class='introP'>简介：<span>（"+data.data[i].brithdates+"），"+data.data[i].descript+"</span></p>";
                             str += "</div>";
                             str += "<li>";
                    }
                    $(".createData").append(str);
                   layer.closeAll();
                  } else {
                    $(".createData").fadeIn().append(data.msg);
                   layer.closeAll();

                  };
              }
            });
         }
</script> -->
             <div class="link_exchange">
                <span>友情链接：</span><a href="###">中国民政部</a>
                <?php $tag_obj = Load::load_tag('friendlink');if(!is_object($tag_obj)){halt('tag friendlink is exists!');};$data = $tag_obj -> lib_friendlink (array('row'=>'100','return'=>'data',));?>
                  <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
                    <a href='<?php echo Template::addquote($value["com_url"]);?>'><?php echo Template::addquote($value["name"]);?></a>
                  <?php $n++;} ?>
                
            </div>
        </div>
        <!--********footer***************************************-->
<?php include Template::t_include('head_footer.html');?>
