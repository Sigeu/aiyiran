/*提示框提示信息*/
$(document).ready(function(){
	
	if($("#change").val()=='yes')
	{
		var prompt = $("#prom_text").text();
		
	 	$("#prom_text").html(prompt);
	 	
	     if($("#hidtype").val() == 'success')
	     {
	 		$("#prom_text").addClass('warnCorrect');
	 		
	     }else if($("#hidtype").val()=='error'){
	     	
	 		$("#prom_text").addClass('warnError');
	 		
	     }
	}
	$(".confirm").click(function(){
		
		if($("#url").val()!=""){
			
		    window.location.href=$("#url").val();
		    
		}else{
			
			history.back(-1);
			
		}
	});
});
function load(){
	location.reload();
}

