/*text  提示框中显示的文字*/  
/*url   删除所要执行的方法*/
/*id    要删除信息的id*/
function deldialog(text,url,id){
	var dialog = "<div class='notif deldiago'><h4>提示</h4><div class='Ncon'><div class='Ncont'><textarea class='message' readonly>"+text+"</textarea></div>";
	dialog+="<div class='Nsubm' style='padding-top:6px;'><input class='btn3' type='button' value='确定' onClick='deletedata(\""+url+"\",\""+id+"\")' hideFocus='hide'/>&nbsp;&nbsp;&nbsp;<input class='btn4' type='button' value='取消' hideFocus='hide' onClick='hidmaker()'/></div></div></div>";
   
    if($(window.parent.document).find("#parent").css('display') !="block"){
		
		$(window.parent.document).find("#parent").css('display','block')
	}
	$(window.parent.document).find("#parent").append(dialog);
	
	var width = parseInt($(window.parent.document).width());
	var height = parseInt($(window.parent.document).height());

	var marker = $(window.parent.document).find("#maker").addClass('maker');
	
	if($(window.parent.document).find("#maker").css('display') !='block')
	{
		$(window.parent.document).find("#maker").css('display','block');
	}
	
	$(window.parent.document).find("#maker").css({width:width+"px", height:height+"px"});
	var top = (height-parseInt($(window.parent.document).find(".deldiago").css('height')))/2-50;
	var left = (width-parseInt($(window.parent.document).find(".deldiago").css('width')))/2;
	
	$(window.parent.document).find(".deldiago").css({top:top+"px", left:left+"px"});
}
/*url 需要执行的方法*/
/*id 删除信息的id号可以是一个字符串，多个id，'12,23,34'*/

function deleteInfor(url,id){
	
	$(window.parent.document).find('#maker').css('display','none');
	$(window.parent.document).find("#parent").css('display','none');
	$(window.parent.document).find(".deldiago").remove();
	window.location.href=url+"?id="+id;
	
}
/*拼接选中复选框的id*/
function joinId(url){
	
	var ids ="";
	
	$(".ischeck").each(function(){
		   if($(this).attr('checked')=='checked'){
			   ids+=$(this).attr('reg')+",";
		   }
     });
	
	ids = ids.substring(0,ids.length-1);
	deldialog("确定要删除吗？",url,ids);
}

