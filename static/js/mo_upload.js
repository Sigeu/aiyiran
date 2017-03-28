/*
*  -------------------------------------------------
*   统一上传方法
*  -------------------------------------------------
*/
MO_UPLOAD = {};//全局上传参数设置
flag = '';//统一上传类型

/*获取站点根目录*/
MO_HOME_URL = window.MO_HOME_URL || '/';

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
		param       : {}
	};

	//合并覆盖原配置
	for (key in option) _option[key] = option[key];

	//拼接上传唯一标示符
	var class_id = 'mo_div_'+_option.upload_id;
	_option['class_id'] = class_id;
	
	MO_UPLOAD = _option;
    
	//弹出上传框之前检查上传是否超限
	if(uploadNumCheck() && (MO_UPLOAD.param._switch != 'goodsedit') && (MO_UPLOAD.param._switch != 'smallgoodsedit') && (MO_UPLOAD.param._switch != 'sku_img_edit') && (MO_UPLOAD.param._switch != 'sku_img_add') && (MO_UPLOAD.param._switch != 'standard')&& (MO_UPLOAD.param._switch != 'app'))
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
	window.top.art.dialog.open(MO_HOME_URL + 'admin/dialog/upload/index/flag/' + flag + '/au/'+au+'/?setting='+MO_UPLOAD.setting,
	{
			title  : MO_UPLOAD.title,
			id     : MO_UPLOAD.upload_id,
			width  : MO_UPLOAD.width,
			height : MO_UPLOAD.height,
			lock   : MO_UPLOAD.lock,
			ok:function()
			{
				eval(_option.callFunName).apply(this);
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
	var edit_arr = new Array();                 //修改表单使用数据
	var dis_arr = new Array();					//页面及时显示效果
	var js_arr = new Array();
	

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

			var del_class = 'dis-btn-'+_i;
			data_arr.push('<span id="'+ del_class+'-form" class="'+del_class+' '+MO_UPLOAD.class_id+'">');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][selfname]"    value="'+js_arr[0]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][path]"        value="'+js_arr[1]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][isimage]"     value="'+js_arr[2]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][iswatermark]" value="'+js_arr[3]+'" />');
				data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][size]"        value="'+js_arr[4]+'" />');
				
				//判断是不是缩略图
				if(MO_UPLOAD.param._switch != 'smallgoodsadd' && MO_UPLOAD.param._switch != 'smallgoodsedit')//常规图
				{
					data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][imgtype]"  value="0" />');
				}else{
					//缩略图
					$imgsize = $('#img_size'+MO_UPLOAD.param.return_value).val();
					data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][imgsize]"  value="'+$imgsize+'" />');
					data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][imgtype]"  value="1" />');
				}
                
                if (MO_UPLOAD.param._switch == 'app') {
                    if (MO_UPLOAD.param.update_id) {
                        data_arr.push('<input type="hidden" name="oldids[]"  value="'+ MO_UPLOAD.param.update_id +'"/>');
                        data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][id]"  value="'+ MO_UPLOAD.param.update_id +'"/>');
                    }
                    
                    if (MO_UPLOAD.param.type) {
                        data_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][type]"  value="'+ MO_UPLOAD.param.type +'"/>');
                    }
                }
                
			data_arr.push('</span>');
			
            if (MO_UPLOAD.param._switch == 'app_add') {//前台添加图片
                var name = js_arr[0];
                dis_arr.push('<div style="margin:5px 5px 5px 0px;" id="image_' + _i + '">');
                dis_arr.push('<span id="form_'+ _i +'">');
                dis_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][type]" value="2" />');
                dis_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][selfname]"    value="'+js_arr[0]+'" />');
                dis_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][path]"        value="'+js_arr[1]+'" />');
                dis_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][isimage]"     value="'+js_arr[2]+'" />');
                dis_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][iswatermark]" value="'+js_arr[3]+'" />');
                dis_arr.push('<input type="hidden" name="'+MO_UPLOAD.return_id+'['+_i+'][size]"        value="'+js_arr[4]+'" />');
                dis_arr.push('</span>');
                dis_arr.push('<input type="text" readonly="readonly" id="imagename_' + _i + '" value="' + name + '" size="35px"/>');
                dis_arr.push('&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="图片上传" class="btn5" onclick="uploadAccessory({\'limit\':\'2\', \'_switch\':\'app\', \'index\':'+ _i +', \'type\':\'2\'})"/>');
                dis_arr.push('&nbsp;<input type="button" hidefocus="hide" value="删除" class="btn5" onclick="deleteImage(' + _i + ')"/>');
                dis_arr.push('</div>');
            } else {
                dis_arr.push('<div id="' + del_class + '" class="'+del_class+'" style="margin-bottom:10px">');
                dis_arr.push('<input type="text"  onfocus="this.blur()" style="background-color:#eee;color:#aaa" value="'+js_arr[0]+'" readonly class="Iw290"/>&nbsp;&nbsp;&nbsp;');
                if(MO_UPLOAD.param._switch != 'logistics')
                {
                    if(MO_UPLOAD.param._switch != 'accessory')
                    {
                        dis_arr.push('图片ALT注释&nbsp;&nbsp;<input type="text" name="'+MO_UPLOAD.return_id+'['+_i+'][alt]" value="" maxlength="100"/>&nbsp;&nbsp;&nbsp;');
                    }
                }
                dis_arr.push('<input type="button" class="btn5" value="删除" onclick="deleteUpload(\''+del_class+'\')"/>');
                if (MO_UPLOAD.param._switch == 'goodsadd' || MO_UPLOAD.param._switch == 'goodsedit') {
                        dis_arr.push('&nbsp;&nbsp;&nbsp;<input type="button" class="btn5" value="浏览" onclick="uploadAccessory({\'limit\':\'1000\',\'_switch\':\'goodsedit\',\'self_id\':\'uploadButton\',\'cur_id\':\'' + del_class + '\',\'edit_id\':\'' + _i + '\' ,\'goods_id\':\'' + MO_UPLOAD.param.goods_id + '\'})"/>');
                }
                dis_arr.push('</div>');
            }
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
		else if (MO_UPLOAD.param._switch == 'head_img') {
			$('#'+MO_UPLOAD.param.dis_place).html(data_arr.join(''));
			$('#'+MO_UPLOAD.param.self_id).val(js_arr[1]);
		}
		//商品图片添加修改
		else if(MO_UPLOAD.param._switch == 'goodsadd')
		{
			var dis_btn = $(win.document).find('#'+MO_UPLOAD.param.self_id);	//图片上传浏览按钮
			$(win.document).find('form').append(data_arr.join(''));	//向来源页面追加上传文件的信息
			dis_btn.before(dis_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用
			//$('#'+MO_UPLOAD.param.dis_place).append(dis_arr.join(''));
			
		}else if(MO_UPLOAD.param._switch == 'logistics')   //物流单图片添加
		{
			$.post('/admin/logistics/logistics/addAlbum' , {'logistics_id':MO_UPLOAD.param.logistics_id,'info':js_arr} , function (item) {
				
				var ret = jQuery.parseJSON(item);
				var path = ret.path;   
				var width = ret.width;   
				var height = ret.height;
                var name = ret.path; 
				var content = $('#editcontent').val();
				bjimg(path,width,height,content,name);
			});
			$(win.document).find('#'+MO_UPLOAD.param.dis_place).html(data_arr.join('')+dis_arr.join(''));	
		}
		
		//商品图片对应修改
		else if (MO_UPLOAD.param._switch == 'goodsedit') {
			
			$.post('/admin/modules/goods/editAlbum' , {'goods_id':MO_UPLOAD.param.goods_id , 'albumid':MO_UPLOAD.param.edit_id , 'info':js_arr} , function (item) {
					$('#' + MO_UPLOAD.param.cur_id + '-form').replaceWith(data_arr.join(''));
			});
			//$('#' + MO_UPLOAD.param.cur_id).val(js_arr[0]);
			$('#' + MO_UPLOAD.param.cur_id).replaceWith(dis_arr.join(''));
		}
		// 商品缩略图片对应添加
		else if(MO_UPLOAD.param._switch == 'smallgoodsadd')
		{
			var dis_btn = $(win.document).find('#return_value'+MO_UPLOAD.param.return_value);// 缩略图路径文本框
			var small_info = $(win.document).find('#small_img_id'+MO_UPLOAD.param.return_value);// 缩略图上传浏览按钮
			dis_btn.val(js_arr[0]);
			$('#small-img-' + MO_UPLOAD.param.return_value + '-form').html(data_arr.join(''));//更新缩略图的上传信息
	
		}
		//商品缩略图片对应修改
		else if (MO_UPLOAD.param._switch == 'smallgoodsedit') {
			 
			var dis_btn = $(win.document).find('#return_value'+MO_UPLOAD.param.return_value);// 缩略图上传浏览按钮
			var small_info = $(win.document).find('#small_img_id'+MO_UPLOAD.param.return_value);// 缩略图上传浏览按钮
			dis_btn.val(js_arr[0]); 
			//$(win.document).find('form').append(data_arr.join(''));
			$.post('/admin/modules/goods/editAlbum' , {'goods_id':MO_UPLOAD.param.goods_id ,'info':js_arr,'albumid':MO_UPLOAD.param.albumid,'img_type':1,'img_size':MO_UPLOAD.param.img_size} , function (item) {
			    if (item == 0) {
			    	$('#small-img-' + MO_UPLOAD.param.return_value + '-form').html(data_arr.join(''));
			    }			
			});
		}
		//商品规格添加（修改）
		else if (MO_UPLOAD.param._switch == 'sku_img_add') {
            var index1=js_arr[1].lastIndexOf(".");
			var index2=js_arr[1].length;
			var postf=js_arr[1].substring(index1,index2);
            $.post('/admin/modules/goods/addGoodsStandardImg' , {'info':js_arr} , function (data) {
				if(postf == '.swf'){
                    $('#'+MO_UPLOAD.param.img_id).attr('src','/admin/template/images/default/np_Xsmall.jpg');
                } else {
                    $('#'+MO_UPLOAD.param.img_id).attr('src', '/static/uploadfile/goodsstandard/' + data);
                }
                $('#' + MO_UPLOAD.param.hid_id).val(data);
			});
		}
		//商品规格修改(暂时没用)
		else if (MO_UPLOAD.param._switch == 'sku_img_edit')
		{	
			var index1=js_arr[1].lastIndexOf(".");
			var index2=js_arr[1].length;
			var postf=js_arr[1].substring(index1,index2);
			if(postf == '.swf'){
				$('#'+MO_UPLOAD.param.img_id).attr('src','/admin/template/images/default/np_Xsmall.jpg');
			}else{
				$('#'+MO_UPLOAD.param.img_id).attr('src',js_arr[1]);
			}
			//js_arr[0]  图片名
			//js_arr[1]  图片存放路径
			$('#'+MO_UPLOAD.param.hid_id).val(js_arr[1]);
			$('#'+MO_UPLOAD.param.img_data_id).html(data_arr.join(''));
			$.post('/admin/modules/goodsstandard/editAlbum' , {'editid':MO_UPLOAD.param.upload_id , 'info':js_arr} , function (data) {
			
			});
		}
		//广告添加修改
		else if (MO_UPLOAD.param._switch == 'ad_img')
		{	
			var index1=js_arr[1].lastIndexOf(".");
			var index2=js_arr[1].length;
			var postf=js_arr[1].substring(index1,index2);
			if(postf == '.swf'){
				$('#'+MO_UPLOAD.param.img_id).attr('src','/admin/template/images/default/np_Xsmall.jpg');
			}else{
				
				$('#'+MO_UPLOAD.param.img_id).attr('src',js_arr[1]);
			}
			//js_arr[0]  图片名
			//js_arr[1]  图片存放路径
			$('#'+MO_UPLOAD.param.hid_id).val(js_arr[1]);
			$('#'+MO_UPLOAD.param.img_data_id).html(data_arr.join(''));
		}
		else if (MO_UPLOAD.param._switch == 'friend_link')
		{

			$(win.document).find('#'+MO_UPLOAD.param.dis_place).html(data_arr.join('')+dis_arr.join(''));	
//			$(win.document).find('#'+MO_UPLOAD.param.check_id).val('true').focus().blur();
			$('#logo').val('1');
		} // 商品缩略图片对应添加
		else if(MO_UPLOAD.param._switch == 'logistics')
		{
			var dis_btn = $(win.document).find('#'+MO_UPLOAD.param.self_id);//浏览按钮
			console.log(dis_btn);
			$(win.document).find('form').append(data_arr.join(''));	//向来源页面追加上传文件的信息
			dis_btn.before(dis_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用
			$(win.document).find('#'+MO_UPLOAD.param.check_id).val('true').focus().blur();//设定判断时候上传附件，以供提交表单时验证是否上传了附件。
			if(getAlreadyUploadNUm() >= MO_UPLOAD.param.limit)	dis_btn.attr('disabled','disabled');
		}
        
        else if(MO_UPLOAD.param._switch == 'standard')
		{
			var index1=js_arr[1].lastIndexOf(".");
			var index2=js_arr[1].length;
			var postf=js_arr[1].substring(index1,index2);
			
            $.post('/admin/modules/goods/addGoodsStandardImg' , {'info':js_arr} , function (data) {
				if(postf == '.swf'){
                    $('#'+MO_UPLOAD.param.img_id).attr('src','/admin/template/images/default/np_Xsmall.jpg');
                }else{
                    $('#'+MO_UPLOAD.param.img_id).attr('src', '/static/uploadfile/goodsstandard/' + data);
                }
                $('#' + MO_UPLOAD.param.hid_id).val(data);
                $('#'+MO_UPLOAD.param.td_id).hover(
                    function () {
                        $(this).removeClass("hidden");
                        $(this).addClass("show");
                    },
                    function () {
                        $(this).removeClass("show");
                        $(this).addClass("hidden");
                    }
                 );
			});
		} else if(MO_UPLOAD.param._switch == 'app') {
			$('#form_' + MO_UPLOAD.param.index).html(data_arr.join(''));
            $('#imagename_' + MO_UPLOAD.param.index).val(js_arr[0]);
		} else if (MO_UPLOAD.param._switch == 'app_add') {
            var dis_btn = $(win.document).find('#'+MO_UPLOAD.param.self_id);//图片上传浏览按钮
			dis_btn.before(dis_arr.join(''));//向浏览按钮前追加上传信息显示，只供显示用
        }
	}
}

//删除上传附件
function deleteUpload (del_class)
{
	//删除上传附件
	$("."+del_class).remove();
	//验证是否上传
	var dis_btn = $('#'+MO_UPLOAD.param.check_id);
	if(($('div[class*=dis-btn-]').length == 0) && (dis_btn.attr('required') == undefined)) {
		dis_btn.val('').focus().blur();
    }

	//设置上传按钮状态
	if(MO_UPLOAD.class_id != undefined && getAlreadyUploadNUm() < MO_UPLOAD.param.limit) {
		$('#uploadButton').removeAttr('disabled');
    }
    
	if ($('#'+MO_UPLOAD.param.dis_place+' input').length == 0) {
		$('#'+MO_UPLOAD.param.dis_place).html('<input type="text" name="" value="" class="Iw290" />');
    }
    
    if (typeof (deleteButtonOperation) === 'function') {
        deleteButtonOperation ();
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
	if (MO_UPLOAD.param._switch == 'goodsedit')
		return false;
	if(getAlreadyUploadNUm() >=  MO_UPLOAD.param.limit)
		return true;
	return false;
}