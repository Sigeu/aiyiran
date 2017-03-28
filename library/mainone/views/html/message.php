<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="<?php echo HOST_NAME;?>library/mainone/views/html/css/basc.css" rel="stylesheet" type="text/css"/>
<style>
body{ padding:10px;}
strong{ font-size:20px; line-height:20px; display:block; padding:10px 0;}
</style>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>提示信息</title>

</head>

<body>


<div class="notif">
	<h4><span class="goback mt15"><a href="javascript:history.go(-1);">返回</a></span>提示</h4>
	<div class="Ncon">
			<p class="Np"><span class="warnCorrect"><?php echo $message; ?></span></p>
	</div>
</div>



<li class="bottom"></li>

</body>
</html>

