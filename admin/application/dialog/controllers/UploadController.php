<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * UploadController.php
 *
 * 统一上传入口
 *
 * @author     lei shaojin<leishaojin2009@163.com>   2013-04-22
 * @filename   UploadController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class UploadController extends AdminController
{
	public $arraySetting = array();
	//初始化配置
	function __construct ()
	{
		//初始配置
		$this -> arraySetting = array
		(
			'limit'   => 10,              //上传个数限制
			'type'    => array('*'),      //上传类型限制
			'local'   => false,			  //是否显示本地图库
			'folder'  => false,           //是否显示目录浏览
			'size'    => intval(ini_get('upload_max_filesize'))*1024,//上传大小限制 单位MB
			'iswatermark' => false        //是否显示打水印按钮
		);
		parent::__construct();
	}

	/**
	 * flash上传界面
	 */
	public function indexAction()
	{
		//解码配置
		$setting =array();
		isset($_GET['setting']) && ($setting = $this -> decodeSetting($_GET['setting']));
		if(!$setting)
		{
			echo '地址数据被非法串改';
			exit();
		}

		//还能上传的个数
		$au = isset ( $_GET['au'] ) ? intval($_GET['au']) : 0 ;//已上传个数
		//上传的种类
		$flag = isset ($_GET['flag']) ?$_GET['flag']:'';
		$this->assign('flag' , $flag);//上传种类加载
		
		$setting['limit'] = $setting['limit']-$au;//还能上传的个数
		($setting['limit'] < 0) ? ($setting['limit']=0) : 0;

		//合并默认配置
		$setting = $this -> mergeSetting($setting);
		isset($setting['type']) && is_array($setting['type']) && ($setting['str_type'] = '*.'.implode(';*.',$setting['type']));
		$setting['setting'] = $this -> encodeSetting($setting);

		//上传页面
		$this -> assign('setting',$setting);
		$this -> display('public/public_upload');
	}

	/**
	 *
	 * @param string $type
	 * @param array $options
	 * @return object
	 */
	function uploadAction ()
	{
		//解码配置
		isset($_POST['setting']) && ($setting = $this -> decodeSetting($_POST['setting']));//$this->arraySetting = #1#

		//上传配置
		$option = array(
			'uploadPath'   => DIR_UPLOAD_TEMP,
			'allowTypes'   => $setting['type'],
			'maxSize'      => intval($setting['size'])*1024*1024
		);
		//开始上传
		$upload_obj = new Upload($option);
		$flag = $upload_obj->fileupload($_FILES['uploadFile']);
		//上传成功
		if($flag)
		{
			$info = pathinfo($flag);
			//获取文件类型
			$filetype = $upload_obj->getFileType($flag);
			if($filetype)
				$filetype = substr($filetype,0,strpos($filetype,'/'));//文件类型

			//设置上传文件的缩略图
			$file_info = array('isimage'=>0,'iswatermark'=>0);
			switch ($filetype)
			{
				case 'application':
				case 'javascript':
					$file_info['thumb'] = HOST_NAME . 'admin/template/images/default/application.png';
					break;
				case 'image':
					$file_info['thumb'] = HOST_NAME . 'static/uploadfile/temp/'.$info['basename'];
					$file_info['isimage'] = 1;
					isset($_POST['iswatermark']) && ($file_info['iswatermark'] = 1 );
					break;
				case 'text':
					$file_info['thumb'] = HOST_NAME . 'admin/template/images/default/text.png';
					break;
				case 'video':
					$file_info['thumb'] = HOST_NAME . 'admin/template/images/default/video.png';
					break;
				case 'audio':
					$file_info['thumb'] = HOST_NAME . 'admin/template/images/default/audio.png';
					break;
				default:
					$file_info['thumb'] = HOST_NAME . 'admin/template/images/default/unknow.png';
			}

			//设置其他文件信息
			$file_info['selfname'] = $_FILES['uploadFile']['name'];
			$file_info['path'] = '/static/uploadfile/temp/'.$info['basename'];
			$file_info['size'] = $_FILES['uploadFile']['size'];
			$file_info['filename'] = $info['basename'];
			echo json_encode($file_info);
		}
		//上传失败
		else
		{
			echo 'fail';
			exit();
		}
	}

	//合并配置
	function mergeSetting ($setting)
	{
		foreach ($setting as $key => $val ) $this -> arraySetting[$key] = $val;
		return $this -> arraySetting;
	}

	/**
	 * 上传配置项解码
	 * @param string encodeSetting ()加密串
	 * @return null
	 */
	function decodeSetting ($setting)
	{
		($set = base64_decode($setting)) && ($set = unserialize($set));
		return $set;
	}

	/**
	 * 上传配置项编码
	 * @param array 配置项
	 * @return null
	 */
	function encodeSetting ($setting)
	{
		return base64_encode(serialize($setting));
	}
}