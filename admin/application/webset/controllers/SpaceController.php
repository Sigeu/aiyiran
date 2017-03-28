<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 其他设置 空间详情
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-4 16:34 创建此文件
 * <br>雷少进  2013-01-4 16:34 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   SpaceController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class SpaceController extends AdminController
{
	/*
	 * 空间详情
	 */
	public function indexAction ()
	{
		$total_space = round(@disk_total_space(dirname(DIR_ROOT))/(1024*1024*1024),3);//磁盘总大小
		$space_free = round(@disk_free_space(".")/(1024*1024*1024),3);//剩余大小


		$this -> assign('web',array(
			'ts'=>$total_space,
			'sf'=>$space_free,
			'image_size'=>round(($this -> getAllUploadFileSize())/(1024*1024),3),

		));
		$this -> display('webset/others/webset_space_index');
	}

	/**
	 * 获取所有上传文件大小
	 */
	function getAllUploadFileSize ()
	{
		$size = array();
		$file = MoFolder::recurFolder(realpath(DIR_UPLOADFILE));
		$file = MoFolder::mergeFileList($file,1);
		foreach ($file as $val )
			array_push($size,@filesize($val));
		return array_sum($size);
	}
}