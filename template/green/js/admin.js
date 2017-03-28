/**
 *==========================
 * admin.js 
 * 
 * 后台页面用到的一些通用的js方法
 *
 *===========================
 */

/*补充扩展jQuery的函数*/
jQuery.extend(
{
	/**
	 * 打印输出对象 方便调试
	 * @param 要打印的变量
	 */
	ext_dump: function(e) 
	{ 
		if (typeof(e) == 'object')
		{
			var s = "";  
			for (var property in e) 
			{  
				s = s + "\n "+property +": " + e[property] ;  
			}  
			console.log(s);
			alert(s);
			return false;
		}
		console.log(s);
		alert(e);
		return false;
	},

	/**
	 * 获取容器里所有选中的状态checkbox的值
	 * container_id ： checkbox的容器ID
	 * model ： 返回值模式 数组 or 逗号分隔字符串
	 */
	ext_checkSelected: function(container_id,model)
	{
		var checked_list = $('#'+container_id+' input:checkbox:checked');
		var tmp = new Array();
		$.each(checked_list,function(i,n){
			tmp.push($(n).val());
		});
		return (model == 'arr') ? tmp : tmp.join(','); 
	},

	/**
	 * 万能的计算长度函数
	 * @param 被计算长度的变量 支持所有js数据类型
	 * @param 当计算字符的长度时 此参数将决定中文字符的计算方式，默认为一个中文字符算一个字符计算
	  *       当此参数设为false时，一个中文字符将计算成两个
	 */
	ext_count: function(elm,charwidth) 
	{
		if(charwidth === undefined)
			charwidth = true;

		var _type = typeof elm;  
		switch (_type)
		{
			case 'string':
				{
					var step = 1,len=0;
					if(!charwidth)
					{
						step = 2;
					}
						
					for(var i=0;i<elm.length;i++)
					{
						if(elm.charCodeAt(i) >= 0x4e00 && elm.charCodeAt(i) <= 0x9fa5)
							len+=step;
						else
							len++;
					}
					return len;
				}
				break;
			case 'number':
				{
					return String(elm).length;
				}
				break;
			case 'object':
				{
					var n = 0;                   
					for(var i in elm)       
						n++;                                  
					return n;   
				}
				break;
			case 'undefined':
				{
					return 'undefined';
				}
				break;
			case 'function':
				{
					return elm.length;
				}
				break;
			case 'boolean':
				{
					return 1;
				}
				break;
			default:
				return 0;
		}
	}


});




/*依赖jQuery的事件绑定*/
$(function()
{	
	/*textarea控件的maxlength属性实现*/
	jQuery.fn.maxlength = function()
	{	
		$("textarea[maxlength]").keypress(function(event)
		{ 
			var key = event.which;		
			if(key >= 33 || key == 13) 
			{
				var maxLength = $(this).attr("maxlength");
				var length = this.value.length;
				if(length >= maxLength) 
				{	
					event.preventDefault();
				}
			}
		});
	}

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


	/*
	全选反选
	<table class="tabelTB" id="checkbox-list">
		<tr><th width="10%">选择</th></tr>
		<tr><td><input type="checkbox" /></td></tr>
		<tr><td><input type="checkbox" /></td></tr>
	</table>
	<input type="checkbox" class="Check-All-Toggle" container-id="checkbox-list"/>
	全选反选触发元素上有两个属性:
	1、class="Check-All-Toggle"，不可变属性
	2、container-id="checkbox-list"， container-id为包含checkbox的容器ID，可变属性
	*/
	var check_opt = {
		"container_id":$('.Check-All-Toggle').attr('container-id')  //checkbox容器ID
	};
	$('.Check-All-Toggle').bind('click',function()
	{	
		var this_checked = $(this).attr('checked');                                     //本身
		var this_state = this_checked == undefined ? false : true;                      //本身当前状态
		var checkbox_list = $('#'+check_opt.container_id+' input:checkbox');                      //容器里面的所有checkbox
		var checked_list = $('#'+check_opt.container_id+' input:checkbox:checked');               //容器里面的所有选中的checkbox
		var not_checked_list = $('#'+check_opt.container_id+' input:checkbox:not(:checked)');     //容器里面的所有没选中checkbox

		//效果一
		//checkbox_list.attr('checked',this_state);//容器里的checkbox状态跟随自己变化	

		//效果二 开启效果2时，请注释掉“checkbox列表绑定点击事件”
		if (this_state)
		{
			checkbox_list.attr('checked',this_state);//容器里的checkbox状态跟随自己变化	
		}
		else 
		{
			checked_list.attr('checked',this_state);
			not_checked_list.attr('checked',!this_state);
		}
	});

	//checkbox列表绑定点击事件
	/*$('#'+check_opt.container_id+' input:checkbox').bind('click',function()
	{
		var not_checked_list = $('#'+check_opt.container_id+' input:checkbox:not(:checked)');
		if (not_checked_list.length >0)
			$('.Check-All-Toggle').attr('checked',false);
		else
			$('.Check-All-Toggle').attr('checked',true);
	});*/
});

/**删除一个
* url
* msg 删除成功时的提示信息
* formname 表单的name
*/
function operateOne(url,msgConfirm)
{
	if (url,msgConfirm == undefined)
	{
		window.location.href = url;
	}

	var throughBox = art.dialog.through;
	throughBox({content: msgConfirm,lock:true,fixed:true,icon:'question'},function()
	{
		window.location.href = url;
	},
	function()
	{
		//art.dialog.tips('你取消了操作');
	});
}


/**
 * 简易批量操作
 * @param url 
 * @param msg 提示信息
 */

function confirmurl(url,message) 
{
	if(confirm(message))
	{
		location.href=url;
	}
} 

/**
 * 提交表单
 */
function formSubmit()
{
	$('#myForm').submit();
}

function formCancel()
{
	history.back();
}


/**
 * 单项操作
 */
function singleOperate(url,msg,formname)
{
	var formName;
	if(formname == '' || formname == undefined){
		formName = "myForm";
	}else{
		formName = formname;
	}
		
	if(msg == '' || confirm(msg)){
		$("#"+formName).attr("action",url).submit();
	}
	
		
}


/**
 * 批量操作
 * 操作按钮属性  
	<input type="button" class="btn5" value="删除" 
	onclick="batchOperate(this)" 
	form-id="batch-form" 
	container-id="search-list"  
	form-action="<!--{$baseurl}-->/content/column/del" 
	empty-tips="请选择要删除的记录！" 
	confirm-tips="你确定要删除吗？"/>

	属性说明：
	onclick属性必写的 传this
	form-id 要操作的表单的ID
	container-id 批量操作列表checkbox的容器ID
	form-action 请求操作的地址
	empty-tips 选择为空提示
	confirm_tips 确认操作提示 ，如果不需要确认框，删除此属性

 */
function batchOperate (obj)
{
	var _obj = $(obj);
	var options = {
	"form_id":_obj.attr('form-id'),
	"container_id":_obj.attr('container-id'),
	"form_action":_obj.attr('form-action'),
	"empty_tips":_obj.attr('empty-tips'),
	"confirm_tips":_obj.attr('confirm-tips'),
	"is_selected":_obj.attr('is-selected'),
	"max_num":_obj.attr('max-num'),
	"max_tips":_obj.attr('max-tips')
	};

	if(options.is_selected == undefined)
		options.is_selected = 'true';

	if(options.is_selected == 'false')
		$('#'+options.container_id+' input:checkbox').attr('checked',true);

	/*if(options.container_id)
	{
		var checked_number = $('#'+options.container_id+' input:checkbox:checked').length;  //选中的复选框数量
		if (!checked_number)
		{
			art.dialog.alert(options.empty_tips,'warning');
			return false;
		}
	}*/

	var checked_number = $('#'+options.container_id+' input:checkbox:checked').length;  //选中的复选框数量
	
	if(options.max_num != undefined && checked_number>options.max_num)
	{
		art.dialog.alert(options.max_tips,'warning');
		return false;
		
	}
	if (!checked_number && options.container_id)
	{
		art.dialog.alert(options.empty_tips,'warning');
		return false;
	}else 
	{
		if (options.confirm_tips == undefined)
		{
			$('#'+options.form_id).attr('action',options.form_action);
			$('#'+options.form_id).submit();
			return false;
		}

		var throughBox = art.dialog.through;
		throughBox({content: options.confirm_tips,lock:true,fixed:true,icon:'question'},function()
		{
			$('#'+options.form_id).attr('action',options.form_action);
			$('#'+options.form_id).submit();
			this.content('正在请求数据，请稍后...');
			return false;
		},
		function()
		{
			//art.dialog.tips('你取消了操作');
		});
	}
	
	
	
	
	
}

/**
 * 确认提示框
 * @param1 url确定后的跳转链接
 * @param2 确认框内的提示语 默认为"你确定吗？"
 * @param3 是否显示请求状态信息，例如：正在请求数据，请稍后...,默认显示，false为不显示
 */
function MoConfirm ()
{
	var url = arguments[0];
	var tip = arguments[1] ? arguments[1] : '确认删除？';
	var request_state = arguments[2] == 'false' ? false : true;
	var throughBox = art.dialog.through;
	throughBox({content: tip,icon:'question',lock:true,fixed:true},function()
	{
		window.location.href=url;
		if(request_state)
		{
			this.content('正在请求数据，请稍后...');
		}
		else
		{
			this.close();
		}
		return false;
	},
	function()
	{
		//art.dialog.tips('你取消了操作');
	});
}

/**
 * 添加修改角色中 权限设置
 * @param obj
 */
function checknode(obj)
{
    var chk = $("input[type='checkbox']");
    var count = chk.length;
    var num = chk.index(obj);
    var level_top = level_bottom =  chk.eq(num).attr('level');
    var parent = chk.eq(num).attr('parentid');
    for (var i=num; i>=0; i--)
    {
            var le = chk.eq(i).attr('level');
            if(eval(le) < eval(level_top)) 
            {
                chk.eq(i).attr("checked",true);
                var level_top = level_top-1;
            }
    }
    for (var j=num+1; j<count; j++)
    {
            var le = chk.eq(j).attr('level');
            if(chk.eq(num).attr("checked")=="checked") {
                if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",true);
                else if(eval(le) == eval(level_bottom)) break;
            }
            else {
                if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",false);
                else if(eval(le) == eval(level_bottom)) break;
            }
    }
    var checklist = $('#'+parent+' input:checkbox:checked'); //td内选中checkbox的数量
    if(checklist.length>0)
    {
        $("."+parent).attr('checked',true);
    }else
    {
        $("."+parent).attr('checked',false);
    }

}

/**
 *操作成功后的提示
 *@param info 操作后的返回信息success成功 error失败 info信息提示
 */
function Moalert(info){
	if(info == 'success'){
		
		art.dialog.alert('操作成功!','succeed');
		
	}else if(info == 'error'){
		art.dialog.alert('操作失败!','error');
		
	}else{
		art.dialog.alert(info,'warning');
	}
}


function editPassword(userid)
{
	window.top.art.dialog.open('/admin/admin/login/editpwd',{
				title:'修改密码',
				id:'editpwd',
				width:'580px',
				height:'350px',
				lock:true,
			    ok:function(){
			    	var myframe = this.iframe.contentWindow;
			    	password = myframe.document.getElementById('password');
			    	password2 = myframe.document.getElementById('password2');
			    	//密码要求2-15个字符
			    	if(password.value.length>1 && password.value.length<16)
			    	{
				    	if(password2.value==null || password2.value=='' || password2.value!=password.value)
				    	{
				    		password2.focus();
				    	}else{
				    		myframe.document.forms['myForm'].submit();
				    		window.top.art.dialog.alert('修改成功！');
				    		var dialog = window.top.art.dialog({id:'editpwd'});
				    		
				    		setTimeout(function(){dialog.close();},300);
				    		//setTimeout("location.reload()",2000);
				    	}
			    	}else{
			    		password.focus();
			    	}
			    	return false;
			    },
			    cancel:function(){
			    	window.top.art.dialog({id:'editpwd'}).close();
			    }
			});
}

/**级联菜单(选中状态)*/
function selectmenu(url,top,submenu,datas){
  	var number=$("#"+top+" :selected").val();
	$.ajax({
			  type:"POST",
			  url:url,
			  data:"id="+number+"&datas="+datas,
			  success:function(msg){
				  $("#"+submenu).html(msg);    
			  }
			  });
  
}

function sitemap()
{
	window.top.art.dialog.open('/admin/admin/index/map',{
		id:'map',
        title: '网站地图',
        lock: true
    });
}


//添加常用操作
function shortcut()
{
	window.top.art.dialog.open('/admin/admin/index/shortcut',{
		title:'添加常用操作',
		id:'shortcut',
		width:'500px',
		height:'350px',
		lock:true,
	    ok:function(){     	
	    	var iframe = this.iframe.contentWindow;
	    	iframe.document.getElementById('myForm').submit();
	    	
	    	window.top.art.dialog.alert('设置成功！','succeed',function(){
	    		window.parent.location.reload();
	    	});
//	    	window.top.art.dialog({id:'shortcut'}).close();
//	    	window.top.art.dialog.alert('设置成功！');
//	    	setTimeout("location.reload()",2000);
	    	return false;
	    },
	    cancel:function(){
	    	window.top.art.dialog({id:'shortcut'}).close();
	    }
	});
}
