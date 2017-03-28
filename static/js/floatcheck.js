$(function(){
	
	$("#name").live('focus',function(){
		
		$("#nameTip").attr('class','');
		$("#nameTip").html('请输入1-50个字符');
		$("#nameTip").addClass('onFocus');
		
	});
	
	$("#name").live('blur',function(){
		$("#nameTip").attr('class','');
		var len = $("#name").val().replace(/\s/ig,'').length;

		if($("#name").val()=="" || $("#name").val().length>50 || len == 0){
			
			$("#nameTip").html('请输入1-50个字符');
			$("#nameTip").addClass('onError');
			
		}else{
			
			$("#nameTip").html('输入正确');
			$("#nameTip").addClass('onCorrect');
		}
		
	})
})