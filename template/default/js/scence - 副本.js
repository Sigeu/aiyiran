$(function(){
	 var num = 0;
     var timer1 = null;
	/**********************************/
		$("#on_off").click(function(){ 
		    var music = document.getElementById("mp3Btn"); 
		    if(music.paused){ 
		        music.play(); 
		        $(this).removeClass("off")
		    }else{ 
		        music.pause(); 
		        $(this).addClass("off")
		    } 
		}); 

	$(".shop-content").hide(); 
		$(".r_menu ul li").each(function(j){
//			var thid_index = $(this).index();
			$(this).click(function(){
				$(".r_menu ul li").removeClass("active");
			    $(this).addClass("active");
			    $(".mask").show();
		        $(".shop-content").show(); 
			});
		});	
			
		/*************************/	
    $(".shop-content .ShopList:first").show();
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
		});
		$(".ShopList ul li").hover(function(){
		    	$(this).addClass("active");
		    },function(){
                $(this).removeClass("active");
		    });
        $(".ShopList ul li").click(function(){
        	$(".buy_goods").show();
        	$(".mask2").show();
        });
        $(".buy_goods a.close").click(function(){
			$(".buy_goods").hide();   
			$(".mask2").hide();
		});


		  
		  



		 $(".ShopList ul li").each(function(){
		 	$(this).click(function(){
		 		
		 	});
		 });
		    
	/****************/
		$(".r_menu .jp_6").click(function(){
			$(".offer_box").show();   
			$(".mask").show();
	    });
	    
		$(".offer_box a.close").click(function(){
			$(".offer_box").hide();   
			$(".mask").hide();
		});
		
		
		
	
})

















