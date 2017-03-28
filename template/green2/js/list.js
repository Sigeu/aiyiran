$(function(){
	$('.level_1L').click(function(){
		open_close($(this));
	})
	$('.level_moL').parent().click(function(){
		open_close($(this),'level_moR');
	})
	function open_close(obj,cla){
		var son_list=obj.siblings('ul');
		if(son_list){
			if(son_list.css('display')=='none'){
				son_list.show();
				obj.find('span').addClass(cla)
			}else{
				son_list.hide();
				obj.find('span').removeClass(cla)
			}
		}
	}
	$('.pics table').css('margin-left',0);
	$('.pic_left').click(function(){
		var num=parseInt($('.pics table').css('margin-left'));
		if(num<0){
			$('.pics table').animate({'margin-left':(num+118)+'px'},600);
		}
		return false;
	})
	$('.pic_right').click(function(){
		var num=parseInt($('.pics table').css('margin-left'));
		if(-num<$('.pics table').width()-354){
			$('.pics table').animate({'margin-left':(num-118)+'px'},600);
		}
		return false;
	})
	$('.detail_nav li').click(function(){
		if($(this).index()==1){
			$('.detail_list2').show();
			$('.detail_list1').hide();
			$('.detail_list3').hide();
			$(this).addClass('focus').siblings().removeClass('focus');
		} else if ($(this).index()==2) {
			$('.detail_list3').show();
			$('.detail_list1').hide();
			$('.detail_list2').hide();
			$(this).addClass('focus').siblings().removeClass('focus');
		}
		else{
			$('.detail_list2').hide();
			$('.detail_list1').show();
			$('.detail_list3').hide();
			$(this).addClass('focus').siblings().removeClass('focus');
		}
	})
	var Ww=$('.pic_list2 table').width();
	var _w=50;
	$('.pic_list2 table').css('margin-left','0px');
	$('.pic_list2 .right_btn').click(function(){
		var pos=-parseInt($('.pic_list2 table').css('margin-left'));
		if(pos+_w<Ww-247){
			$('.pic_list2 table').css('margin-left',-(pos+_w)+'px');
		}
		return false;
	})
	$('.pic_list2 .left_btn').click(function(){
		var pos=-parseInt($('.pic_list2 table').css('margin-left'));
		if(pos>0){
			$('.pic_list2 table').css('margin-left',-(pos-_w)+'px');
		}
		return false;
	})
	$('.pic_list2 img').hover(function(){
		$('.info_pic img').attr('src',$(this).attr('src'));
	})
})
