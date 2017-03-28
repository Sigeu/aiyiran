/*提示框提示信息*/
$(document).ready(function(){
	
	$("#okbtn").click(function(){
		
		if($("#url").val()!=""){
			
		    window.location.href=$("#url").val();
		    
		}else{
			
			history.back(-1);
			
		}
	});
});