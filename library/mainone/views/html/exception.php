<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>500 Exception</title>
<link href="/library/mainone/views/html//css/basc.css" rel="stylesheet" type="text/css"/>
<link href="/library/mainone/views/html/css/styleL.css" rel="stylesheet" type="text/css"/>

</head>
<body>
  <div class="container">
    <div class="pubBox">
      <div class="error_404">
		<!--<img src="images/error.png" class="error_img"/>-->
			<img src="/library/mainone/views/html/images/error_txt.png"/>
			<p>(错误类型：500 Exception)</p>
			<a href="#" class="btn5 db">重试</a>
	  </div>
	  <div class="error_detail2">
			<dl>
				<dt>[show] <?php echo $message; ?></dt>
				<dd>
					<p>
	                
	                <br>
	                <?php echo $sourceFile; ?>
	                </br>
	                <br>
	                <?php echo $trace_string; ?>
	                </br>
	                </p>
				</dd>
			</dl>
	  </div>
    </div>
    <div class="clearfix"></div>
    <div class="foot">Copyright &copy; 2004-2013 MainOne CMS. 铭万公司 版权所有</div>
  </div>
  <div class="clearfix"></div>
</div>

</body>
</html>

