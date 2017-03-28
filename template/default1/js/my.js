/*
	text框默认提示
	<input type="text" value="" name='name' class="text-tips" tips="请输入表名">
	给连个属性即可：
	1、text-tips class 定位属性。
	2、tips 提示信息存放属性。
	*/
	var opt = {
		"_class":"text-tips",  //text框的class属性
		"tip":"tips",          //存放提示文字的属性
		"tips_color":"#999999",//提示文字的颜色
		"text_color":"#000000" //本身字体颜色
	};
	var obj = $('.'+opt._class);
	if(obj.length >0)
	{
		$.each(obj,function(i,n)
		{
			var v = $.trim($(n).val());
			var t = $.trim($(n).attr(opt.tip));
			if(v=='')
				$(n).val(t).css('color',opt.tips_color);
			else if(v==t)
				$(n).css('color',opt.tips_color);
		});
	}

	//text 框获得焦点事件
	$('.'+opt._class).live('click',function(){
		var v = $.trim($(this).val());
		var t = $.trim($(this).attr(opt.tip));
		if(v==t)
			$(this).val('').css('color',opt.text_color);
	});

	//text 失去焦点事件
	$('.'+opt._class).live('blur',function(){
		var v = $.trim($(this).val());
		var t = $.trim($(this).attr(opt.tip));
		if(v=='')
			$(this).val(t).css('color',opt.tips_color);
		else if(v==t)
			$(this).val(t).css('color',opt.tips_color);
		else
			$(this).css('color',opt.text_color);
	});

	//提交表单的时候处理text内容
	$('form').bind('submit',function()
	{
		var obj = $('.'+opt._class);
		$.each(obj,function(i,n)
		{
			var v = $.trim($(n).val());
			var t = $.trim($(n).attr(opt.tip));
			if(v==t)
				$(n).val('');
		});
	});
