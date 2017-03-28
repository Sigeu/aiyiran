<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 数据库操作 命令行工具
 *
 * 文件修改记录：
 * <br>雷少进  2012-12-28 14:35 创建此文件
 * <br>雷少进  2012-12-28 14:35 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   DbcommandController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class DbcommandController extends AdminController
{
	private $tableModel;
	public function init ()
	{
		$this -> tableModel = D('TableModel');
	}

	/*
	 * 命令行主页
	 *
	 */
	public function indexAction ()
	{
		$info = $this -> getFilterAllTable();
		$this -> assign('table',array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		$this -> display('webset/dbm/webset_dbcommand_index');
	}

	/*
	 * 修复表
	 *
	 */
	function repairAction ()
	{
		$table = $this -> post('name');
		//得到要修复的表名
		$tmp = array();
		if(!empty($table))
		{
			foreach ($table as $val )
			{
				$tmp[] = $this -> tableModel -> repairTables($val) ? $val.'表修复成功' : $val.'表修复失败';
			}
		}

		$info = $this -> getFilterAllTable();
		$this -> assign('table',$table ? $table : array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		//$this -> assign('result',implode("\n",$tmp));
		$this -> assign('result','修复成功');
		$this -> display('webset/dbm/webset_dbcommand_index');
	}

	/*
	 * 修复全部表
	 *
	 */
	function repairallAction ()
	{
		//得到要修复的表名
		$table_info = $this -> tableModel -> getTables();//数据表状态信息
		$table = array();
		foreach ($table_info as $key => $val )
		{
			$table[] = current($val);
		}
		$tmp = array();
		if(!empty($table))
		{
			foreach ($table as $val )
			{
				$tmp[] = $this -> tableModel -> repairTables($val) ? $val.'表修复成功' : $val.'表修复失败';
			}
		}

		$info = $this -> getFilterAllTable();
		$this -> assign('table',array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		//$this -> assign('result',implode("\n",$tmp));
		$this -> assign('result','修复成功');
		$this -> display('webset/dbm/webset_dbcommand_index');
	}

	/*
	 * 优化表
	 *
	 */
	function optimizeAction ()
	{
		//得到要优化的表
		$table = $this -> post('name');
		$tmp = array();
		if(!empty($table))
		{
			foreach ($table as $val )
			{
				$tmp[] = $this -> tableModel -> optimizeTables($val) ? $val.'表优化成功' : $val.'表优化失败';
			}
		}

		$info = $this -> getFilterAllTable();
		$this -> assign('table',$table ? $table : array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		//$this -> assign('result',implode("\n",$tmp));
		$this -> assign('result','优化成功');
		$this -> display('webset/dbm/webset_dbcommand_index');
	}

	/*
	 * 优化全部表
	 *
	 */
	function optimizeallAction ()
	{
		//得到要优化的表
		$table_info = $this -> tableModel -> getTables();//数据表状态信息
		$table = array();
		foreach ($table_info as $key => $val )
		{
			$table[] = current($val);
		}
		$tmp = array();
		if(!empty($table))
		{
			foreach ($table as $val )
			{
				$tmp[] = $this -> tableModel -> optimizeTables($val) ? $val.'表优化成功' : $val.'表优化失败';
			}
		}

		$info = $this -> getFilterAllTable();
		$this -> assign('table',array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		//$this -> assign('result',implode("\n",$tmp));
		$this -> assign('result','优化成功');
		$this -> display('webset/dbm/webset_dbcommand_index');
	}

	/*
	 * 查看表结构
	 *
	 */
	function structureAction ()
	{
		$table = $this -> post('name');
		$tmp = array();
		if(!empty($table))
		{
			foreach ($table as $val)
			{
				$tmp[] = $this -> tableModel -> getCreateTableStr($val);
			}
		}

		$info = $this -> getFilterAllTable();
		$this -> assign('table',$table ? $table : array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		$this -> assign('result',implode("\n",$tmp));
		$this -> display('webset/dbm/webset_dbcommand_index');
	}

	/*
	 * 单行命令
	 *
	 */
	public function singleAction ()
	{
		$sqlquery = $this -> post('sql');
		$sqlquery = trim(stripslashes($sqlquery));
		$tmp = array();
		$res = array();

		if(preg_match("/drop(.*)table/i", $sqlquery) || preg_match("/drop(.*)database/", $sqlquery))
		{
			$tmp[] = '删除 数据表 或 数据库 的语句不允许在这里执行。';
		}
		else if($sqlquery != '')
		{
			$_tmp = $sqlquery.';';
			preg_match_all('/select(.*);+/iU',$_tmp,$sql_array);//只进行简单的查询命令
			if(isset($sql_array[0][0]) && !empty($sql_array[0][0]))
			{
				$sql = rtrim($sql_array[0][0],';');
				if(false == strpos(strtolower($sql),'limit'))
				{
					$sql .= ' limit 100';
				}
				else
				{
					$sql = preg_replace('/limit\s+([0-9]+)\s*,\s*([0-9]+)$/i','limit \\1 , 100',$sql);
					$sql = preg_replace('/limit\s+([0-9]+)$/i','limit 100',$sql);

				}
				admin_log('执行sql语句', '执行了sql语句'.$sql);
				$res = $this -> tableModel -> query($sql);
			}
		}
		$info = $this -> getFilterAllTable();
		$this -> assign('sql',$sqlquery);
		$this -> assign('table',array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		$this -> assign('result',implode("\n",$tmp));
		$this -> assign('res',$res);
		$this -> assign('br',"\n");
		$this -> display('webset/dbm/webset_dbcommand_index');
	}

	/*
	 * 多行命令
	 *
	 */
	public function manyAction ()
	{
		$sqlquery = $this -> post('sql');
		$sqlquery = trim(stripslashes($sqlquery));
		$tmp = array();
		$res = array();

		if(preg_match("/drop(.*)table/i", $sqlquery) || preg_match("/drop(.*)database/", $sqlquery))
		{
			$tmp[] = '删除 数据表 或 数据库 的语句不允许在这里执行。';
		}
		else if($sqlquery != '')
		{
			$_tmp = $sqlquery.';';
			preg_match_all('/select(.*);+/iU',$_tmp,$sql_array);//只进行简单的查询命令
			if(isset($sql_array[0]) && !empty($sql_array[0]))
			{
				foreach ($sql_array[0] as $key => $val )
				{
					$sql = rtrim($val,';');
					if(false == strpos(strtolower($sql),'limit'))
					{
						$sql .= ' limit 100';
					}
					else
					{
						$sql = preg_replace('/limit\s+([0-9]+)\s*,\s*([0-9]+)$/i','limit \\1 , 100',$sql);
						$sql = preg_replace('/limit\s+([0-9]+)$/i','limit 100',$sql);

					}
					$_res = $this -> tableModel -> query($sql);
					if(isset($_res) && is_array($_res) && !empty($_res))
					{
						$res = array_merge($res,$_res);
					}
					admin_log('执行sql语句', '执行了sql语句'.$sql);
				}

			}
		}

		$info = $this -> getFilterAllTable();
		$this -> assign('sql',$sqlquery);
		$this -> assign('table',array());
		$this -> assign('search',$info['search']);
		$this -> assign('table_info',$info['table']);
		$this -> assign('result',implode("\n",$tmp));
		$this -> assign('res',$res);
		$this -> assign('br',"\n");
		$this -> display('webset/dbm/webset_dbcommand_index');
	}


	/*
	 * 搜索过滤后的表
	 *
	 */
	function getFilterAllTable ()
	{
		//所有列表
		$search['name'] = $this -> post('search_name');
		$table_info = $this -> tableModel -> getTableInfo();//数据表状态信息

		//搜索过滤
		if(!empty($search['name']))
		{
			foreach ($table_info as $key => $val )
			{
				if(!preg_match('/'.$search['name'].'/i',$val['Name']))
					unset($table_info[$key]);
			}
		}
		return array('table'=>$table_info,'search'=>$search);
	}
}
?>
