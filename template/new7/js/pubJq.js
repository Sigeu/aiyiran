 $(function(){
		/*logo*/
			$(".guide").click(function(){
					if($("#guideUl").css('display')=='none'){
						$("#guideUl").fadeIn();
					}else{
						$("#guideUl").fadeOut();
					}
					return false;
				})
			$(document).click(function(){
						$("#guideUl").fadeOut();
				})
		/*sideNav*/
			$(".closeBtn").toggle(function(){
					$(".sideNav").toggle("slow");
					$(".closeBtn").removeClass("closeBtn").addClass("openBtn");
				},function(){
					$(".sideNav").toggle("slow");
					$(".openBtn").removeClass("openBtn").addClass("closeBtn");
				})
		/*sideNav dl*/
			$(".sideNav dt a").click(function(){
					var dd=$(this).parent('dt').parent('dl');
					if(dd.hasClass('act')){
						dd.find('dd').slideUp('fast',function(){
							dd.removeClass('act');
						});						
					}else{
						dd.find('dd').slideDown('fast',function(){
							dd.addClass('act');							
						});			
						dd.siblings('dl').removeClass('act').find('dd').slideUp('fast');
					}
				})
			if(navigator.appName == "Microsoft Internet Explorer"){
				if(navigator.appVersion.match(/9./i)!="9."){
						$('input:text').focus(function(){									
									$(this).css('border','1px solid #59d7ff');
						}).blur(function(){										
										$(this).css('border','1px solid #e5e5e5');
						})
						$('select').focus(function(){									
									$(this).css('border','1px solid #59d7ff');
						}).blur(function(){										
										$(this).css('border','1px solid #e5e5e5');
						})
						$('textarea').focus(function(){									
									$(this).css('border','1px solid #59d7ff');
						}).blur(function(){
										$(this).css('border','1px solid #e5e5e5');
						})
				}}
		/*subBuild*/
			$("#aOne").toggle(function(){
					$('.subBuild .step2').show();
					$('.subBuild .step1').hide();
					$(this).addClass('BtnGOn').removeClass('BtnGOff');
				},function(){
					$('.subBuild .step1').show();
					$('.subBuild .step2').hide();
					$(this).addClass('BtnGOff').removeClass('BtnGOn');
				})	

			/*publicBoxTab*/
			var tabs=$(".TabBoxT dt");
			tabs.bind('click',function(){
				$(this).addClass('on').siblings('dt').removeClass('on');
				var cons=$(this).parents('.pubtabBox').find('.TabBoxC>div');
				cons.hide().get($(this).index()).style.display='block';
			})
			/*文字过长不显示*/
			$('.js_show a').hover(function(){
					var s=$(this).attr('cont');
					var pos=$(this).offset();
					var html=$('<div class="showAll"></div>');
					html.text(s);
					$('body').append(html);
					html.css({top:pos.top-25,left:pos.left-10});
				},function(){
						$('.showAll').remove();
					})
})
					
		
