;(function ($) 
{
    $.extend(
	{
		mo_slide:function(conf)
		{
			//console.log(conf);
			
			if(conf.tags_elm.length == 0)
			{
				return;
			}
			var _conf = conf,//轮播配置
			    i = 0,//轮播起始位置          
				list_len = _conf.tags_elm.length,//轮播元素的个数

				//自动轮播
				autoSlide = function () 
				{
					if(i+1 > list_len)
					{
						i = 0;
					}

					var current_cont_elm = _conf.cont_elm.eq(i);  //当前内容元素
					var current_tag_elm = _conf.tags_elm.eq(i);  //当前标签元素
					changeEffect(_conf.effect,current_cont_elm);
					//切换内容元素样式
					changeClassName(_conf.cur_cont_class,current_cont_elm);		
					//切换标签样式
					changeClassName(_conf.cur_tag_class,current_tag_elm);
					i = i+1;
				},
				//手动切换
				handSlide = function()
				{
					_conf.tags_elm.bind(_conf.tags_event,function()
					{
						var _this = jQuery(this);
						var _index = _this.index();
						var current_cont_elm = _conf.cont_elm.eq(_index);  //当前内容元素

						//切换显示
						changeEffect(_conf.effect,current_cont_elm);
						//切换内容元素样式
						changeClassName(_conf.cur_cont_class,current_cont_elm);		
						//切换标签样式
						changeClassName(_conf.cur_tag_class,_this);
					});
					return;
				},
				//自动切换
				_autoSlide = function()
				{
					st = setInterval(autoSlide, _conf.time);//启动自动轮播
					//给每个内容元素都绑定上鼠标热点事件
					jQuery.each(_conf.cont_elm,function(i,n)
					{
						jQuery(n).hover(function (){
							clearInterval(st);
						}, function () { 
							st = setInterval(autoSlide, _conf.time); 
						});
					});
					//绑定标签事件
					if(_conf.tags_event == 'click')
					{
						var flag = false;
						_conf.tags_elm.bind('click',function()
						{
							flag = true;
							i = jQuery(this).index();
							autoSlide();
							clearInterval(st);
						}).bind('mouseout',function()
						{
							if(flag === true)
							{
								flag = false;
								st = setInterval(autoSlide, _conf.time); 
							}
						});	
					}
					if(_conf.tags_event == 'mouseover')
					{
						_conf.tags_elm.bind('mouseover',function()
						{
							i = jQuery(this).index();
							autoSlide();
							clearInterval(st);
						}).bind('mouseout',function()
						{
							st = setInterval(autoSlide, _conf.time); 
						});
					}
				},
				changeEffect = function(e,elm){
					if(e == 'fade')
					{
						elm.fadeIn().siblings().fadeOut(); //切换显示
					}
					else if (e == 'slide')
					{
						elm.slideUp().siblings().slideDown(); //切换显示
					}
					else
					{
						elm.show().siblings().hide(0); //切换显示
					}
				},
				changeClassName = function(c,elm){
					if((c != undefined) && (c != ''))
					{
						elm.addClass(c).siblings().removeClass(c); //切换显示
					}
				}
				
				//判断是否自动播放
				if(!_conf.auto_slide)
				{
					handSlide();
				}
				else
				{
					_autoSlide();
				}
		}
    });
}(jQuery));

jQuery(function()
{
	jQuery.mo_slide({
		'time':3000,                                   //切换时间 单位毫秒
		'auto_slide':true,                             //是否自动切换
		'effect':'fade',                               //切换效果 提供3中效果  fade slide base
		'tags_event':'click',                          //手动切换触发方法 click mouseover
		'tags_elm':jQuery('.banner .bannersimg img'),  //标签集合jQuery对象
		'cont_elm':jQuery('.banner .bannerimg a'),     //内容集合jQuery对象
		'cur_tag_class':'',                            //当前标签 样式名称
		'cur_cont_class':''                            //当前内容 样式名称
	});

	jQuery.mo_slide({
		'time':2000,
		'auto_slide':true,
		'effect':'base',
		'tags_event':'mouseover',
		'tags_elm':jQuery('.sub_350 .boxbox span'),
		'cont_elm':jQuery('.sub_350 .boximg li'),
		'cur_tag_class':'current',
		'cur_cont_class':''
	});

	jQuery.mo_slide({
		'time':2000,
		'auto_slide':true,
		'effect':'fade',
		'tags_event':'mouseover',
		'tags_elm':jQuery('.pro_img .leftimg img'),
		'cont_elm':jQuery('.pro_img .rightimg img'),
		'cur_tag_class':'',
		'cur_cont_class':''
	});
});