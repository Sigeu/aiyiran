<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * DialogController.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-9 下午2:08:13
 * @filename   DialogController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class DialogController extends AdminController
{
	/**
	 * flash上传界面
	 */
	public function flashUploadAction()
	{
		$original = true;
		if(isset($_GET['param']) && !empty($_GET['param'])) //从本地图库或者目录浏览页面点进来
		{
			$original = false;
			$query_string = $_GET['param'];
			$param = base64_decode($query_string);//解码
			parse_str($param,$_param);
			$setting = $_param['setting'];
			$authkey = $_param['authkey'];
		}
		else
		{
			$setting = $_GET['setting'];
			$authkey = $_GET['authkey'];
		}

		if(!checkUpload($authkey, $setting))
		{
			exit("非法上传操作");
		}
		else
		{
			$settings= getUploadSetting($setting);
			if($original)//从上传按钮点进来
			{
				if(isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
					$query_string = $_SERVER['QUERY_STRING'];
				else if (isset($_SERVER['REDIRECT_QUERY_STRING']) && !empty($_SERVER['REDIRECT_QUERY_STRING']))
					$query_string = $_SERVER['REDIRECT_QUERY_STRING'];
				else
					$query_string = '';
				$query_string = base64_encode($query_string.'&limit='.$settings['file_upload_limit']);//编码
			}
			$this->assign('query_string',$query_string);
			$this->assign('initUpload',initupload($settings));
			$this->assign('settings',$settings);
			$this->display('public/dialog');
		}
	}

	public function saveAction()
	{
		$allowtype = $_POST['allowtype'] == '' || $_POST['allowtype'] == '*' || $_POST['allowtype'] == '*.*' ? $_POST['allowtype'] : explode('|',$_POST['allowtype']);
		$allowsize = $_POST['allowsize'];
		$haswater = Controller::post('haswater',0);
		$obj = new Upload(array('uploadPath'=>DIR_UPLOAD_TEMP,'allowTypes'=>$allowtype,'maxSize'=>$allowsize*1024));
		$flag = $obj->fileupload($_FILES['uploadFile']);
		if(!$flag)
		{
			$message = $obj->getStatus();
			exit($message['message']);
		}
		else
		{	
			$arr['savename'] = $_FILES['uploadFile']['name'];
			$arr['size'] = $_FILES['uploadFile']['size'];
			$arr['src'] = "/static/uploadfile/temp/".basename($flag);
			$arr['filename'] = basename($flag);
		    $fileext = strtolower(pathinfo($arr['filename'],PATHINFO_EXTENSION));
			if (in_array($fileext, array('jpg', 'gif', 'jpeg', 'png', 'bmp'))) {
				$arr['isimage'] = 1;
			}else{
				if($fileext == 'zip' || $fileext == 'rar') $fileext = 'rar';
				elseif($fileext == 'doc' || $fileext == 'docx') $fileext = 'doc';
				elseif($fileext == 'xls' || $fileext == 'xlsx') $fileext = 'xls';
				elseif($fileext == 'ppt' || $fileext == 'pptx') $fileext = 'ppt';
				elseif($fileext == 'mp3') $fileext = 'mp3';
				elseif($fileext == 'css') $fileext = 'css';
				elseif($fileext == 'wav') $fileext = 'wav';
				elseif($fileext == 'wam') $fileext = 'wam';
				elseif($fileext == 'html' || $fileext == 'htm') $fileext = 'html';
				elseif ($fileext == 'mp4' || $fileext == 'swf' || $fileext == 'rm' || $fileext == 'rmvb') $fileext = 'flv';
				else $fileext = 'do';
				$arr['ext'] = $fileext;
 			}
 			$arr['water_mark'] = $haswater;
				

			exit(json_encode($arr));
		}
	}
}