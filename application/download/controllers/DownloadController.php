<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * DawnloadController.php
 * 
 *  下载类————前台
 * 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-4 下午3:38:31
 * @filename   ContentController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class DownloadController extends HomeController {

	public  $model;
	public function init()
	{
		$this->model = M('download');
		parent::init();
	}
	/**
	 * 下载首页
	 */
	public function indexAction() 
	{
		$id = Controller::get('id');
		$info = $this->model->where(array('id'=>$id))->getOne();
		$arr = object_to_array(json_decode($info['mocms']));
		$file = UPLOAD_PATH.'/'.$arr['src'];
		if (!isset($arr['src'])||!$arr['src']||!file_exists(str_replace('\\','/',DIR_ROOT.'static/uploadfile/'.$arr['src']))) 
		{ 
			$this->mydialog($_SERVER['HTTP_REFERER'],'error','你下载的模板文件不存在');
		} 
		else
		{
			//header("Content-type: application/octet-stream");       
			//header("Content-Disposition: attachment; filename=".$fileName);       
			//readfile($fileDir.$fileName);
			Header("HTTP/1.1 303 See Other"); 
			Header("Location: $file"); 
			$this->model->update(array('id'=>$id),array('addition'=>'down_num=down_num+1')); //增加下载次数
			goback();
		}
	}
}
