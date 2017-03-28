<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 数据库操作 数据库备份
 *
 * 文件修改记录：
 * <br>雷少进  2012-12-24 14:23 创建此文件
 * <br>雷少进  2012-12-27 13:56 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   DbbackupController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class DbbackupController extends AdminController
{
	private $tableModel;
	public function init ()
	{
		$this -> tableModel = D('TableModel');
	}

	/*
	 * 数据表 列表
	 *
	 */
	public function indexAction ()
	{
		//所有列表
		$search['name'] = isset($_POST['name']) ? filterBadStr($_POST['name']) : (isset ( $_GET['name'] ) ? filterBadStr($_GET['name']) : '');
		$table_info = $this -> tableModel -> getTableInfo();//数据表状态信息

		//搜索过滤
		if(!empty($search['name']))
		{
			foreach ($table_info as $key => $val )
			{
				if(!preg_match('/'.$search['name'].'/i',$val['Name']) && !preg_match('/'.$search['name'].'/i',$val['Collation']) && !preg_match('/'.$search['name'].'/i',$val['Comment']))
					unset($table_info[$key]);
			}
		}
		$this -> assign('search',$search);
		$this -> assign('table_info',$table_info);
		$this -> display('webset/dbm/webset_dbbackup_index');
	}

	/*
	 * 备份单张表
	 * 500W数据备份217秒  100W备份36秒
	 */
	public function backupAction ()
	{
		set_time_limit(600);
		$table_name = isset ( $_GET['name'] ) ? filterBadStr($_GET['name']) : '' ;
		$this ->tableModel-> backupTable($table_name);
		admin_log('数据库备份', '备份'.$table_name.'表');
		$this -> dialog('/webset/dbbackup/index?name='.$_GET['searchname']);
	}

	/*
	 * 分表逐个备份
	 *
	 */
	public function splitbackupAction ()
	{
		$table_name = $this -> post('table_name');
		if(!$table_name)
		{
			$this -> dialog('','error','请选择表');
			exit();
		}
		foreach ($table_name as $key => $val )
		{
			set_time_limit(600);
			$this ->tableModel-> backupTable($val);
			admin_log('数据库备份', '备份'.$val.'表');
		}
		$this -> dialog('/webset/dbbackup/index?name='.$_GET['searchname']);
	}

	/*
	 * ajax整站备份
	 *
	 */
	function backupallAction ()
	{
		if('N' != $this -> siteState())
		{
			echo 'fail';//备份失败
			exit();
		}
		$table_info = $this -> tableModel -> getTables();//数据表状态信息
		$file_name = TableModel::ONLY_BACKUP_FILE ? 'database' : $this -> tableModel -> getRandFileName('database');//保存的文件名
		foreach ($table_info as $key => $val )
		{
			set_time_limit(600);
			$this ->tableModel-> backupDataBase(current($val),$key,$file_name);
		}
		admin_log('数据库备份', '整站备份');
		//$this -> dialog('/webset/dbbackup/index?name='.$_GET['searchname']);
	}

	/*
	 * 修复表
	 *
	 */
	function repairAction ()
	{
		//得到要修复的表名
		$table_info = $this -> tableModel -> getTables();//数据表状态信息
		$table = array();
		foreach ($table_info as $key => $val )
		{
			$table[] = current($val);
		}
		if(!empty($table))
		{
			admin_log('SQL语句', '修复表');
			if($this -> tableModel -> repairTables(implode(',',$table)))
				$this -> dialog('/webset/dbbackup/index');
			else
				$this -> dialog('/webset/dbbackup/index','error','操作失败');
		}
	}

	/*
	 * 优化表
	 *
	 */
	function optimizeAction ()
	{
		//得到要优化的表
		$table_info = $this -> tableModel -> getTables();//数据表状态信息
		$table = array();
		foreach ($table_info as $key => $val )
		{
			$table[] = current($val);
		}
		if(!empty($table))
		{
			admin_log('SQL语句', '优化表');
			if($this -> tableModel -> optimizeTables(implode(',',$table)))
				$this -> dialog('/webset/dbbackup/index');
			else
				$this -> dialog('/webset/dbbackup/index','error','优化失败');
		}
	}

	/**
	 * 前台ajax判断网站是否关闭
	 * @return
	 */
	function iscloseAction ()
	{
		echo $this -> siteState();
	}

	/**
	 * 取当前网站前台的状态
	 * @return N(网站开放)  Y(网站关闭状态)
	 */
	private function siteState ()
	{
		$close = $this -> getSystemModel() -> getConfigByKey(array('mo_shut_down'));
		return current($close);
	}

	/**
	 * 获取系统设置model
	 * @return SystemModel object
	 */
	public function getSystemModel ()
	{
		return D('SystemModel','webset','admin');
	}
}
?>
