<?php
/**
 *
 * mysqli数据库类
 * 兼容php7
 * 1.连接数据库
 * 2.CRUD操作
 *
 * @author 一梦一尘
 *
 */
class DbMysqli
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
	    $this->link = new mysqli($this->config['hostname'], $this->config['username'], $this->config['password'], $this->config['dbname'],3306);
		if(mysqli_connect_error()){
			$this->halt('Can not connect to MySQL server');
			return false;
		}
	
		$charset = isset($this->config['charset']) ? $this->config['charset'] : 'utf8';
		$serverset = $charset ? "character_set_connection='$charset',character_set_results='$charset',character_set_client=binary" : '';
		$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
		$serverset && $this->link->query("SET $serverset");
		return $this->link;
	}

	/**
	 * 数据库查询执行方法
	 * @param $sql 要执行的sql语句
	 * @return 查询资源句柄
	 */
	private function execute($sql)
	{
		if(!is_object($this->link)) {
			$this->connect();
		}
		$this->lastqueryid = $this->link->query($sql) or $this->halt($this->link->error, $sql);
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
	 * @return 返回sql影响结果数
	 */
    public function affected_rows()
	{
		if(!is_object($this->link)) {
			$this->connect();
		}
		return $this->link->affected_rows;
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
	    $this->execute($sql);
		if(!is_object($this->lastqueryid)) {
			return $this->lastqueryid;
		}

		$datalist = array();
		 while(($rs = $this->fetch_next()) != false) {
		   $datalist[] = $rs;
		}
		$this->free_result();
		return $datalist;
	}

	/**
	 * 遍历查询结果集
	 * @param $type		返回结果集类型	
	 * 					MYSQLI_ASSOC, MYSQLI_NUM, or MYSQLI_BOTH
	 * @return array
	 */
	public function fetch_next($type=MYSQLI_ASSOC) {
		$res = $this->lastqueryid->fetch_array($type);
		if(!$res) {
			$this->free_result();
		}
		return $res;
	}
	
	/**
	 * 返回当前插入记录的主键ID
	 */
	public function newInsertId()
	{  
	    if(!is_object($this->link)) {
			$this->connect();
		}
		return $this->link->insert_id;
		
	}
	
    /**
	 * 获取数据表主键
	 * @param $table 		数据表
	 * @return array
	 */
	public function get_primary($table) {
		$this->execute("SHOW COLUMNS FROM $table");
		while($r = $this->fetch_next()) {
			if($r['Key'] == 'PRI') break;
		}
		return $r['Field'];
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
            $this->link->autocommit(false);//开始事物
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
            $result = $this->link->commit();
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
            $result = $this->link->rollback();
            $this->transTimes = 0;
            if(!$result){
                halt($this->error());
            }
        }
        return true;
    }

	
	
	//关闭当前的链接
	public function close() {
		if ($this->link) {
			$this->link->close();
		}
		$this->link = null;
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
		return $this->link->real_escape_string($value);

	}
    
	//释放查询资源
	public function free_result() {
		if(is_resource($this->lastqueryid)) {
			$this->lastqueryid->free();
			$this->lastqueryid = null;
		}
	}
	
	
    //当前错误
	public function error() {
		if(!is_object($this->link)) {
			$this->connect();
		}
		return $this->link->error;
	}
   
    //当前的错误编号
	public function errno() {
		if(!is_object($this->link)) {
			$this->connect();
		}
		return intval($this->link->errno);
	}

    
	
	//获取数据库版本
	public function version() {
		if(!is_object($this->link)) {
			$this->connect();
		}
		return $this->link->server_info;//server_version
	}

	//抛出错误
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
	
	/**
	 * 对字段两边加反引号，以保证数据库安全
	 * @param $value 数组值
	 */
	public function add_special_char(&$value) {
		if('*' == $value || false !== strpos($value, '(') || false !== strpos($value, '.') || false !== strpos ( $value, '`')) {
			//不处理包含* 或者 使用了sql方法。
		} else {
			$value = '`'.trim($value).'`';
		}
		if (preg_match("/\b(select|insert|update|delete)\b/i", $value)) {
			$value = preg_replace("/\b(select|insert|update|delete)\b/i", '', $value);
		}
		return $value;
	}
  

}