/**
 * 附件上传 
 * @param uploadid 弹出层ID,防止重复弹出
 * @param title 标题
 * @param 返回值处理的ID
 * @callFunName 回调函数名称
 * @setting 上传设置，用逗号区分,('1,gif|jpg|jpeg|png|bmp,1,1,2,file') 
			setting[0]：允许上传个数, 
			setting[1]：允许上传类型, 
			setting[2]：是否显示目录浏览, 
			setting[3]: 是否显示添加水印, 
			setting[4]: 上传大小限制, 
  			setting[5]: picture：图片类型，file：文件类型，media：多媒体文件类型 
			注：假如有setting[1]，此参数无效
 * @authkey 加密验证 防止外链非法shell
 */
function flashupload(uploadid,title,returnid,callFunName,setting,authkey)
{
	window.top.art.dialog.open(
			'/admin/dialog/dialog/flashUpload?setting='+setting+'&authkey='+authkey,
			{
				title:title,
				id:uploadid,
				width:'650px',
				height:'350px',
				lock:true,
			    ok:function(){
			    	eval(callFunName).apply(this,[uploadid,returnid]);
			    },
			    cancel:true
			}
	)
}

/*
*  -------------------------------------------------
*   统一上传接口
*  -------------------------------------------------
*/
function MainOneUpload (option)
{
	var _option=
	{
		upload_id   : 'accessory_upload',
		title       : '附件上传',
		return_id   : 'accessory',
		callFunName : 'accessoryUpload',
		setting     : '',
		width       : '650px',
		height      : '350px',
		lock        : true
	};
	for (key in option) _option[key] = option[key];//合并覆盖原配置


	window.top.art.dialog.open('/admin/dialog/upload/index/?setting='+_option.setting,
	{
			title  : _option.title,
			id     : _option.upload_id,
			width  : _option.width,
			height : _option.height,
			lock   : _option.lock,
			ok:function()
			{
				eval(_option.callFunName).apply(this,[_option.upload_id , _option.returnid]);
			},
			cancel:true
	});
}

function changeimage(uploadid,returnid)
{
	var win = art.dialog.open.origin;//来源页面
	var iframe = this.iframe.contentWindow;
	var hid_filename = iframe.document.getElementById('hid_filename').innerHTML;
	var hid_savename = iframe.document.getElementById('hid_savename').innerHTML;
	var hid_src = iframe.document.getElementById('hid_src').innerHTML;
	var hid_size = iframe.document.getElementById('hid_size').innerHTML;
	var hid_isimage = iframe.document.getElementById('hid_isimage').innerHTML;
	var hid_water_mark = iframe.document.getElementById('hid_water_mark').innerHTML;
	hid_filename = hid_filename.substr(0,hid_filename.length-1);
	hid_savename = hid_savename.substr(0,hid_savename.length-1);
	hid_src = hid_src.substr(0,hid_src.length-1);
	hid_size = hid_size.substr(0,hid_size.length-1);
	hid_isimage = hid_isimage.substr(0,hid_isimage.length-1);
	hid_water_mark = hid_isimage.substr(0,hid_water_mark.length-1);
	if(hid_filename != '')
	{
		win.document.getElementById(returnid+'_filename').value = hid_filename;
		win.document.getElementById(returnid+'_savename').value = hid_savename;
		win.document.getElementById(returnid+'_src').value = hid_src;
		win.document.getElementById(returnid+'_size').value = hid_size;
		win.document.getElementById(returnid+'_water_mark').value = hid_water_mark;
	}
}

//附件上传
_i = 1;//定义一个全局变量
function accessoryUpload (uploadid,returnid)
{
	var win = art.dialog.open.origin;		//来源页面
	var iframe = this.iframe.contentWindow;	//Iframe
	var $iframe = $(iframe.document);
	var $data = $iframe.find('.upload-data');//上传后的数据
	var html_arr = new Array();
	var display_arr = new Array();
	if($data.length)
	{
		$.each($data,function(i,n)
		{
			var _n = $(n);
			html_arr.push('<div class="dis-btn-'+_i+' div_'+uploadid+'"><input type="hidden" name="'+returnid+'['+_i+'][savename]" value="'+_n.attr('savename')+'" attribute="savename"/>');
			html_arr.push('<input type="hidden" name="'+returnid+'['+_i+'][size]" value="'+_n.attr('size')+'" attribute="size"/>');
			html_arr.push('<input type="hidden" name="'+returnid+'['+_i+'][src]" value="'+_n.attr('src')+'" attribute="src"/>');
			html_arr.push('<input type="hidden" name="'+returnid+'['+_i+'][filename]" value="'+_n.attr('filename')+'" attribute="filename"/>');
			html_arr.push('<input type="hidden" name="'+returnid+'['+_i+'][water_mark]" value="'+_n.attr('water_mark')+'" attribute="water_mark"/>');
			html_arr.push('<input type="hidden" name="'+returnid+'['+_i+'][isimage]" value="'+_n.attr('isimage')+'" attribute="isimage"/></div>');
			display_arr.push('<div class="dis-btn-'+_i+'" style="margin-bottom:10px"><input type="text" disabled value="'+_n.attr('savename')+'" readonly class="Iw290"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn5" value="删除" onclick="deleteUpload('+_i+')"/></div>');
			_i += 1;
		});

		//设定判断时候上传附件，以供提交表单时验证是否上传了附件。
		var id_up = $(win.document).find('#isUpload');
		id_up.val('true').focus().blur();
	}
	$(win.document).find('form').append(html_arr.join(''));//向来源页面追加上传文件的信息
	var dis_btn = $(win.document).find('#uploadButton');
	if(dis_btn != undefined)
		dis_btn.before(display_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用

	/*上传完成以后的扩展代码 例如广告图片的特殊处理 有其他特殊处理 继续添加if语句即可*/
	if($(win.document).find('img[thumb="true"]').length != 0)
	{
		var img = $('img[number='+uploadid+']');
		var hidden = $('input[number='+uploadid+']');
		if($('.div_'+uploadid).length > 1)
			$('.div_'+uploadid+':first').remove();

		var new_img = $('.div_'+uploadid).find('input[attribute="src"]').val();
		var file_name = $('.div_'+uploadid).find('input[attribute="filename"]').val();
		if(new_img)
		{
			img.attr('src',new_img);
			hidden.val(file_name);
		}	
	}

	/*上传个数限制*/
	var _upload_size = $(win.document).find('#_upload_size').val();
	if(_upload_size != undefined)
	{
		_upload_size = parseInt(_upload_size);
		if(_upload_size > 0)
		{
			//alert($(win.document).find('.div_'+uploadid).length)
		}
	}

	//alert(parseInt(.val()) > 0);

}


_s = 1;//定义一个全局变量
function formUpload (uploadid,returnid)
{
	var win = art.dialog.open.origin;		//来源页面
	var iframe = this.iframe.contentWindow;	//Iframe
	var $iframe = $(iframe.document);
	var $data = $iframe.find('.upload-data');//上传后的数据
	var html_arr = new Array();
	var display_arr = new Array();
	if($data.length)
	{
		$.each($data,function(i,n)
		{
			var _n = $(n);
			html_arr.push('<div class="dis-btn-'+_s+'"><input type="hidden" name="info['+returnid+']['+_s+'][savename]" value="'+_n.attr('savename')+'" />');
			html_arr.push('<input type="hidden" name="info['+returnid+']['+_s+'][size]" value="'+_n.attr('size')+'" />');
			html_arr.push('<input type="hidden" name="info['+returnid+']['+_s+'][src]" value="'+_n.attr('src')+'" />');
			html_arr.push('<input type="hidden" name="info['+returnid+']['+_s+'][filename]" value="'+_n.attr('filename')+'" />');
			html_arr.push('<input type="hidden" name="info['+returnid+']['+_s+'][water_mark]" value="'+_n.attr('water_mark')+'" />');
			html_arr.push('<input type="hidden" name="info['+returnid+']['+_s+'][isimage]" value="'+_n.attr('isimage')+'" /></div>');
			display_arr.push('<div class="dis-btn-'+_s+'" style="margin-bottom:10px"><input type="text" disabled value="'+_n.attr('savename')+'" readonly class="Iw290"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn5" value="删除" onclick="deleteUpload('+_s+')"/></div>');
			_s += 1;
		});
	}
	$(win.document).find('form').append(html_arr.join(''));//向来源页面追加上传文件的信息
	var dis_btn = $(win.document).find('#'+returnid+'_uploadButton');
	if(dis_btn != undefined)
		dis_btn.before(display_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用

}

//删除上传附件
function deleteUpload (i)
{
	$(".dis-btn-"+i).remove();//删除上传附件
	var dis_btn = $('#isUpload');
	//删除完附件后设置是否上传附件标志。
	if(($('div[class*=dis-btn-]').length == 0) && (dis_btn.attr('required') == undefined)) 
		dis_btn.val('').focus().blur();
}