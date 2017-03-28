function linkage(obj,action)
{
	var val=$(obj).val();
	$.ajax({
		  type:"POST",
		  url:"/admin/content/Fieldmanage/linkage",
		  data:"id="+val,
		  success:function(msg){
			  $("#"+action).html(msg);			  
			  if (msg != "<option value=''>--请选择--</option>") {
				  $("#"+action).show();
			  } else {
				  var num = action.split("_");
				  for (i = 1; i < 5; i++) {
					  if (i >= num[1]) {
						  $("#"+num[0] + "_" + i).hide();
					  }
				  }				 
			  }
		  }
	});
}
function Prelinkage(obj,action)
{
	var val=$(obj).val();
	$.ajax({
		  type:"POST",
		  url:"/message/message/linkage",
		  data:"id="+val,
		  success:function(msg){
			  $("#"+action).html(msg);
			  if (msg != "<option value=''>--请选择--</option>") {
				  $("#"+action).show();
			  } else {
				  var num = action.split("_");
				  for (i = 1; i < 5; i++) {
					  if (i >= num[1]) {
						  $("#"+num[0] + "_" + i).hide();
					  }
				  }				 
			  }
		  }
	});
}