$(function(){
	// 头部二级菜单
	var oF=$(".firstUl_yc>li");
	var oS=$(".secondUl_yc");
	oF.hover(function(){
		oF.removeClass("open");
		$(this).addClass("open");
		oS.hide();
		$(this).children(".secondUl_yc").show();
	},function(){
		$(this).removeClass("open");
		$(this).children(".secondUl_yc").hide();
	});

	// 1200以下及1200
	function addC(){
		var $winw=$(window).width();
		if($winw<1201){
			$("body").addClass("newWid");
		}else{
			$("body").removeClass("newWid");
		}
	}
	addC();
	$(window).resize(function(){
		addC();
	});

	// 表格奇偶变色
	$(".table_yc tr:odd").css("background-color","#fff");
	$(".table_yc tr:even").css("background-color","#f3f5f4");

});