			$(function(){
				/*****css***************************/
				$(".cont_list ul li:nth-of-type(6)").addClass("ju_10");
				$(".left_menu ul li:last-child").css("border","none");
			    // banner轮播
			    var banSwiper = new Swiper('.section01 .swiper-container',{
				    pagination: '.section01 .swiper-container .pagination',
				    loop:true,
				    grabCursor: true,
				    paginationClickable: true,
				    autoplay : 7000,
				    speed:1000,
				    autoplayDisableOnInteraction: false
				  });
				  $('.section01 .arrow-left').on('click', function(e){
				    e.preventDefault()
				    banSwiper.swipePrev();
				  });
				  $('.section01 .arrow-right').on('click', function(e){
				    e.preventDefault()
				    banSwiper.swipeNext();
				  });
				  $(".section01").hover(function(){
				  	banSwiper.stopAutoplay();
				  },function(){
				  	banSwiper.startAutoplay();
				  });

				  // 在线追思
				  var missSwiper = new Swiper('.secLB .swiper-container',{
				    grabCursor: true,
				    paginationClickable: true,
				    autoplay :2000,
					speed:1500,
//					loop:true,
				    slidesPerView:4
				  });
				  $(".secLB .arrow_m").hide();
				  $('.secLB .arrow-left').on('click', function(e){
				    e.preventDefault()
				    missSwiper.swipePrev();
				  });
				  $('.secLB .arrow-right').on('click', function(e){
				    e.preventDefault()
				    missSwiper.swipeNext();
				  });
				  $(".secLB").hover(function(){
				  	missSwiper.stopAutoplay();
				  	$(".secLB .arrow_m").show();
				  	$(".secLB")
				  },function(){
				  	missSwiper.startAutoplay();
				  	$(".secLB .arrow_m").hide();
				  });	
				  
				  //那年今日
				  var mySwiperdate = new Swiper('.four_p .swiper-container',{
					    pagination: '.pagination_nnjr',
					    paginationClickable: true,
					    autoplay : 4000,
					    speed:2000,
					    slidesPerView: 1
					 });
				$(".four_p").hover(function(){
				  	mySwiperdate.stopAutoplay();
				  },function(){
				  	mySwiperdate.startAutoplay();
				  });	
				 /***********************/ 
				  var tabsSwiper = new Swiper('.section05 .swiper-container',{
				  	speed:2000,
				    autoplay: 5000,
				    slidesPerView:'1',
					offsetPxBefore:0,
					offsetPxAfter:0,
				    onSlideChangeStart: function(){
				      $(".pagination_three_m .active").removeClass('active')
				      $(".pagination_three_m span").eq(tabsSwiper.activeIndex).addClass('active')  
				    }
				  });
				   $(".pagination_three_m span").on('touchstart mousedown',function(e){
				    e.preventDefault()
				    $(".pagination_three_m .active").removeClass('active')
				    $(this).addClass('active')
				    tabsSwiper.swipeTo( $(this).index() )
				  });
				  $(".pagination_three_m a").click(function(e){
				    e.preventDefault()
				  });
				  $(".section05 .swiper-container").hover(function(){
				  	tabsSwiper.stopAutoplay();
				  },function(){
				  	tabsSwiper.startAutoplay();
				  });	
				  
//				  $(".headline span").on('touchstart mousedown',function(e){
//				    e.preventDefault()
//				    $(".headline .active").removeClass('active')
//				    $(this).addClass('active')
//				    tabsSwiper.swipeTo( $(this).index() )
//				  });
//				  $(".headline span").click(function(e){
//				    e.preventDefault()
//				  });
				//****************************************************/  
				 $("#customerService ul li a").hover(function () {
				        $(this).stop().animate({ marginRight: '0px' }, 'normal');
				    }, function () {
				        $(this).stop().animate({ marginRight: '-100px' }, 'normal', function () { });
				
				    });
				    $("#top_btn").click(function () { if (scroll == "off") return; $("html,body").animate({ scrollTop: 0 }, 300); });
				
				    $("#customerService ul li a").hover(function () {
				        var attr = $(this).attr('data-type');
				        if (attr == 'weixin') {
				            $('.cs-attention').fadeIn('fast');
				        }
				        $(this).stop().animate({ marginRight: '0px' }, 'fast');
				    }, function () {
				        var attr = $(this).attr('data-type');
				        if (attr == 'weixin') {
				            $('.cs-attention').fadeOut('fast');
				        }
				        $(this).stop().animate({ marginRight: '-100px' }, 'fast', function () { });
				    });
				  
				  
				  
			});






















































