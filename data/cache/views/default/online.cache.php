<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
        <link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
        <!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
    <?php include Template::t_include('member/head_top.html');?>

        <div class="wrapW">
            <?php include Template::t_include('member/money_view/money_inc.html');?>
            <div class="conRig_yc">
                <h3 class="dwH3_yc">在线充值</h3>
                <p class="zhP">充值账号：<em><?php echo Template::addquote($yuanbao['username']);?></em></p>
                <ul class="ybUl clearfix">
                <?php $n=1;foreach($goods AS $k => $v) { $lastIndex= count($goods) == $n;?>
                <!-- 充值金额 -->       <!-- 元宝管理主键 -->
                    <li data="<?php echo Template::addquote($v['money']);?>" id="<?php echo Template::addquote($v['id']);?>">
                        <div class="ybBox">
                            <i class="ybXZ"></i>
                            <div class="ybImg">
                                <img src="/template/default/member/images/yb05.jpg" title="<?php echo Template::addquote($v['money']);?>">
                                <span class="priceS">现价：<em><?php echo Template::addquote($v['money']);?></em>元</span>
                            </div>
                        </div>
                    </li>
                <?php $n++;} ?>
                </ul>
                <div class="notice">
                    您当前选择：<span>10元套餐</span>节省：<span>0元</span>金额：<span>10元</span>
                </div>
                <div class="payBox">
                    <p class="payP">支付方式：</p>
                    <dl class="clearfix hankDl">
                        <dd class="active"><a href="javascript:;" class="zfbA"><img src="/template/default/member/images/zfb.png"></a><i class="xzI"></i></dd>
                        <dd><a href="javascript:;" class="hankA">银行卡</a><i class="xzI"></i></dd>
                    </dl>
                    <ul class="hankUl clearfix">
                        <li class="active">
                            <a href="javascript:;"><img src="/template/default/member/images/hank01.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank02.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank03.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank04.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank05.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank06.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank07.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank08.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank09.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank10.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank11.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                        <li>
                            <a href="javascript:;"><img src="/template/default/member/images/hank12.jpg"></a>
                            <i class="xzI"></i>
                        </li>
                    </ul>
                    <a href="javascript:;" class="quick_yc" onclick="goPay();">立即支付</a>
                </div>
            </div>
        </div>
        <div class="wrapS03_yc jbFT_yc">
            <p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
        </div>
    </body>
    <script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>
    <script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
    <script type="text/javascript" src="/template/default/member/js/common.js" ></script>
    <script type="text/javascript">
        $(function(){
            $(".ybBox").click(function(){
                $(".ybBox").removeClass("active");
                $(this).addClass("active"); 
            });
            $(".hankDl dd").click(function(){
                $(".hankDl dd").removeClass("active");
                $(this).addClass("active"); 
            });
            $(".hankA").click(function(){
                $(".hankUl").show();
            });
            $(".zfbA").click(function(){
                $(".hankUl").hide();
            });
            $(".hankUl li").click(function(){
                $(".hankUl li").removeClass("active");
                $(this).addClass("active"); 
            });
        });
    </script>
</html>


<script>
    $(".ybUl li").click(function(){
        var money1 = $(this).attr('data');
        money1 = parseInt(money1);
        $(".notice span:first").html(money1+"元套餐");
        $(".notice span:last").html(money1);

        //获取商品主键id 把商品主键的id放到提交按钮
        var id = $(this).attr('id');
        $(".quick_yc").attr("id", id);

    });

    function goPay()
    {
        var money = $(".notice span:last").text();
        money = parseInt(money); //转换整形

        var goods_name = $(".notice span:first").text()//商品名称

        var id = $(".quick_yc").attr('id'); //获取当前按钮的商品id
        $.post("/member/Pay/chongzhi",{'money':money,'goods_name':goods_name, 'id':id},
            function(data){  
                window.location.href="/member/Pay/goPay/ordersn/"+data.msg;
            },"json");  
    }

    // function goPay()
    // {
    //     var money = $(".ybUl li:last").attr('data');
    //     money = parseFloat(money,10); //价格
    //     var goods_name = "10元宝"//商品名称
    //     $.post("/member/Pay/chongzhi",{'money':money,'goods_name':goods_name},
    //         function(data){  
    //             window.location.href="/member/Pay/goPay/ordersn/"+data.msg;
    //         },"json");  
    // }


</script>