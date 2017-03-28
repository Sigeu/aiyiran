var cur_count = 0;
function fileQueued(file) 
{
	try 
	{
		if ( $('.Lpic li').length) {
			var count = $('.Lpic li').length;
		} else {
			var count = $('.progressWrapper:visible').length;
		}
		var flag = document.getElementById('flag').value;
		if ((flag == 'goodsedit' || flag == 'editImages')&& count > 0) {
			art.dialog.tips('可上传个数已达上限');
		   /** this.message = document.createElement("div");
			this.message.className = "message red";
			var tip = document.createElement("div")
			tip.className = "";
			tip.style.width = "";
			tip.innerHTML = "<div>图片上传修改只允许上传一个图片</div>";
			this.message.appendChild(tip);

			document.getElementById(this.customSettings.progressTarget).appendChild(this.message);
			
			this.setTimer(setTimeout(function () {
				$('.message').hide();
			}, 1000));*/
			return;
			
		}
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.toggleCancel(true, this);

	}
	catch (ex) 
	{
		this.debug(ex);
	}
}

function uploadStart(file) 
{
	try 
	{
		if ( $('.Lpic li').length) {
			var count = $('.Lpic li').length;
		} else {
			var count = 0;
		}
		
		var flag = document.getElementById('flag').value;
		
		if ((flag == 'goodsedit' || flag == 'editImages')&& count > 0) {
			return;			
		}
		
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("正在上传请稍后...");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) 
{
	try 
	{
		if ( $('.Lpic li').length) {
			var count = $('.Lpic li').length;
		} else {
			var count = 0;
		}
		
		var flag = document.getElementById('flag').value;
		
		if ((flag == 'goodsedit' || flag == 'editImages')&& count > 0) {
			return;			
		}
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("正在上传("+percent+" %)请稍后...");
	}
	catch (ex) 
	{
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) 
{
	try 
	{	
		if ( $('.Lpic li').length) {
			var count = $('.Lpic li').length;
		} else {
			var count = 0;
		}
		
		var flag = document.getElementById('flag').value;
		
		if ((flag == 'goodsedit' || flag == 'editImages')&& count > 0) {
			return;			
		}
		if(serverData == 'fail') return;
		mylist(file, serverData);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("文件上传成功.");
	}
	catch (ex) 
	{
		this.debug(ex);
	}
}


function mylist(file, serverData)
{
	cur_count++;
	if ((cur_count > 1) && ($('#flag').val() == 'editImages' || $('#flag').val() == 'goodsedit')) {
		return;
	}
	var data = eval('(' + serverData+ ')');
	if(data.isimage == 1)
		img = '<li style="margin-right:5px" title="'+data.selfname+'"><a href="'+data.path+'" title="'+data.selfname+'" target="_blank"><img src="'+data.thumb+'"/></a></li>';
	else
		img = '<li style="margin-right:5px" title="'+data.selfname+'"><a href="javascript:;"><img src="'+data.thumb+'"/></a></li>';
   
	$("#fsUploadProgress > ul").append(img);//向页面添加缩略图
	var html_element = '<div class="mo-upload-data" path="'+data.path+'" isimage="'+data.isimage+'" iswatermark="'+data.iswatermark+'" size="'+data.size+'" selfname="'+data.selfname+'" filename="'+data.filename+'"></div>';
	$('body').append(html_element);
}

function mydel(obj,name)
{
	//alert(name);
}

function uploadError(file, errorCode, message) 
{
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

function uploadComplete(file) 
{
	if (this.getStats().files_queued === 0) 
	{
		//document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) 
{
	//var status = document.getElementById("divStatus");
	//status.innerHTML = numFilesUploaded + " file" + (numFilesUploaded === 1 ? "" : "s") + " uploaded.";
}