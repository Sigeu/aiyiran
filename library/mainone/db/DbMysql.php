<?php
/**
 *
 * mysql数据库类
 * 1.连接数据库
 * 2.CRUD操作
 *
 * @author wangrui
 *
 */
class DbMysql
{
	/**
	 * 数据库配置信息
	 */
	private $config = null;

	/**
	 * 数据库连接资源句柄
	 */
	public $link = null;

	/**
	 * 最近一次查询资源句柄
	 */
	public $lastqueryid = null;

	/**
	 *  统计数据库查询次数
	 */
	public $querycount = 0;

    // 事务指令数
    protected $transTimes      = 0;


    /**
     *
     * 构造函数
     */
	public function __construct()
	{
    }

    /**
     * 打开数据库连接,有可能不真实连接数据库
     * @param $config	数据库连接参数
     *
     * @return void
     */
    public function open($config)
    {
        $this->config = $config;
		if($config['autoconnect'] == 1) {
			$this->connect();
		}
    }

    /**
     * 真正开启数据库连接
     *
     * @return void
     */
	public function connect()
	{
		$func = $this->config['pconnect'] == 1 ? 'mysql_pconnect' : 'mysql_connect';
		if(!$this->link = @$func($this->config['hostname'], $this->config['username'], $this->config['password'], 1))
		{
			$this->halt('Can not connect to MySQL server');
			return false;
		}
		if($this->version() > '4.1')
		{
			$charset = isset($this->config['charset']) ? $this->config['charset'] : '';
			$serverset = $charset ? "character_set_connection='$charset',character_set_results='$charset',character_set_client=binary" : '';
			$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
			$serverset && mysql_query("SET $serverset", $this->link);
		}
		if($this->config['dbname'] && !@mysql_select_db($this->config['dbname'], $this->link))
		{
			$this->halt('Cannot use database '.$this->config['dbname']);
			return false;
		}
		$this->database = $this->config['dbname'];
		return $this->link;
	}

	/**
	 * 数据库查询执行方法
	 * @param $sql 要执行的sql语句
	 * @return 查询资源句柄
	 */
	private function execute($sql)
	{
		if(!is_resource($this->link))
		{
			$this->connect();
		}
// 		$this->lastqueryid = mysql_query($sql, $this->link) or $this->halt(mysql_error(), $sql);
		$this->lastqueryid = mysql_query($sql, $this->link);
		$this->querycount++;
		return $this->lastqueryid;
	}

	/**
	 * 直接执行sql查询
	 * @param $sql							查询sql语句
	 * @return	boolean/query resource		如果为查询语句，返回资源句柄，否则返回true/false
	 */
	public function query($sql)
	{
		defined('SYS_DEBUG') && SYS_DEBUG ? $this -> msql[] = '<font color=\'red\'>'.$sql.'</font>' : '';
		return $this->execute($sql);
	}

	/**
	 * 获取数据表结构
	 *
	 * @param tbl_name  表名称
	 */
	public function getTable($tbl_name)
	{
		return $this->getArray("DESCRIBE {$tbl_name}");
	}

	/**
	 * 按SQL语句获取记录结果，返回数组
	 *
	 * @param sql  执行的SQL语句
	 */
	public function getArray($sql)
	{
		if( ! $result = $this->query($sql) )
		{
			return array();
		}
		if( ! mysql_num_rows($result) )return array();
		{
			$rows = array();
		}
		while($rows[] = mysql_fetch_array($result,MYSQL_ASSOC)){}
		mysql_free_result($result);
		array_pop($rows);
		return $rows;
	}

	/**
	 * 返回当前插入记录的主键ID
	 */
	public function newInsertId()
	{
		return mysql_insert_id($this->link);
	}

	/**
	 * 格式化带limit的SQL语句
	 */
	public function setlimit($sql, $from, $count)
	{
		return $sql. " LIMIT {$from},{$count}";
	}


    /**
     * 启动事务
     * @access public
     * @return void
     */
    public function startTrans()
    {
        //数据rollback 支持
        if ($this->transTimes == 0)
        {
            mysql_query('START TRANSACTION');
        }
        $this->transTimes++;
        return ;
    }

    /**
     * 用于非自动提交状态下面的查询提交
     * @access public
     * @return boolen
     */
    public function commit()
    {
        if ($this->transTimes > 0)
        {
            $result = mysql_query('COMMIT');
            $this->transTimes = 0;
            if(!$result)
            {
                halt($this->error());
            }
        }
        return true;
    }

    /**
     * 事务回滚
     * @access public
     * @return boolen
     * @throws BaseException
     */
    public function rollback()
    {
        if ($this->transTimes > 0)
        {
            $result = mysql_query('ROLLBACK');
            $this->transTimes = 0;
            if(!$result){
                halt($this->error());
            }
        }
        return true;
    }

	public function close() {
		if (is_resource($this->link)) {
			@mysql_close($this->link);
		}
	}


	/**
	 * 对特殊字符进行过滤
	 *
	 * @param value  值
	 */
	public function __val_escape($value)
	{
//		if(is_null($value))
//		{
//			return 'NULL';
//		}
		if(is_bool($value))
		{
			return $value ? 1 : 0;
		}
		if(is_int($value))
		{
			return (int)$value;
		}
		if(is_float($value))
		{
			return (float)$value;
		}
		if(@get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		return @mysql_real_escape_string($value);

	}

	public function error() {
		return @mysql_error($this->link);
	}

	public function errno() {
		return intval(@mysql_errno($this->link)) ;
	}


	public function halt($message = '', $sql = '')
	{
		if($this->config['debug'])
		{
			$this->errormsg = "<b>MySQL Query : </b> $sql <br /><b> MySQL Error : </b>".$this->error()." <br /> <b>MySQL Errno : </b>".$this->errno()." <br /><b> Message : </b> $message ";
			$msg = $this->errormsg;
			echo '<div style="font-size:12px;text-align:left; border:1px solid #9cc9e0; padding:1px 4px;color:#000000;font-family:Arial, Helvetica,sans-serif;"><span>'.$msg.'</span></div>';
			exit;
		} else
		{
			return false;
		}
	}

	public function version() {
		if(!is_resource($this->link)) {
			$this->connect();
		}
		return mysql_get_server_info($this->link);
	}

}