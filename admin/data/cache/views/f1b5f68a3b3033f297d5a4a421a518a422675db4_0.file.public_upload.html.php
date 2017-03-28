<?php
/* Smarty version 3.1.30, created on 2017-01-06 15:32:47
  from "D:\xampp\htdocs\aiyiran\admin\template\public\public_upload.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586f481fe89f11_08804568',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f1b5f68a3b3033f297d5a4a421a518a422675db4' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\public\\public_upload.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/baseurl.html' => 1,
  ),
),false)) {
function content_586f481fe89f11_08804568 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告模块-添加广告</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/fileprogress.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php $_smarty_tpl->_subTemplateRender("file:public/baseurl.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!--  artdialog插件  -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/plugins/iframeTools.source.js"><?php echo '</script'; ?>
>

<!--  上传插件  -->
<?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/swfupload/swfupload.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/swfupload/swfupload.queue.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/swfupload/fileprogress.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="JavaScript" type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/swfupload/mo_handlers.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
var swfu;
window.onload = function()
{
	var mo_param = 
	{
		upload_url  : '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/dialog/upload/upload',
		post_param  : {'setting':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
'},
		allow_size  : '<?php echo $_smarty_tpl->tpl_vars['setting']->value['size'];?>
',
		str_type    : '<?php echo $_smarty_tpl->tpl_vars['setting']->value['str_type'];?>
',
		limit       : '<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
',
		flash_url   : '<?php echo @constant('HOST_NAME');?>
static/js/swfupload/swfupload.swf',
		flash9_url  : '<?php echo @constant('HOST_NAME');?>
static/js/swfupload/swfupload_fp9.swf'
	}

	var option = 
	{
		flash_url:mo_param.flash_url,
		flash9_url:mo_param.upload9_url,
		upload_url:mo_param.upload_url,
		post_params:mo_param.post_param,
		file_post_name : "uploadFile",
		file_size_limit:mo_param.allow_size,
		file_types:mo_param.str_type,
		file_types_description:"All Files",
		file_upload_limit:mo_param.limit,
		custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},
		
		debug:false,

		button_width: 75,
		button_height: 28,
		button_text: "选择文件",
		button_text_top_padding: 3,
		button_text_left_padding: 10,
		button_placeholder_id: "mybutton",
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		button_action:SWFUpload.BUTTON_ACTION.SELECT_FILES,
		button_image_url: "<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/swfupload/swfu_bgimg.jpg",

		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete
	};
	swfu = new SWFUpload(option);
	
};

/*
*  -------------------------------------------------
*   水印参数添加
*  -------------------------------------------------
*/
function check_wartermark(obj)
{
	if($(obj).attr('checked')) 
		swfu.addPostParam('iswatermark', '1');
	else 
		swfu.removePostParam('iswatermark');
}
<?php echo '</script'; ?>
>
</head>
<body>
	<div class="notif">
		<div class="layoutBox">
			<div class="layout">
				<dl class="laytab">
					<dt class="focus"><a href="javascript:void(0)">本地上传</a></dt>
					<?php if ($_smarty_tpl->tpl_vars['setting']->value['local']) {?>
					<dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/accessory/local/?setting=<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
&flag=<?php echo $_smarty_tpl->tpl_vars['flag']->value;?>
">本地图库</a></dt>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['setting']->value['folder']) {?>
					<dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/accessory/folder/?setting=<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
&flag=<?php echo $_smarty_tpl->tpl_vars['flag']->value;?>
">目录浏览 </a></dt>
					<?php }?>
				</dl>
			</div>

			<div class="layoutC">
				<div>
					<table class="tabelLR" style="margin:10px 0;">
						<tr>
							<td>	
							<span class="c_pic"><span id="mybutton"  ></span></span>&nbsp;&nbsp;
							<input type="button" hidefocus="hide" value="开始上传" class="btn5" onclick="swfu.startUpload()" style="vertical-align:top">
							<input type="hidden" id="flag" name="flag" value="<?php echo $_smarty_tpl->tpl_vars['flag']->value;?>
"/>
							</td>
						</tr>

						<tr>
							<td class="pTB">
							<span class="warnBlueL">
							<?php if ($_smarty_tpl->tpl_vars['setting']->value['str_type']) {?>
							支持上传<?php echo $_smarty_tpl->tpl_vars['setting']->value['str_type'];?>
 格式的文件，
							<?php }?>
							
							<?php if (!($_smarty_tpl->tpl_vars['flag']->value == 'editImages' || $_smarty_tpl->tpl_vars['flag']->value == 'goodsedit')) {?>
							<?php if ($_smarty_tpl->tpl_vars['setting']->value['limit']) {?>
							最多可以上传<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
个文件。
							<?php }?>
							<?php } else { ?>
							只能上传一个文件
							<?php }?>
							</span>
                            </td>
						</tr>

						<?php if ($_smarty_tpl->tpl_vars['setting']->value['iswatermark']) {?>
						<tr>
							<td class="f333">
                            <span>
                            <input type="checkbox" name='watermark' value='1' onclick="javacript:check_wartermark(this);"/>
                            </span>&nbsp;
                            <label>添加水印</label>&nbsp;&nbsp;&nbsp;
                            <label class="warnBlueL">
							支持为*.jpg;*.png;*.gif格式的文件添加水印
							</label>
                            </td>
						</tr>
						<?php }?>

						<tr>
							<td>
								<fieldset>
									<legend>上传的文件</legend>
									<div  id='fsUploadProgress'><ul class="Lpic"></ul></div>
								</fieldset>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
//页面加载完毕后 自动清理临时文件夹里的内容
(function(){$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/accessory/clearfile');})()
<?php echo '</script'; ?>
>
<?php }
}
