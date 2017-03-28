$(function(){
	/*图片轮播*/
	var H1=$('.js_scroll_pic .pics img').height();
	$('.js_scroll_pic .pics').height(H1);
	$('.js_scroll_pic .pics').cycle({
		fx:'scrollHorz',
		speed:800,
		prev:$('.js_scroll_pic').find('.prev'),
		next:$('.js_scroll_pic').find('.next'),
		after:function(){
			var index=$('.js_scroll_pic .pics li:visible').index();
			$('.js_scroll_pic .txt_con li:eq('+index+')').show().siblings().hide();
		}
	})
	var H2=$('.js_scroll_pic2 .pics img').height();
	$('.js_scroll_pic2 .pics').height(H2);
	$('.js_scroll_pic2 .pics').cycle({
		fx:'scrollHorz',
		speed:800,
		prev:$('.js_scroll_pic2').find('.prev'),
		next:$('.js_scroll_pic2').find('.next'),
		after:function(){
			var index=$('.js_scroll_pic2 .pics li:visible').index();
			$('.js_scroll_pic2 .txt_con li:eq('+index+')').show().siblings().hide();
		}
	})
	var H3=$('.js_scroll_pic3 .pics img').height();
	$('.js_scroll_pic3 .pics').height(H3);
	$('.js_scroll_pic3 .pics').cycle({
		fx:'scrollHorz',
		speed:800,
		prev:$('.js_scroll_pic3').find('.prev'),
		next:$('.js_scroll_pic3').find('.next'),
		after:function(){
			var index=$('.js_scroll_pic3 .pics li:visible').index();
			$('.js_scroll_pic3 .txt_con li:eq('+index+')').show().siblings().hide();
		}
	})
	/*管理设置隐藏层*/
	var mask="<div class='mask_pos'><div class='mask_pos_div'></div><span><a href='javascript:void(0)' onclick='control(this);'>管理</a><em>&nbsp;|&nbsp;</em><a href='javascript:void(0)' onclick='disappear(this);' class='js_hide'>隐藏</a><em>&nbsp;|&nbsp;</em><a href='javascript:void(0)' onclick='show(this);' class='js_show'>显示</a></span></div>"
	$('div').filter('.two_colum > div > div, .three_colum >div >div,.one_colum > div').hover(function(){
		if($('body.editttttt').length>0&&$(this).find('.mask_pos').length<1){
			$(this).append($(mask));
			$(this).css({'position':'relative'});
			var H=$(this).outerHeight();
			$(this).find('.mask_pos_div').height(H);
		}
	},function(){
		if($('body.edit').length>0&&$(this).attr('disable')!='true'){
			$(this).find('.mask_pos').remove();
		}
	})
	$('.js_hide').live('click',function(){
		$(this).parents('.mask_pos').parent().attr('disable','true');
		$(this).text('显示').siblings().hide();
		$(this).removeClass('js_hide').addClass('js_show');
		return false;
	})
	$('.js_show').live('click',function(){
		$(this).parents('.mask_pos').parent().attr('disable','false');
		$(this).text('隐藏').siblings().show();
		$(this).removeClass('js_show').addClass('js_hide');
		return false;
	})
	if($('body.edit').length>0){
		$('.head').css('margin-top','59px');
	}
    if($('.edit').length>0){
        $('.scroll_pic').css('min-height','50px');

    }
})