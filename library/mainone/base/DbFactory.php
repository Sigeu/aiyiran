<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * DbFactory.php 数据库工厂类
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-19 下午2:45:28
 * @filename   DbFactory.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *
 */

if (!defined('IN_MAINONE')) {
	exit('No Permission');
}
final class DbFactory
{
	/**
	 * 当前数据库工厂类静态化实例
	 */
	private static $dbFactory;
	
	/**
	 * 数据库配置列表
	 */
	protected $dbConfig = array();
	
	/**
	 * 数据库操作实例化列表
	 */
	protected $dbList = array();
	
	/**
	 * 构造函数
	 */
	
	public function __construct()
	{
		
	}
	
	/**
	 * 返回当前终级类对象的实例
	 * @param  $dbconfig  数据库配置
	 */
	public static function getInstance($dbconfig='')
	{
		if ($dbconfig == '')
		{
			$dbconfig = get_config('database');
		}
		
		if (DbFactory::$dbFactory == '')
		{
			DbFactory::$dbFactory = new DbFactory();
		}
		
		if ($dbconfig != '' && $dbconfig != DbFactory::$dbFactory->dbConfig)
		{
			DbFactory::$dbFactory->dbConfig = array_merge($dbconfig,DbFactory::$dbFactory->dbConfig);
		}
		return DbFactory::$dbFactory;
	}
	
	/**
	 * 获取数据库操作实例
	 * @param  $dbname 数据库配置名称
	 * @return object:
	 */
	public function getDatabase($dbname='default')
	{
	    if (!isset($this->dbList[$dbname]) || !is_object($this->dbList[$dbname])) {
	    	$this->dbList[$dbname] = $this->connect($dbname);
	    }
	    
	    return $this->dbList[$dbname];
	}
	
	public function connect($dbname='default')
	{
		$object = null;
		switch($this->dbConfig[$dbname]['dbtype']) {
			case 'mysql' :
				Load::load_class('DbMysql',DIR_BF_ROOT.DS.'db',0);
				$object = new DbMysql();
				break;
            case 'mysqli' :
				Load::load_class('DbMysqli',DIR_BF_ROOT.DS.'db',0);
				$object = new DbMysqli();
				break;
			case 'postgreSQL' :
				$object = Load::load_class('DbPostgres',DIR_BF_ROOT.DS.'db');
				break;
			case 'access' :
				$object = Load::load_class('access',DIR_BF_ROOT.DS.'db');
				break;
			default :
				Load::load_class('DbMysql',DIR_BF_ROOT.DS.'db',0);
				$object = new DbMysql();
		}
		$object->open($this->dbConfig[$dbname]);
		return $object;
	}
	
	/**
	 * 关闭数据库连接
	 */
	public function close()
	{
	    foreach($this->dbList as $db)
	    {
	    	$db->close();
	    }
	}
	/**
	 * 析构函数
	 */
	public function __destruct()
	{
		$this->close();
	}
	
	
}