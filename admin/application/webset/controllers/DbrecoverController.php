<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 数据库操作 数据库还原
 *
 * 文件修改记录：
 * <br>雷少进  2012-12-27 13:56 创建此文件
 * <br>雷少进  2012-12-27 13:56 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   DbrecoverController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class DbrecoverController extends AdminController
{
	private $tableModel;
	public function init ()
	{
		$this -> tableModel = D('TableModel');
	}

	/*
	 * 备份文件列表
	 *
	 */
	public function indexAction ()
	{
		//所有列表
		$param = $this -> getSearchParam();
		$search = $param['search'];

		$file_list = $this -> tableModel -> getBackupFileList();
		foreach ($file_list as $key => $val )
			if(preg_match('/^database(.*)/i',$val['file_name'])) unset($file_list[$key]);

		//搜索过滤
		if(!empty($search))
		{
			foreach ($file_list as $key => $val )
			{
				if(!empty($search['name']) && !preg_match('/'.$search['name'].'/i',$val['file_name']))
					unset($file_list[$key]);
				elseif(!empty($search['start']) && $val['filec_time'] < $search['start'])
					unset($file_list[$key]);
				elseif(!empty($search['end']) && $val['filec_time'] > $search['end'].' 23:59:59')
					unset($file_list[$key]);
			}
		}
		$this -> assign('file_list',$file_list);
		$this -> assign('search',$search);

		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  array('sql','txt')
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		$this -> assign('search_str', $param['search_str']);
		$this -> display('webset/dbm/webset_dbrecover_index');
	}

	/*
	 * 整站备份文件列表
	 *
	 */
	public function dblistAction ()
	{
		$file_list = $this -> tableModel -> getBackupFileList();
		foreach ($file_list as $key => $val )
			if(!preg_match('/^database(.*)/i',$val['file_name'])) unset($file_list[$key]);

		$this -> assign('file_list',$file_list);
		$this -> display('webset/dbm/webset_dbrecover_dblist');
	}

	/*
	 * 恢复表
	 *
	 */
	public function recoverAction ()
	{
		$param = $this -> getSearchParam();
		set_time_limit(600);
		//循环恢复
		$files = $this -> getOperateParam();
		if($files)
		{
			foreach ($files as $key => $val )
			{
				$this -> tableModel -> recoverData($val);
			}
			admin_log('还原数据表', '还原了'.implode(',',$files).'数据文件');  //添加日志
			$this -> dialog('/webset/dbrecover/index/'.$param['search_str']);
		}
	}

	/*
	 * 恢复整站数据库
	 *
	 */
	public function recoverdbAction ()
	{
		$file_name = isset ( $_POST['file_name'] ) ? $_POST['file_name'] : '';
		set_time_limit(1800);
		if($file_name)
		{
			$res = $this -> tableModel -> recoverData($file_name);
			admin_log('数据库还原', '还原数据库');
			echo $res ? 'success' : 'fail';
			exit();
		}
		echo 'fail';
	}

	/**
	 * 本地导入
	 */
	public function localImportAction ()
	{
		$filename = isset($_POST['filename']) ? $_POST['filename'] : '' ;
		if(!$filename)
		{
			echo '参数错误';
		}
		else
		{
			$temp_path = getTempPath();
			$file_path = $temp_path.DIRECTORY_SEPARATOR.$filename;
			if(!file_exists($file_path))
			{
				echo '文件不存在';
			}
			else
			{
				$content = file_get_contents($file_path);
				@unlink($file_path);
				$separator = md5('_T_M_D_');                                 //分隔符
				$content = preg_replace('/\/\*(.*)\*\/[;]?/U','',$content);  //去除快注释/**/
				$content = preg_replace("/--(.*)/",'',$content);             //去除双中横线注释
				$content = preg_replace("/(;\n){1,1}/",$separator,$content); //创建唯一分隔符
				$con_arr = explode($separator,$content);                     //分隔数组
				$success = 0;
				$fail = 0;
				foreach ($con_arr as $key => $val )
				{
					$tmp = trim($val);
					if(!empty($tmp))
					{
						@$this -> tableModel -> query($tmp) ? ($success += 1) : ($fail += 1);
					}
				}
				admin_log('本地导入数据库', '本地导入数据库'.$success.'个执行成功，'.$fail.'个执行失败');
				echo $success.'个执行成功，'.$fail.'个执行失败';
			}
		}
	}

	/*
	 * 下载表
	 *
	 */
	public function downloadAction ()
	{
		$param = $this -> getSearchParam();

		$files = $this -> getOperateParam();
		$file_path = $this ->tableModel -> getSavePath();
		load::load_class('MoDownload',DIR_BF_ROOT.'classes',0);
		$download =new MoDownload('sql',false);
		foreach ($files as $key => $val )
		{
			$_path = $file_path.DIRECTORY_SEPARATOR.str_replace('@',DIRECTORY_SEPARATOR,$val);
			if(!$download->downloadfile($_path))
			{
				$this -> dialog('/webset/dbrecover/index/'.$param['search_str'],'error',$download->geterrormsg());
			}
		}
	}

	/*
	 * 删除表
	 *
	 */
	public function deleteAction ()
	{
		$param = $this -> getSearchParam();
		$files = $this -> getOperateParam();
		if($files)
		{
			foreach ($files as $key => $val )
			{
				$this -> tableModel -> deleteTable($val);
			}
			admin_log('删除数据表备份文件', '删除了'.implode(',',$files).'数据文件');
			$this -> dialog('/webset/dbrecover/index/'.$param['search_str']);
		}
	}

	/*
	 * 接收需要操作的表
	 *
	 */
	public function getOperateParam ()
	{
		$files = $this -> post('file_name');
		if(!$files)
		{
			$files[] = $this -> get('tbname');
		}
		return $files;
	}

	/**
	 * 获取搜索条件
	 */
	public function getSearchParam ()
	{
		$search = array('name'=>'','start'=>'','end'=>'');
		$search_str = array();
		foreach ($search as $key => $val )
		{
			$search[$key] = isset($_POST[$key]) ? filterBadStr($_POST[$key]) : (isset ($_GET[$key]) ? filterBadStr($_GET[$key]) : '');
			if(!empty($search[$key]))
			{
				$search_str[] = $key;
				$search_str[] = $search[$key];
			}
		}
		$tmp['search'] = $search;
		$tmp['search_arr'] = $search_str;
		$tmp['search_str'] = implode('/',$search_str);
		return $tmp;
		/*
		Array => $tmp
		(
			[search] => Array
				(
					[name] => admin
					[start] => 2013-02-20
					[end] => 2013-02-21
				)

			[search_arr] => Array
				(
					[0] => name
					[1] => admin
					[2] => start
					[3] => 2013-02-20
					[4] => end
					[5] => 2013-02-21
				)

			[search_str] => name/admin/start/2013-02-20/end/2013-02-21
		)
		*/
	}
}
?>
