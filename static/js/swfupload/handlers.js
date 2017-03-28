/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */


function fileQueued(file) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}




function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		return true to indicate that the upload should start.
		It's important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("正在上传请稍后...");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}
	
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("正在上传("+percent+" %)请稍后...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		mylist(file, serverData);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("文件上传成功.");
		
	} catch (ex) {
		this.debug(ex);
	}
}

function mylist(file, serverData)
{
	var data = eval('(' + serverData+ ')');
	if(data.isimage == 1)
	{
		img = '<li style="margin-right:5px"><a href="'+data.src+'" title="'+data.savename+'" target="_blank"><img  src="'+data.src+'" /></a></li>';

		//img = '<img width="80" height="130" class="myreturn" style="margin-right:10px;margin-top:10px" src="'+data.src+'"/>'+data.savename;
	}
	else
	{
		img = '<li style="margin-right:5px;"><a title="'+data.savename+'" href="'+data.src+'" title="查看大图" target="_blank"><img style="width:64px;height:64px" src="/static/uploadfile/ext/'+data.ext+'.png" /></a></li>';

		//img = '<img width="80" height="130" class="myreturn" style="margin-right:10px;margin-top:10px" src="/static/uploadfile/ext/'+data.isimage+'.png"/>'+data.savename;
	}
	$("#fsUploadProgress > ul").append(img);
	$("#hid_savename").append(data.savename+'|');
	$("#hid_size").append(data.size+'|');
	$("#hid_src").append(data.src+'|');
	$("#hid_filename").append(data.filename+'|');
	$("#hid_isimage").append(data.isimage+'|');
	$("#hid_water_mark").append(data.water_mark+'|');
	html_element = '<div class="upload-data" savename="'+data.savename+'" size="'+data.size+'" src="'+data.src+'" filename="'+data.filename+'" isimage="'+data.isimage+'" water_mark="'+data.water_mark+'"></div>';
	$('body').append(html_element);
}

function mydel(obj,name)
{
	//alert(name);
}
function uploadError(file, errorCode, message) {
	var msg;
	switch (errorCode)
	{
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			msg = "上传错误: " + message;
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			msg = "上传错误";
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			msg = "服务器 I/O 错误";
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			msg = "服务器安全认证错误";
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			msg = "附件安全检测失败，上传终止";
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			msg = '上传取消';
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			msg = '上传终止';
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			msg = '单次上传文件数限制为 '+swfu.settings.file_upload_limit+' 个';
			break;
		default:
			msg = message;
			break;
		}
	var progress = new FileProgress(file,this.customSettings.progressTarget);
	progress.setError();
	progress.setStatus(msg);
}

function fileQueueError(file, errorCode, message)
{
	var errormsg;
	switch (errorCode) {
	case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
		errormsg = "请不要上传空文件";
		break;
	case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
		errormsg = "队列文件数量超过设定值";
		break;
	case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
		errormsg = "文件尺寸超过设定值";
		break;
	case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
		errormsg = "文件类型不合法";
	default:
		errormsg = '上传错误，请与管理员联系！';
		break;
	}

	var progress = new FileProgress('file',this.customSettings.progressTarget);
	progress.setError();
	progress.setStatus(errormsg);

}



function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
	var status = document.getElementById("divStatus");
	status.innerHTML = numFilesUploaded + " file" + (numFilesUploaded === 1 ? "" : "s") + " uploaded.";
}