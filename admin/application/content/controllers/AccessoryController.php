<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 内容管理 附件管理
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-17 11:09 创建此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   AccessoryController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class AccessoryController extends AdminController
{
	/**
	 * 附件管理首页
	 * @return null
	 */
	public function indexAction ()
	{
		//搜索条件
		$search['name']  = isset($_POST['name'])  ? trim($_POST['name'])  : (isset($_GET['name'])  ? trim($_GET['name'])  : '' );
		$search['type']  = isset($_POST['type'])  ? $_POST['type']  : (isset($_GET['type'])  ? $_GET['type']  : 0  );
		$search['start'] = isset($_POST['start']) ? $_POST['start'] : (isset($_GET['start']) ? $_GET['start'] : '' );
		$search['end']   = isset($_POST['end'])   ? $_POST['end']   : (isset($_GET['end'])   ? $_GET['end']   : '' );

		$plist = $this -> getAccessoryModel() -> getAccessoryList(array('search'=>$search));
		$this -> assign('plist',$plist);
		$this -> assign('search',$search);
		$this -> display('content/accessory/content_accessory_index.html');
	}

	/**
	 * 上传新附件
	 * @return null
	 */
	public function addAction ()
	{
		if(!empty($_POST))
		{
			$res = $this -> getAccessoryModel() -> saveAccessory();//保存附件
			if($res)
				$this -> dialog('/content/accessory/index');
			else
				$this -> dialog('/content/accessory/index','info','上传失败');
		}

		$allow_type = $this -> getAllowType(1);
		$setting = array
		(
			'limit'       =>  20,
			'type'        =>  $allow_type,
			'iswatermark' =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		$this -> display('content/accessory/content_accessory_add');
	}

	function getTypeAction ()
	{
		$setting = unserialize(base64_decode($_POST['setting']));
		$setting['type'] = $this -> getAllowType($_POST['type']);
		echo base64_encode(serialize($setting));
	}

	/**
	 * 修改附件
	 * @return null
	 */
	public function editAction ()
	{
		if(!empty($_POST))
		{
			//基本信息
			$info['name'] = $_POST['name'];
			$info['mediatype'] = $_POST['mediatype'];

			$path = getFileSavePath('accessory');
			//附件修改过
			$file = '';
			if(isset($_POST['accessory']) && !empty($_POST['accessory']))
			{
				$file = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'accessory','time_name'=>true));
				if($file)
				{
					$file = current($file);
					$info['selfname'] = $file['selfname'];
					$info['trends_path'] = $file['trends_path'];

					$info['path'] = $file['path'];
					$info['width'] = $file['width'];
					$info['height'] = $file['height'];
					$info['size'] = $file['size'];
					$info['extension'] = $file['extension'];
					$info['size'] = $file['size'];
				}
			}
			$res = $this -> getAccessoryModel() -> update(array('id'=>$_POST['id']),$info);
			if($res)
			{
				admin_log('附件管理', '修改了附件：'.$_POST['selfname']);
				if($file) @unlink($path['full'].$_POST['old_file']);
				$this -> dialog('/content/accessory/index');
			}
			else
				$this -> dialog('/content/accessory/index','info','修改失败');
		}

		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : 0 ;
		if(!$id) $this -> dialog('/content/accessory/index','error','参数有误');
		$info = $this -> getAccessoryModel() -> find(array('id'=>$id));

		$allow_type = $allow_type = $this -> getAllowType($info['mediatype']);
		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  $allow_type,
			'iswatermark' =>  true,
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		$this -> assign('info',$info);
		$this -> display('content/accessory/content_accessory_edit.html');
	}

	/**
	 * 删除附件
	 * @return null
	 */
	public function delAction ()
	{
		$ids = isset ( $_GET['id'] ) ? $_GET['id'] : (isset($_POST['id']) ? implode(',',$_POST['id']) : '') ;
		if(!$ids) $this -> dialog('','error','参数有误');
		$res = $this -> getAccessoryModel() -> deleteAccessory($ids);
		$this -> dialog('/content/accessory/index');
	}

	/**
	 * 本地浏览图库
	 * @return null
	 */
	public function localAction()
	{
		//动态搜索条件
		$selfname = $this -> getParams('selfname','');
		$start	  = $this -> getParams('start','');
		$end      = $this -> getParams('end','');

		//静态搜索条件
		$allow_image_type = "'jpg','jpeg','gif','png','bmp'";

		//组合各个条件
		$where = ' extension IN ('.$allow_image_type.') ';
		$search = array();
		if($selfname)
		{
			$where .= ' AND ((selfname LIKE \'%'.$selfname.'%\') OR (name LIKE \'%'.$selfname.'%\'))';
			$search['selfname'] = $selfname;
		}
		if($start)
		{
			$where .= ' AND created >= '.strtotime($start.' 00:00:00');
			$search['start'] = $start;
		}
		if($end)
		{
			$where .= ' AND created <= '.strtotime($end.' 23:59:59');
			$search['end'] = $end;
		}

		//开始查询
		$plist = $this -> getAccessoryModel() -> getPageList(array('pagesize'=>15,'where'=>$where,'search'=>$search));
		//过滤处理，超链处理
		$folder = getFileSavePath('accessory','Y_m');//保存附件的目录信息

		foreach ($plist['list'] as $key => $val )
			$plist['list'][$key]['http_url'] = $this -> getUploadHttpUrl().'/accessory/'.$val['path'];//替换超链url

		foreach ($plist['list'] as $key => $val )
		{
			$tmp = explode('/',$val['path']);
			$plist['list'][$key]['file_name'] = $tmp[1];
			$plist['list'][$key]['file_path'] = '/static/uploadfile/accessory/'.$val['path'];
 		}

		$setting = @unserialize(base64_decode($_GET['setting']));
		$flag = isset($_GET['flag'])?$_GET['flag']:'';//获取图片上传类型
		$setting['setting'] = $_GET['setting'];
		//渲染页面
		$this -> assign('setting',$setting);
		//加载图片上传类型
		$this->assign('flag' , $flag);

		$plist['_list'] = array();
		if(isset($plist['list']) && !empty($plist['list']))
		{
			$plist['_list'] = array_chunk($plist['list'],5,true);
			$last = array_pop($plist['_list']);
			$count = count($last);
			if($count < 5)
			{
				for ($i=0;$i<(5-$count);$i++)
				{
					$last[] = array('id'=>0);
				}
			}
			$plist['_list'][] = $last;
		}

		$this -> assign('plist',$plist);
		$this -> assign('search',array('selfname'=>$selfname,'start'=>$start,'end'=>$end));
		$this -> display('content/accessory/content_accessory_local.html');
	}

	/**
	 * 目录浏览
	 * @return null
	 */
	public function folderAction()
	{
		$cur_folder = $this -> getParams('folder','');//当前目录
		$folder_list = $this -> getAccessoryModel() -> field('trends_path') -> group('trends_path') -> select();//目录列表
		$file_list = $this -> getAccessoryModel() -> findAll(array('trends_path'=>$cur_folder));//当前目录下的文件列表
		$folder = getFileSavePath('accessory','Y_m');//保存附件的目录信息

		foreach ($file_list as $key => $val )
		{
			if(!file_exists($folder['base'].'/'.$val['path']))
				unset($file_list[$key]);
			else
				$file_list[$key]['file_path'] = '/static/uploadfile/accessory/'.$val['path'];
		}

		$setting = @unserialize(base64_decode($_GET['setting']));
		$flag = isset($_GET['flag'])?$_GET['flag']:'';//获取图片上传类型
		$setting['setting'] = $_GET['setting'];
		$this -> assign('setting',$setting);
		//加载图片上传类型
		$this->assign('flag' , $flag);

		$this -> assign('cur_folder',$cur_folder);
		$this -> assign('folder_list',$folder_list);
		$this -> assign('file_list',$file_list);
		$this -> display('content/accessory/content_accessory_folder.html');
	}

	public function getAccessoryModel ()
	{
		return D('AccessoryModel');
	}

	/**
	 * 获取系统设置model
	 * @return SystemModel object
	 */
	public function getSystemModel ()
	{
		return D('SystemModel','webset','admin');
	}

	/**
	 * 已30%的概率清理临时文件
	 * @return null
	 */
	function clearfileAction ()
	{
		$this -> getAccessoryModel() -> autoClearTempFile(40);
	}

	protected function getAllowType ($type=1)
	{
		$allow_type = $this -> getSystemModel() -> getConfigByKey(array('mo_picturetype','mo_filetype','mo_mediatype'));
		switch ($type)
		{
			case '2'://flash
				$allow_type = array('swf');
				break;
			case '3'://音频视屏
				$allow_type = explode('|',$allow_type['mo_mediatype']);
				break;
			case '4'://其他
				$allow_type = explode('|',$allow_type['mo_filetype']);
				break;
			default://图片
				$allow_type = explode('|',$allow_type['mo_picturetype']);
		}
		return $allow_type;
	}
}