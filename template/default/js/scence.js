$(function(){
    /**********************************/
        $("#on_off").click(function(){ 
            var music = document.getElementById("mp3Btn"); 
            if(music.paused){ 
                music.play(); 
            }else{ 
                music.pause(); 
            } 
        }); 

        $(".r_menu ul li").each(function(){
            $(this).click(function(){
                var this_index = $(".r_menu ul li").index(this)+1;
                $(".r_menu ul li").removeClass("active");
                $(this).addClass("active");
                $(".mask").show();
                $(".shop-content").show(); 
//              alert(this_index);
            if($('.tab li').length > 1){
                $(".tab li:eq("+this_index+")").addClass("active");
                $(".ShopList:eq("+this_index+")").show();
            }
                
                
            });
        }); 
        /*************************/ 
    $(".shop-content .ShopList").hide();
        $(".tab li").each(function(j){
            $(this).click(function(){
               $(".tab li").removeClass("active");
               $(this).addClass("active");
                $(".ShopList").hide()
                $(".ShopList:eq("+j+")").show();
            })
        });
        /*******************************/
        $(".shop-content a.close").click(function(){
            $(".shop-content").hide();   
            $(".mask").hide();
            $(".tab li").removeClass("active");
            $(".ShopList").hide();
        });
        $(".ShopList ul li").hover(function(){
                $(this).addClass("active");
            },function(){
                $(this).removeClass("active");
            });

//         var goods_img_url = null, //存储商品图片链接
//             goods_name = null, //存储商品名称
//             goods_price = null, //存储商品价格
//             goods_day = null; //存储商品天数
//             goods_id = null; //商品的 id
//             num = null; //自定义商品的数量
//         $(".ShopList ul li").click(function(){
//             goods_img_url = $(this).find(">a>img").attr("src");
//             goods_name = $(this).find(">a>h4").text();
//             goods_price = $(this).find(">a>p>em").text();
//             goods_day = $(this).find(">a>p>span").text();
//             goods_id = $(this).attr('data'); //商品的 id
//             mid = $(this).attr('mid'); //纪念馆id
//             //console.log(img_url, goods_name, goods_price, goods_day);
//             //修改弹窗内容
//             var $dl = $(".buy_goods div dl");
//             $dl.find("dt img").attr("src", goods_img_url);
//             $dl.find("dt span").text(goods_name);
//             goods_price = parseInt(goods_price);
//             $dl.find("dd .price").text(goods_price);
//             $dl.find("dd .all_price").text(goods_price);

//             //通过数量计算商品价格
//             $(".money_sel").keyup(function(){
//                 num = $(this).val();
//                 if(num>999){
//                     $(this).val(1);
//                 }
//                 if(num<1){
//                     $(this).val(1);
//                     $(this).attr('value',1);
//                 }
//                 if(isNaN(num)){
//                     $(this).val(1);
//                 }
//                 var price = parseInt(goods_price);
//                 num = parseInt(num);
//                 var all_price = num*price;
//                 $dl.find("dd .all_price").text(all_price);
//             });
//             //通过数量计算商品价格

//             $dl.find("dd a").attr('gid',goods_id);  //商品的 id 放置到购买按钮这里
//             $dl.find("dd a").attr('mid',mid);  //商品的 id 放置到购买按钮这里


//             $(".buy_goods").show();
//             $(".mask2").show();
//         });
//         $(".buy_goods a.close").click(function(){
//             $(".buy_goods").hide();   
//             $(".mask2").hide();
//         });

//         //确认购买
//         $(".confirm2").click(function(){
//             //关闭所有弹窗
//             $(".close").click();
//             //此处触发购买操作
//             var goods_num = $(".money_sel").val();
//             var goods_id = $(this).attr('gid'); //商品id
//             var mid = $(this).attr('mid'); //纪念馆id
//             //发送ajax 购买物品
//             // var result_id = null;
//             $.ajax({
//                 type: "Post",
//                 url: "/jinian/Jinian/goodsBuy",
//                 data: {'goods_id':goods_id, 'mid':mid, 'goods_num':goods_num},
//                 dataType: "json",
//                 success: function(data) {
//                     if (data.status == 2) {
//                        layer.msg(data.msg);
//                     }else{
//                         //购买成功返回的商品主键id
//                         var str = "";
//                         for (var i = 0; i <data.length ; i++) {
//                             str += "<div class='drag_img drag_img2' style='border:solid #fff 1px;' bid="+data[i]+"><img src="+goods_img_url+" /></div>";
//                         }

//                         //购买成功是否询问是否放置物品===========================================
//                         layer.confirm('确认放置在此纪念馆吗', {
//                           btn: ['放置','取消'] //按钮
//                         }, function(){
//                             $.post("/jinian/Jinian/placeGoods",{'goods_id':goods_id,'mid':mid},function(data){  
//                                 if(data.status==1){
//                                     $(".scenes_container").append(str);
//                                     window.location.reload(); //祭品放置成功后刷新一下页面
//                                 }else{
//                                     alert(data.msg);
//                                 }  
//                             },"json");  
//                           layer.closeAll();
//                         }, function(){
//                           layer.closeAll();
//                         });
//                         //购买成功是否询问是否放置物品===========================================
                        
//                     }
//                 }
//             });

// //         $(".mask2").show();
//         });

        //拖动
        var x1 = null,y1 = null,x2 = null,y2 = null,x3 = null,y3 = null,drag_status = false,$drag_img = null,$drag_img_par = null;
        var bid=null;
        //鼠标按下
        $("body").on("mousedown", ".drag_img2", function(e){
//          console.log("mousedown");
            e = e || window.event;
            $drag_img = $(this);
            $drag_img_par = $drag_img.parent();
            x1 = $drag_img.offset().left-$drag_img_par.offset().left;
            y1 = $drag_img.offset().top-$drag_img_par.offset().top;
            x2 = e.pageX;
            y2 = e.pageY;
            //获取当前的商品id
            bid = $(this).attr('bid');

//          console.log(x1,y1,x2,y2);
            drag_status = true;
            return false;
        });
        //鼠标移动
        $("body .drag_img2").on("mousemove", function(e){
            e = e || window.event;
            if(!drag_status){ return false; }
//          console.log("mousemove");
            x3 = x1+e.pageX-x2;
            y3 = y1+e.pageY-y2;
            if(x3 <= 0){ x3 = 0;}
            if(x3 >= $drag_img_par.width()-$drag_img.width()){ x3 = $drag_img_par.width()-$drag_img.width();}
            if(y3 <= 0){ y3 = 0;}
            if(y3 >= $drag_img_par.height()-$drag_img.height()){ y3 = $drag_img_par.height()-$drag_img.height();}
            $drag_img.css({"top": y3+"px","left": x3+"px"});
            return false;
        });
        //鼠标松开
        $("body .scenes_container .drag_img2").on("mouseup", function(){
            //获取当年纪念馆id
            var mid = $("#aCare").attr('mid');
            mid = parseInt(mid);
//          console.log("mouseup");
            //松开鼠标的时候把当前拖动的商品位置传给后台 x3 和  y3
            $.ajax({
                type: "Post",
                url: "/jinian/Jinian/goodsPlace",
                data: {'x3':x3, 'y3':y3, 'bid':bid, 'mid':mid},
                dataType: "json",
                success: function(data) {
                    if (data.status == 2) {
                       isLogin();
                    }
                }
            });

            //把值传给后台后把下列值再初始化
            x1=null,y1=null,x2=null,y2=null,x3=null,y3=null;
            drag_status = false,$drag_img = null,$drag_img_par = null;
        });


        // 我的祭品箱子
        $(".offer_list ul .fangzhi").each(function(){
            // 把祭品箱子的物品放入到当前纪念馆
            $(this).click(function(){
                // 获取当前的商品id
                var goods_id = $(this).attr('goods_id');
                var mid = $(this).attr('mid');
                layer.confirm('确认放置在此纪念馆吗', {
                          btn: ['放置','取消'] //按钮
                        }, function(){
                            $.post("/jinian/Jinian/placeGoods2",{'goods_id':goods_id,'mid':mid},function(data){  
                                if(data.status==1){
                                    // var goods_img_url = $(this).find(">a>span>img").attr("src");
                                    // alert(goods_img_url);

                                    // $(".close").click();
                                    //此处触发购买操作
                                    // $(".scenes_container").append("<div class='drag_img'><img src="+goods_img_url+" /></div>");
                                    // $(".scenes_container").append(str);
                                    window.location.reload(); //祭品放置成功后刷新一下页面
                                }else{
                                    alert(data.msg);
                                }  
                            },"json");  
                          layer.closeAll();
                        }, function(){
                          layer.closeAll();
                        });
                

            })
        })
        


          
         
            
    /****************/
        $(".r_menu .jp_7").click(function(){
            $(".offer_box").show();   
            $(".mask").show();
        });
        
        $(".offer_box a.close").click(function(){
            $(".offer_box").hide();   
            $(".mask").hide();
        });
   
})
  /*******************************************/
    // 确认登录吗
function isLogin()
{
    layer.confirm('你还未登录，请登录后操作', {
        btn: ['登录','取消'] //按钮
    }, function(){
        location.href = "/user/Login/login2";
    }, function(){
        window.location.reload();
       layer.closeAll();
    });
}

//礼物箱子放置物品到当前纪念馆
function fangzhi(goods_id, mid)
{
    layer.confirm('确认放置在此纪念馆吗', {
                          btn: ['放置','取消'] //按钮
                        }, function(){
                            $.post("/jinian/Jinian/placeGoods",{'goods_id':goods_id,'mid':mid},function(data){
                                if(data.status==1){
                                    // var goods_img_url = $(this).find(">a>span>img").attr("src");
                                    // alert(goods_img_url);

                                    // $(".close").click();
                                    //此处触发购买操作
                                    // $(".scenes_container").append("<div class='drag_img'><img src="+goods_img_url+" /></div>");
                                    // $(".scenes_container").append(str);
                                    window.location.reload(); //祭品放置成功后刷新一下页面
                                }else{
                                    alert(data.msg);
                                }  
                            },"json");  
                          layer.closeAll();
                        }, function(){
                          layer.closeAll();
                        });
                

}


function showBuy(obj)
{
    var objName = $(obj);
    var goodsid = objName.attr("data-goodsid"); 
    var mid = objName.attr("data-mid");
    var goods_name = objName.attr("data-gname");
    var goods_img_url = objName.attr("data-img");
    var goods_price = objName.attr("data-price");



    var $dl = $("#layer-goods");
    $dl.attr('data-goodsid',goodsid);
    $dl.attr('data-mid',mid);
    $dl.attr('data-gname',goods_name);
    $dl.attr('data-img',goods_img_url);
    $dl.attr('data-price',goods_price);




    // 修改弹窗内容
    var $dl = $("#layer-goods div dl");
        $dl.find("dt img").attr("src", goods_img_url);
        $dl.find("dt span").text(goods_name);
        goods_price = parseInt(goods_price);
        $dl.find("dd .price").text(goods_price);
        $dl.find("dd .all_price").text(goods_price);

        $("#money_sel").val(1);



        // 弹出购买窗口
    $("#layer-goods").show();
    // $(".mask2").show();

}


//关闭
function close_goods()
{
    $("#layer-goods").hide();
}

    //html 元素内容 inner.html  input的值用   documentElementById('money_sel').value=1;

// 通过数量计算商品价格2017年3月15日17:12:26
  function money_sel(obj)
  {
      var $dl = $("#layer-goods");
      var goods_price = $("#layer-goods").attr('data-price');
      goods_price = parseInt(goods_price);
      var _money = $(obj);
      var num = _money.val();
      if(num.length >5){            //长度限制
          _money.val(1);
      }
      if(num == ''){
          $("#layer-goods").find(".all_price").text(goods_price);
          //alert('购买数量不能为空'); return false;
      }else if(num<1){
          _money.val(1);
          $("#layer-goods").find(".all_price").text(goods_price);
      }else if(num>999){
          _money.val(1);
          $("#layer-goods").find(".all_price").text(goods_price);
      }else if(isNaN(num)){
          _money.val(1);
          $("#layer-goods").find(".all_price").text(goods_price);
      }else{
          var price = parseInt(goods_price);
          num = parseInt(num);
          var all_price = num*price;
          $("#layer-goods").find(".all_price").text(all_price);
      }
  }




$(function(){
                //确认购买
        $(".confirm2").click(function(){
            //关闭所有弹窗
            $(".close").click();
            //此处触发购买操作
            var goods_num = $("#money_sel").val();
            var goods_id = $("#layer-goods").attr('data-goodsid'); //商品id
            var mid = $("#layer-goods").attr('data-mid'); //纪念馆id
            var goods_img_url = $("#layer-goods").attr('data-img'); //纪念馆id
            if(goods_num==''){
                alert('请填写购买数量');return false;
            }
            //发送ajax 购买物品
            // var result_id = null;
            $.ajax({
                type: "Post",
                url: "/jinian/Jinian/goodsBuy",
                data: {'goods_id':goods_id, 'mid':mid, 'goods_num':goods_num},
                dataType: "json",
                success: function(data) {
                    if (data.status == 2) {
                       layer.msg(data.msg);
                    }else{
                        //购买成功返回的商品主键id
                        var str = "";
                        for (var i = 0; i <data.length ; i++) {
                            str += "<div class='drag_img drag_img2' style='border:solid #fff 1px;' bid="+data[i]+"><img src="+goods_img_url+" /></div>";
                        }

                        //购买成功是否询问是否放置物品===========================================
                        layer.confirm('确认放置在此纪念馆吗', {
                          btn: ['放置','取消'] //按钮
                        }, function(){
                            $.post("/jinian/Jinian/placeGoods",{'goods_id':goods_id,'mid':mid},function(data){  
                                if(data.status==1){
                                    $(".scenes_container").append(str);
                                    window.location.reload(); //祭品放置成功后刷新一下页面
                                }else{
                                    alert(data.msg);
                                }  
                            },"json");  
                          layer.closeAll();
                        }, function(){
                          layer.closeAll();
                        });
                        //购买成功是否询问是否放置物品===========================================
                        
                    }
                }
            });

        });
});

 






