			$(function(){
				//下拉
				$('.seleBox').click(function() {
			        var isTrue = $(this).is('.on');
			        if(isTrue){
			            $(this).find('ul').slideUp();
			            $(this).find('i').removeClass('jt_2');
			            $(this).removeClass('on');
			        }else{
			            $(this).find('ul').slideDown();
			            $(this).find('i').addClass('jt_2');
			            $(this).addClass('on');
			        }
			        $(this).siblings().removeClass('on');
			        $(this).siblings().find('ul').slideUp();
			    });
			    $('.sel_list li').click(function(ev) {
			    	var $sel_active=$('#sel_active');
			        ev.stopPropagation();
			        if($(this).index()==$sel_active.index()){
			        	$(this).parents('.seleBox').removeClass('on').find('p').text($(this).text());
			        	$(this).parent().hide();
			        	$(this).parents('.seleBox').find('i').removeClass('jt_2');
			        	$('.sear_text').css('display','block');
			        }else{
			        	$(this).parents('.seleBox').removeClass('on').find('p').text($(this).text());
			        	$(this).parent().hide();
			        	$(this).parents('.seleBox').find('i').removeClass('jt_2');
			        	$('.sear_text').css('display','none');
			        }
			    });


			    // 纪念馆二级菜单--yc
			    $(".navUl_yc>li").hover(function(){
			    	$(".navUl_yc>li>a").removeClass("active");
			    	$(this).children("a").addClass("active");
			    	$(this).children(".memNav_yc").slideDown();
			    },function(){
			    	$(this).children("a").removeClass("active");
			    	$(this).children(".memNav_yc").slideUp();
			    });

			    // banner轮播
			    var banSwiper = new Swiper('.section01 .swiper-container',{
				    pagination: '.section01 .swiper-container .pagination',
				    loop:true,
				    grabCursor: true,
				    paginationClickable: true,
				    autoplay : 7000,
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
				    slidesPerView:4
				  });
				  $('.secLB .arrow-left').on('click', function(e){
				    e.preventDefault()
				    missSwiper.swipePrev();
				  });
				  $('.secLB .arrow-right').on('click', function(e){
				    e.preventDefault()
				    missSwiper.swipeNext();
				  });
				  //那年今日
				  var mySwiperdate = new Swiper('.four_p .swiper-container',{
					    pagination: '.pagination_nnjr',
					    paginationClickable: true,
					    autoplay : 3000,
					    speed:900,
					    slidesPerView: 1
					 });
				$(".four_p").hover(function(){
				  	mySwiperdate.stopAutoplay();
				  },function(){
				  	mySwiperdate.startAutoplay();
				  });	
				 /***********************/ 
				  var tabsSwiper = new Swiper('.section05 .swiper-container',{
				    onlyExternal : true,
				    speed:500
				  });
				  $(".headline span").on('touchstart mousedown',function(e){
				    e.preventDefault()
				    $(".headline .active").removeClass('active')
				    $(this).addClass('active')
				    tabsSwiper.swipeTo( $(this).index() )
				  });
				  $(".headline span").click(function(e){
				    e.preventDefault()
				  });
				//****************************************************/  
				  $("#customerService a").hover(function () {
				        $(this).stop().animate({ marginRight: '-80px' }, 'normal');
				    }, function () {
				        $(this).stop().animate({ marginRight: '-0px' }, 'normal', function () { });
				
				    });
				    $("#top_btn").click(function () { if (scroll == "off") return; $("html,body").animate({ scrollTop: 0 }, 300); });
				
				    $("#customerService a").hover(function () {
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
				        $(this).stop().animate({ marginRight: '-80px' }, 'fast', function () { });
				    });
				  
				  
				  
			});































































