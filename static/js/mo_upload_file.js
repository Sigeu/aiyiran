/*
*  -------------------------------------------------
*   统一上传方法
*  -------------------------------------------------
*/
MO_UPLOAD = {};//全局上传参数设置
flag = '';//统一上传类型
//初始化配置
function MainOneUpload (option)
{
	//默认配置项
	var _option=
	{
		upload_id   : 'accessory_upload',           //上传标示符
		title       : '上传',                       //窗口title
		return_id   : 'accessory',                  //表单隐藏域name值
		callFunName : 'accessoryUpload',            //点击确定回调函数
		setting     : '',                           //php端编码的参数
		width       : '650px',                      //窗口宽度
		height      : '350px',                      //窗口高度
		lock        : true,                         //是否锁屏
		param       : {self_id:'uploadButton'},
		autoStart   : true
	};

	//合并覆盖原配置
	for (key in option) _option[key] = option[key];

	//拼接上传唯一标示符
	var class_id = 'mo_div_'+_option.upload_id;
	_option['class_id'] = class_id;

	MO_UPLOAD = _option;

	if(MO_UPLOAD.autoStart)
	{
	   uploadStart();
	}
}
//开始上传
function uploadStart()
{
	//弹出上传框之前检查上传是否超限
	if(uploadNumCheck())
	{
		art.dialog.tips('可上传个数已达上限');
		return;
	}

	//已上传的个数
	if(MO_UPLOAD.param.ady_upload != undefined)
		au = MO_UPLOAD.param.ady_upload;
	else
		au = getAlreadyUploadNUm();
	
	//打开上传窗口
	window.top.art.dialog.open('/admin/dialog/upload/index/flag/' + flag + '/au/'+au+'/?setting='+MO_UPLOAD.setting,
	{
			title  : MO_UPLOAD.title,
			id     : MO_UPLOAD.upload_id,
			width  : MO_UPLOAD.width,
			height : MO_UPLOAD.height,
			lock   : MO_UPLOAD.lock,
			ok:function()
			{
				eval(MO_UPLOAD.callFunName).apply(this);
			},
			cancel:true
	});
}



//附件上传
_i = 1;//定义一个全局变量
function accessoryUpload ()
{
	var win = art.dialog.open.origin;			//来源页面
	var iframe = this.iframe.contentWindow;		//Iframe
	var $iframe = $(iframe.document);           //iframe Jquery对象
	var $data = $iframe.find('.mo-upload-data');//上传后的数据
	var data_arr = new Array();					//提交表单使用数据
	var dis_arr = new Array();					//页面及时显示效果
	var js_arr = new Array();
	var alt_str = '';
	if($data.length)
	{
		$.each($data,function(i,n)
		{

			var _n = $(n);
			js_arr = [];
			js_arr.push(_n.attr('selfname'));
			js_arr.push(_n.attr('path'));
			js_arr.push(_n.attr('isimage'));
			js_arr.push(_n.attr('iswatermark'));
			js_arr.push(_n.attr('size'));
			js_arr.push(_n.attr('filename'));
			
			var del_class = 'dis-btn-' +  _i;
			data_arr.push('<div id="'+del_class+'-form" class="'+del_class+' '+MO_UPLOAD.class_id+'">');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][selfname]"    value="'+js_arr[0]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][path]"        value="'+js_arr[1]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][isimage]"     value="'+js_arr[2]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][iswatermark]" value="'+js_arr[3]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][size]"        value="'+js_arr[4]+'" />');
			    data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][filename]"    value="'+js_arr[5]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][src]"         value="'+js_arr[1]+'" />');
			data_arr.push('</div>');
			//alt_str = '图片ALT注释 <input type="text" name="'+MO_UPLOAD.return_id+'['+_i+'][alt]" value="" />&nbsp;&nbsp;';
			dis_arr.push('<div id="' + del_class + '" class="' + del_class + '" style="margin-bottom:10px">');
			dis_arr.push('<input  type="text" onfocus="this.blur()" style="background-color:#eee;color:#aaa" value="'+js_arr[0]+'" readonly class="Iw290"/>&nbsp;&nbsp;&nbsp;');
			dis_arr.push('图片ALT注释&nbsp;&nbsp;<input type="text" name="'+MO_UPLOAD.return_id+'['+_i+'][alt]" value="" />&nbsp;&nbsp;&nbsp;');
			dis_arr.push('<input type="button" class="btn5" value="删除" onclick="deleteUpload(\''+del_class+'\')" />');
			dis_arr.push('&nbsp;<input type="button" class="btn5" value="浏览" onclick="' + MO_UPLOAD.param.check_id + 'uploadAccessory({\'limit\':\'1000\',\'_switch\':\'editImages\',\'self_id\':\'' + MO_UPLOAD.param.self_id + '\',\'cur_id\':\'' + del_class + '\',\'check_id\':\'' + MO_UPLOAD.param.check_id + '\'})"/>');
			dis_arr.push('</div>');
			
			_i = _i + 1;
		});
		
		//附件上传
		if(MO_UPLOAD.param._switch == 'accessory')
		{
			var dis_btn = $(win.document).find('#'+MO_UPLOAD.param.self_id);//浏览按钮
			$(win.document).find('form').append(data_arr.join(''));	//向来源页面追加上传文件的信息
			dis_btn.before(dis_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用
			$(win.document).find('#'+MO_UPLOAD.param.check_id).val('true').focus().blur();//设定判断时候上传附件，以供提交表单时验证是否上传了附件。
			if(getAlreadyUploadNUm() >= MO_UPLOAD.param.limit)	dis_btn.attr('disabled','disabled');
		}
		//商品品牌添加修改
		else if (MO_UPLOAD.param._switch == 'brand')
		{
			$(win.document).find('#'+MO_UPLOAD.param.dis_place).html(data_arr.join('')+dis_arr.join(''));
		}
		//商品图片添加修改
		else if(MO_UPLOAD.param._switch == 'goodsadd')
		{
			var dis_btn = $(win.document).find('#'+MO_UPLOAD.param.self_id);//浏览按钮
			$(win.document).find('form').append(data_arr.join(''));	//向来源页面追加上传文件的信息
			dis_btn.before(dis_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用
			if(getAlreadyUploadNUm() >= MO_UPLOAD.param.limit)	dis_btn.attr('disabled','disabled');
		}
		//广告添加修改
		else if (MO_UPLOAD.param._switch == 'ad_img')
		{
			$('#'+MO_UPLOAD.param.img_id).attr('src',js_arr[1]);
			$('#'+MO_UPLOAD.param.hid_id).val(js_arr[1]);
			$('#'+MO_UPLOAD.param.img_data_id).html(data_arr.join(''));
		}
		else if (MO_UPLOAD.param._switch == 'friend_link')
		{
			$(win.document).find('#'+MO_UPLOAD.param.dis_place).html(data_arr.join('')+dis_arr.join(''));
			$(win.document).find('#'+MO_UPLOAD.param.check_id).val('true').focus().blur();
		}
		else if(MO_UPLOAD.param._switch == 'upload_image')
		{
			var dis_btn = $(win.document).find('#'+MO_UPLOAD.param.self_id);  //浏览按钮
			$(win.document).find('#'+MO_UPLOAD.param.show_id).val(js_arr[0]); //显示图片框
			//$(win.document).find('#'+MO_UPLOAD.param.show_id).after(alt_str); //alt注释输入框
			$(win.document).find('#'+MO_UPLOAD.param.dis_place).html(data_arr.join('')); //隐藏域
			var check = $(win.document).find('#'+MO_UPLOAD.param.check_id);
			check.val('1').focus().blur(); //单个上传走到这不就是上传正确了
		}
		else if(MO_UPLOAD.param._switch == 'uploadImages')
		{
			var dis_btn = $(win.document).find('#'+MO_UPLOAD.param.self_id);//浏览按钮
			$(win.document).find('form').append(data_arr.join(''));	//向来源页面追加上传文件的信息
			dis_btn.before(dis_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用
			var check = $(win.document).find('#'+MO_UPLOAD.param.check_id);
			var checkstr = '';
			for(var ci=0;ci<getAlreadyUploadNUm();ci++)
			{
				var checkstr=checkstr+'*';
			}
			check.val(checkstr).focus().blur();
			//if(getAlreadyUploadNUm() >= MO_UPLOAD.param.limit)	dis_btn.attr('disabled','disabled');
		}
		else if(MO_UPLOAD.param._switch == 'editImages') {
	
			$('#' + MO_UPLOAD.param.cur_id + '-form').replaceWith(data_arr.join(''));
			//$('#' + MO_UPLOAD.param.cur_id).val(js_arr[0]);
			$('#' + MO_UPLOAD.param.cur_id).replaceWith(dis_arr.join(''));
		}
		else if(MO_UPLOAD.param._switch == 'singleImage') 
		{
			$('#'+MO_UPLOAD.param.check_id).attr('value',js_arr[1]);
		}
		else
		{
			;
		}
	}
}

//删除上传附件
function deleteUpload (del_class)
{
	var del_class = arguments[0];
	if (arguments[1]) del_class = arguments[1];  //防止删除其他控件的隐藏域
	if (arguments[2]) {var option=arguments[2]; option['autoStart']=false; MainOneUpload(option)}; //初始化全局配置
	if (arguments[2]&&MO_UPLOAD.param.show_id != undefined) $('#'+MO_UPLOAD.param.show_id).val(''); //有第二个参数并且有show_id为单文件删除//显示隐藏的为空
	
	//删除上传附件
	$("."+del_class).remove();
	//验证是否上传
	var dis_btn = $('#'+MO_UPLOAD.param.check_id);
	if(($('div[class*=dis-btn-]').length == 0) && (dis_btn.attr('required') == undefined))
		dis_btn.val('').focus().blur();
	//设置上传按钮状态
	if(MO_UPLOAD.class_id != undefined && getAlreadyUploadNUm() < MO_UPLOAD.param.limit)
	{
		var checkstr = '';
		for(var ci=0;ci<getAlreadyUploadNUm();ci++) //验证最小长度
		{
			var checkstr=checkstr+'*';
		}
		dis_btn.val(checkstr).focus().blur();
		$('#' + MO_UPLOAD.param.self_id).removeAttr('disabled');
	}
}

//已经上传的个数
function getAlreadyUploadNUm ()
{
	var au = $('.'+MO_UPLOAD.class_id).length;//已经上传的个数
	flag = MO_UPLOAD.param._switch;
	return (au == undefined) ? 0 : au;
}

//检查上传是否超限
function uploadNumCheck ()
{
	if (MO_UPLOAD.param._switch == 'editImages')
		return false;
	if(getAlreadyUploadNUm() >=  MO_UPLOAD.param.limit)
		return true;
	return false;
}
