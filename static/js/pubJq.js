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
			var tabs2=$(".TabBoxT_sub dt");
			tabs2.bind('click',function(){
				$(this).addClass('on').siblings('dt').removeClass('on');
				var cons=$(this).parents('.TabBoxT_sub').parent().find('.TabBoxC_sub>div');
				cons.hide().get($(this).index()).style.display='block';
			})
			/*图片上传浮层*/
			var layout=$(".laytab dt");
			layout.bind('click',function(){
				$(this).addClass('focus').siblings('dt').removeClass('focus');
				var laycon=$(this).parents('.layoutBox').find('.layoutC>div');
				laycon.hide().get($(this).index()).style.display='block';
			})
			$(".tukufolder dt a").click(function(){
					var ddl=$(this).parent('dt').parent('dl');
					if(ddl.hasClass('act')){
						ddl.find('dd').slideUp('fast',function(){
							ddl.removeClass('act');
						});						
					}else{
						ddl.find('dd').slideDown('fast',function(){
							ddl.addClass('act');							
						});			
						ddl.siblings('dl').removeClass('act').find('dd').slideUp('fast');
					}
				})
			var localpic=$(".tukufolder dd");
			localpic.bind('click',function(){
				var localtukuC=$(this).parents('.localF').find('.localC>div');
				localtukuC.hide().get($(this).index()-1).style.display='block';
				$(".tukufolder").hide();
				 $(".localC").show();	
			})
			$(".laytab dt:last-child").click(function(){
				  $(".tukufolder").show();
				  $(".localC").hide();	
				})
			$(".tukufolder dd:even").css("background-color","#f7f7f7");
			$(".tukufolder_info dd:even").css("background-color","#f7f7f7");
			
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
			//$("#maker").height($(document).height()).width($(document).width());
			$('.no_active').live('click',function(){
				$(this).removeClass('no_active').addClass('active').attr('title','再次点击取消选择');
				$(this).find("input").attr('checked','checked');
			})
			$('.active').live('click',function(){
				$(this).find("input").removeAttr('checked');
				$(this).removeClass('active').addClass('no_active').attr('title','');
			})

			$('.no_active').find("input").removeAttr('checked');
			$('.active').find("input").attr('checked','checked');
			/*手机站预览*/	
			if($('.js_phone_box').length>0){
				var posBox=$('.js_phone_box').offset().top;	
				var posBox_H=$('.js_phone_box').outerHeight()-132;
				$('.js_phone_mask').bind('mousemove',function(e){
					e=e||window.event;
					var posY=e.pageY||(e.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
					var top=posY-posBox-60;
					if(top<0){top=0;}
					if(top>posBox_H){top=posBox_H;}
					$('.phone_box').css('top',top+'px').find('img').css('margin-top',-(top*0.7)+'px');
					$('.js_phone_img').find('img').css('margin-top',-(top*1.6)+'px');
				})			
			}
			ie = (function() {  
			  var v = 3, div = document.createElement('div'), a = div.all || [];  
			  while (div.innerHTML = '<!--[if gt IE '+(++v)+']><br><![endif]-->', a[0]);  
			  return v > 4 ? v : !v;  
			}());  
			function navRese(){
				if(ie&&ie<9){
					var W=$(window).outerWidth();
					var Navs=$('.mainNav li a');
					if(W<1145){
						Navs.width(69);
					}
					if(W>=1145){
						Navs.width(87);
					}
					if(W>=1268){
						Navs.width(100);
					}
				}
			}
			navRese();
			$(window).resize(function(){
				navRese();
			})
			
})
					
		
