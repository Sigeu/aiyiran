<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * Model.php   model基类
 *
 * 所有model文件均继承此类
 * 2012.13.26 修改  添加了$tablePrefix变量，便于直接执行sql语句
 *
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-19 下午2:42:11
 * @filename   Model.php  UTF-8
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
class Model
{
	//表主键
	public $pk;

    // 数据表前缀
    public $tablePrefix  =   '';

	//表名称
	public $tableName = null;

    //表全名
	public $trueTableName = null;

	//数据库配置
	public $dbconfig = array();

	//调用数据库的配置项
	public $dbsetting = 'default';

   //数据库连接
    public $_db;


    public $options = array();

    //关联描述
	public $linker = null;

	//调试信息
	public $tmp_sql=array();

	//模型名称
	protected $modelname = null;


    // 数据库表达式
    protected $comparison      = array('eq'=>'=','neq'=>'<>','gt'=>'>','egt'=>'>=','lt'=>'<','elt'=>'<=','notlike'=>'NOT LIKE','like'=>'LIKE');
    // 查询表达式
    protected $selectSql  =     'SELECT %DISTINCT% %FIELD% FROM %TABLE% %JOIN% %WHERE% %GROUP% %HAVING% %ORDER% %LIMIT% %UNION%';

  	public function __construct($pk='',$tableName='',$dbconfig='',$dbsetting='',$tableprefix='')
  	{
  		$this->dbconfig = !empty($this->dbconfig)?$this->dbconfig:get_config('database');
  		if (!empty($pk))
  		{
  			$this->pk = $pk;
  		}

  		if (!empty($tableName))
  		{
  			$this->tableName = $tableName;
  		}
  		if (!empty($dbconfig))
  		{
  			$this->dbconfig = array_merge($this->dbconfig,$dbconfig);
  		}
  		if (!empty($tableprefix))
  		{
  			$this->tablePrefix = $tableprefix;
  		}
  		if (!empty($dbsetting))
  		{
  			$this->dbsetting = $dbsetting;
  		}
  		$this->pk = !empty($this->pk)?$this->pk:'id';
  		$this->tablePrefix = !empty($this->tablePrefix)?$this->tablePrefix:$this->dbconfig[$this->dbsetting]['prefix'];
  		$this->tableName = !empty($this->tableName)?$this->tableName:parse_name($this->getModelName());
  		$this->dbsetting = !empty($this->dbsetting)?$this->dbsetting:'default';
  		if (null == $this->trueTableName)
  		{
  			$this->trueTableName = $this->tablePrefix.$this->tableName;
  		}
  		$this->_db = DbFactory::getInstance($this->dbconfig)->getDatabase($this->dbsetting);
  	}

    function init($pk='',$tableName='',$dbconfig='',$dbsetting='default')
	{
		if (!empty($pk))
		{
			$this->pk = $pk;
		}else {
			$this->pk = 'id';
		}

		if (!empty($tableName))
		{
			$this->tableName = $tableName;
		}
		if (!empty($dbconfig))
		{
			$this->dbconfig = array_merge($this->dbconfig,$dbconfig);
		}
		if (!empty($dbsetting))
		{
			$this->dbsetting = $dbsetting;
		}else
		{
			$this->dbsetting = 'default';
		}
		$this->trueTableName = $this->dbconfig[$this->dbsetting]['prefix'].$this->tableName;
		$this->_db = DbFactory::getInstance($this->dbconfig)->getDatabase($this->dbsetting);
	}

   /**
     * 利用__call方法实现一些特殊的Model方法
     * @access public
     * @param string $method 方法名称
     * @param array $args 调用参数
     * @return mixed
     */
    public function __call($method,$args)
    {
        if(in_array(strtolower($method),array('where','order','limit','page','having','group','lock','distinct','field','count'),true))
        {
            // 连贯操作的实现
            $this->options[strtolower($method)] =   $args[0];
            return $this;
        }else
        {
        	//throw new SysException('method:{$method} is not existed');
            return;
        }
    }

	/**
	 * 在数据表中新增一行数据
	 *
	 * @param row 数组形式，数组的键是数据表中的字段名，键对应的值是需要新增的数据。
	 */
	public function create($row)
	{
		if(!is_array($row))return FALSE;
		$row = $this->__prepera_format($row);
		if(empty($row))return FALSE;
		foreach($row as $key => $value){
			$cols[] = '`'.$key.'`';
			$vals[] = "'{$this->__val_escape($value)}'";
		}
		$col = join(',', $cols);
		$val = join(',', $vals);
		$sql = "INSERT INTO {$this->trueTableName} ({$col}) VALUES ({$val})";

		if( FALSE != $this->_db->query($sql) )
		{
			// 获取当前新增的ID
			if( $newinserid = $this->_db->newInsertId() )
			{
				return $newinserid;
			}
			else
			{
				$record = $this->find($row, "{$this->pk} DESC",$this->pk);
				return array_pop( $record );
			}
		}
		return FALSE;
	}


	/**
	 * 在数据表中新增多条记录
	 *
	 * @param rows 数组形式，每项均为create的$row的一个数组
	 */
	public function createAll($rows)
	{
		$tmp = true;
		foreach($rows as $row)
		{
			$r = $this->create($row);
			$tmp = $tmp && (bool)$r;
		}
		return $tmp;
	}

	/**
	 * 在数据表中新增多条记录
	 *
	 * @param rows 数组形式，每项均为create的$row的一个数组
	 */
	public function addAll($rows)
	{
		if(is_array($rows))
		{
			foreach($rows as $key => $row)
			{
				$array[] = implode(',', $row);
				$cols=$row;
			}
			foreach($cols as $sonkey => $sonval)
			{
				$col[]=$sonkey;
			}
			$col = join(',', $col);
			$str = '';
			foreach ($array as $k => $v)
			{
                $arr = explode(',', $v);
                foreach ($arr as $key => $val) {
                    $arr[$key] = trim($val, "'");
                }
                $v = join("','", $arr);
				$str .= "('$v'),";
			}
			$val = substr($str,0,-1);
			$sql = "INSERT INTO {$this->trueTableName} ({$col}) VALUES {$val}";
            if( FALSE != $this->_db->query($sql) ){ // 获取当前新增的ID
				return true;
			}
			return FALSE;
		}
		else
		{
			return $this->create($rows);
		}
	}


    /**
	 * 从数据表中查找一条记录
	 *
	 * @param conditions    查找条件，数组array("字段名"=>"查找值")或字符串，
	 * 请注意在使用字符串时将需要开发者自行使用escape来对输入值进行过滤
	 * @param fields    返回的字段范围，默认为返回全部字段的值
	 */
	public function find($conditions = null, $sort = null, $fields = null)
	{
		$record = $this->findAll($conditions, '', $fields, 1);
		if($record){
			return array_pop($record);
		}else{
			return FALSE;
		}
	}

	/**
	 * 从数据表中查找记录
	 *
	 * @param conditions    查找条件，数组array("字段名"=>"查找值")或字符串，
	 * 请注意在使用字符串时将需要开发者自行使用escape来对输入值进行过滤
	 * @param sort    排序，等同于“ORDER BY ”
	 * @param fields    返回的字段范围，默认为返回全部字段的值
	 * @param limit    返回的结果数量限制，等同于“LIMIT ”，如$limit = " 3, 5"，即是从第3条记录（从0开始计算）开始获取，共获取5条记录
	 *                 如果limit值只有一个数字，则是指代从0条记录开始。
	 */
	public function findAll($conditions = null, $sort = null, $fields = null, $limit = null)
	{
		$fields = empty($fields) ? "*" : $fields;
		$where = $this -> getWhereSql($conditions);
		if(null != $sort)
		{
			$sort = "ORDER BY {$sort}";
		}
		else if (false === $sort)
		{
			$sort='';
		}
		else
		{
			$sort = "ORDER BY {$this->pk}";
		}
		$sql = "SELECT {$fields} FROM {$this->trueTableName} {$where} {$sort}";
		if(null != $limit)
		{
			$sql = $this->_db->setlimit($sql, 0, $limit);
		}

		return $this->_db->getArray($sql);
	}

	public function findLimit($conditions = null, $sort = null, $fields = null, $from = 0, $count = 30)
	{
		$fields = empty($fields) ? "*" : $fields;
		$where = $this -> getWhereSql($conditions);
		if(null != $sort){
			$sort = "ORDER BY {$sort}";
		}
		else if (false === $sort)
		{
			$sort='';
		}
		else
		{
			$sort = "ORDER BY {$this->pk}";
		}
		$sql = "SELECT {$fields} FROM {$this->trueTableName} {$where} {$sort}";
		if(null != $count)$sql = $this->_db->setlimit($sql, $from,$count);
		return $this->_db->getArray($sql);
	}
	/**
	 * 计算符合条件的记录数量
	 *
	 * @param conditions 查找条件，数组array("字段名"=>"查找值")或字符串，
	 * 请注意在使用字符串时将需要开发者自行使用escape来对输入值进行过滤
	 */
	public function findCount($conditions = null)
	{
		$where = $this -> getWhereSql($conditions);
		$sql = "SELECT COUNT(*) AS COUNTER FROM {$this->trueTableName} {$where}";
		$result = $this->_db->getArray($sql);
		return $result[0]['COUNTER'];
	}
	/**
	 * 修改数据，该函数将根据参数中设置的条件而更新表中数据
	 *
	 * @param conditions    数组形式，查找条件，此参数的格式用法与find/findAll的查找条件参数是相同的。
	 * @param row    数组形式，修改的数据，
	 *  此参数的格式用法与create的$row是相同的。在符合条件的记录中，将对$row设置的字段的数据进行修改。
	 */
	public function update($conditions, $row)
	{
 		$row = $this->__prepera_format($row);
		if(empty($row))return FALSE;

		$where = $this -> getWhereSql($conditions);
		foreach($row as $key => $value){
			if ('addition'==$key)               //用于自加更新，如登录次数
			{
				if (is_array($value))
				{
					foreach ($value as $k=>$v)
					{
						$vals[] = "{$k} = $v";
					}
				}else
				{
						$vals[] = $value;
				}
			}else
			{
			    $value = $this->__val_escape($value);
			    $vals[] = "`{$key}` = '{$value}'";

			}
		}
		$values = join(", ",$vals);
		$sql = "UPDATE {$this->trueTableName} SET {$values} {$where}";
//		echo $sql;
        return $this->_db->query($sql);
	}

	public function updateAll($key,$value,$options,$contions)
	{
		$sql ='';
		$sql.= " UPDATE ". $this->trueTableName;
		$sql.= " SET $value = CASE $key";
		foreach($options as $col => $val)
		{
			$sql.=" WHEN '$col' THEN '$val' ";
		}
		$sql.= " END";
		$b = implode(array_values($contions),',');
		$sql.= " WHERE $key in ($b)";
		return $this->_db->query($sql);
	}

	/**
	 * 按条件删除记录
	 *
	 * @param conditions 数组形式，查找条件，此参数的格式用法与find/findAll的查找条件参数是相同的。
	 */
	public function delete($conditions = null)
	{
		$where = $this -> getWhereSql($conditions);
		$sql = "DELETE FROM {$this->trueTableName} {$where}";

		return $this->_db->query($sql);
	}


	public function select($options = array())
	{
		$options =  $this->_parseOptions($options);
		$sql = $this->getFullSql($options);
//         echo $sql;
		$result = $this->_db->getArray($sql);
		return $result;
	}

	public function getOne($options = array())
	{
		if(is_numeric($options) || is_string($options)) {
            $where[$this->pk] =$options;
            $options = array();
            $options['where'] = $where;
        }
		$options['limit'] = 1;
		$options =  $this->_parseOptions($options);
		$resultSet = $this->select($options);
		if (false === $resultSet)
		{
			return false;
		}
		if (empty($resultSet))
		{
			return null;
		}
		$result = $resultSet[0];
		return  $result;
	}

	/**
	* 配置条件语句
	*/
	public function getWhereSql($conditions=null) {
		$where = "";
		if(is_array($conditions) && count($conditions)){
			$join = array();
			foreach( $conditions as $key => $condition ){
				if (is_array($condition) && strtolower($key) == 'like' ) { //模糊查询
					foreach ($condition as $k => $v) {
						$v = $this->__val_escape($v);
						$join[] = "{$k} LIKE '%{$v}%'";
					}
				} else if (is_array($condition) && strtolower($key) == 'between') { //区间查询
					foreach ($condition as $k => $v) {
				        $v0 = $this->__val_escape($v[0]);
				        $v1 = $this->__val_escape($v[1]);
						$join[] = "{$k} BETWEEN '{$v0}' AND '{$v1}'";
					}
				}else if (is_array($condition) && strtolower($key) == 'compbig') {  //大于查询

					foreach ($condition as $k => $v) {
						$v = $this->__val_escape($v);

						$join[] = "{$k} >= '{$v}'";
					}
				}else if (is_array($condition) && strtolower($key) == 'compsmall') {  //小于查询
					foreach ($condition as $k => $v) {
						$v = $this->__val_escape($v);
						$join[] = "{$k} <= '{$v}'";
					}
				}else if (is_string($condition) && strtolower($key) == 'or') {  //or查询
					$join[] = '('.$condition.')';
				}else if (is_array($condition) && strtolower($key) == 'or') {  //or查询
					foreach ($condition as $row)
					{
						$join[] = '('.$row.')';
					}
				}else if (is_array($condition) && strtolower($key) == 'in') {  //in
					foreach ($condition as $k => $v) {
						$join[] = "{$k} in ({$v})";
					}
				}else if (is_array($condition) && strtolower($key) == 'notin') {  //not in
					foreach ($condition as $k => $v) {
						$join[] = "{$k} NOT IN ({$v})";
					}
				}else {
					$condition = $this->__val_escape($condition);
					$join[] = "{$key} = '{$condition}'";
				}
			}
			$where = "WHERE ".join(" AND ",$join);
		}else{
			if(null != $conditions)
			{
				$where = "WHERE ".$conditions;
			}
		}
		return $where;
	}
	/**
	 * 配置sql语句
	 */
	public function getFullSql($options=array())
	{
		$options =  $this->_parseOptions($options);
        $sql  =   $this->parseSql($this->selectSql,$options);

        return $sql;
	}

	/**
	 * 解析sql语句
	 */
	protected function parseSql($sql,$options=array())
	{
		$options =  $this->_parseOptions($options);
        $sql   = str_replace(
            array('%TABLE%','%DISTINCT%','%FIELD%','%JOIN%','%WHERE%','%GROUP%','%HAVING%','%ORDER%','%LIMIT%','%UNION%'),
            array(
                $this->trueTableName,
                $this->parseDistinct(isset($options['distinct'])?$options['distinct']:false),
                $this->parseField(isset($options['field'])?$options['field']:'*'),
                $this->parseJoin(isset($options['join'])?$options['join']:''),
                $this->getWhereSql(isset($options['where'])?$options['where']:''),
                $this->parseGroup(isset($options['group'])?$options['group']:''),
                $this->parseHaving(isset($options['having'])?$options['having']:''),
                $this->parseOrder(isset($options['order'])?$options['order']:''),
                $this->parseLimit(isset($options['limit'])?$options['limit']:''),
//                $this->parseUnion(isset($options['union'])?$options['union']:'')
            ),$sql);
        return $sql;

	}
	/**
     * distinct分析
     * @access protected
     * @param mixed $distinct
     * @return string
     */
    protected function parseDistinct($distinct)
    {
        return !empty($distinct)?   ' DISTINCT ' :'';
    }

    /**
     * field分析
     * @access protected
     * @param mixed $fields
     * @return string
     */
    protected function parseField($fields)
    {
        if(is_string($fields) && strpos($fields,','))
        {
            $fields    = explode(',',$fields);
        }
        if(is_array($fields))
        {
            // 完善数组方式传字段名的支持
            // 支持 'field1'=>'field2' 这样的字段别名定义
            $array   =  array();
            foreach ($fields as $key=>$field)
            {
                if(!is_numeric($key))
                {
                    $array[] =  $this->parseKey($key).' AS '.$this->parseKey($field);
                }
                else
                {
                    $array[] =  $this->parseKey($field);
                }
            }
            $fieldsStr = implode(',', $array);
        }elseif(is_string($fields) && !empty($fields))
        {
            $fieldsStr = $this->parseKey($fields);
        }else
        {
            $fieldsStr = '*';
        }
        //TODO 如果是查询全部字段，并且是join的方式，那么就把要查的表加个别名，以免字段被覆盖
        return $fieldsStr;
    }
    /**
     * join分析
     * @access protected
     * @param mixed $join
     * @return string
     */
    protected function parseJoin($join)
    {
        $joinStr = '';
        if(!empty($join))
        {
            if(is_array($join))
            {
                foreach ($join as $key=>$_join)
                {
                    if(false !== stripos($_join,'JOIN'))
                    {
                        $joinStr .= ' '.$_join;
                    }
                    else
                    {
                        $joinStr .= ' LEFT JOIN ' .$_join;
                    }
                }
            }else
            {
                $joinStr .= ' LEFT JOIN ' .$join;
            }
        }
		//将__TABLE_NAME__这样的字符串替换成正规的表名,并且带上前缀和后缀
// 		$joinStr = preg_replace("/__([A-Z_-]+)__/esU",$this->dbconfig[$this->dbsetting]['prefix'].".strtolower('$1')",$joinStr);
		//$joinStr = preg_replace("/__([A-Z_-]+)__/sU",$this->tablePrefix.".strtolower('$1')",$joinStr);
        $joinStr = preg_replace_callback("/__([A-Z_-]+)__/sU",function($match){
           return  $this->tablePrefix.strtolower($match[1]);
        },$joinStr);
        return $joinStr;
    }

    /**
     * limit分析
     * @access protected
     * @param mixed $lmit
     * @return string
     */
    protected function parseLimit($limit)
    {
        return !empty($limit)?   ' LIMIT '.$limit.' ':'';
    }

    /**
     * order分析
     * @access protected
     * @param mixed $order
     * @return string
     */
    protected function parseOrder($order)
    {
        if(is_array($order))
        {
            $array   =  array();
            foreach ($order as $key=>$val)
            {
                if(is_numeric($key))
                {
                    $array[] =  $this->parseKey($val);
                }else
                {
                    $array[] =  $this->parseKey($key).' '.$val;
                }
            }
            $order   =  implode(',',$array);
        }
        return !empty($order)?  ' ORDER BY '.$order:'';
    }

    /**
     * group分析
     * @access protected
     * @param mixed $group
     * @return string
     */
    protected function parseGroup($group)
    {
        return !empty($group)? ' GROUP BY '.$group:'';
    }

    /**
     * having分析
     * @access protected
     * @param string $having
     * @return string
     */
    protected function parseHaving($having)
    {
        return  !empty($having)?   ' HAVING '.$having:'';
    }

    /**
     * union分析
     * @access protected
     * @param mixed $union
     * @return string
     */
    protected function parseUnion($union)
    {
        if(empty($union))
        {
        	return '';
        }
        if(isset($union['_all']))
        {
            $str  =   'UNION ALL ';
            unset($union['_all']);
        }else
        {
            $str  =   'UNION ';
        }
        foreach ($union as $u)
        {
            $sql[] = $str.(is_array($u)?$this->getFullSql($u):$u);
        }
        return implode(' ',$sql);
    }
    /**
     * 字段名分析
     * @access protected
     * @param string $key
     * @return string
     */
    protected function parseKey(&$key)
    {
        return $key;
    }

	 /**
     * 分析表达式
     * @access proteced
     * @param array $options 表达式参数
     * @return array
     */
    protected function _parseOptions($options=array())
    {
        if(is_array($options))
        {
            $options =  array_merge($this->options,$options);
        }
        // 查询过后清空sql表达式组装 避免影响下次查询
        $this->options  =   array();
        return $options;
    }

	/**
	 * 按表字段调整适合的字段
	 * @param rows    输入的表字段
	 */
	private function __prepera_format($rows)
	{
		$columns = $this->_db->getTable($this->trueTableName);
		$newcol = array();
		foreach( $columns as $col ){
			$newcol[$col['Field']] = $col['Field'];
		}
		return array_intersect_key($rows,$newcol);
	}

	/**
	 * 过滤转义字符
	 *
	 * @param value 需要进行过滤的值
	 */
	public function escape($value)
	{
		return $this->_db->__val_escape($value);
	}

	// __val_escape是val的别名，向前兼容
	public function __val_escape($value)
	{
		return $this->escape($value);
	}

 	/**
     * 启动事务
     * @access public
     * @return void
     */
    public function startTrans()
    {
        return $this->_db->startTrans();
    }

    /**
     * 用于非自动提交状态下面的查询提交
     * @access public
     * @return boolen
     */
    public function commit()
    {
       return $this->_db->commit();
    }

    /**
     * 事务回滚
     * @access public
     * @return boolen
     * @throws BaseException
     */
    public function rollback()
    {
       return $this->_db->rollback();
    }

	/**
     * SQL查询
     * @access public
     * @param mixed $sql  SQL指令
     * @param boolean $parse  是否需要解析SQL
     * @return mixed
     */
    public function query($sql,$parse=false)
	{
        $sql  =   $this->parseSql($sql,$parse);
		$tmp = array();
		$tmp[] = strtolower(substr(ltrim($sql),0,6));
		$tmp[] = strtolower(substr(ltrim($sql),0,4));
		$tmp[] = strtolower(substr(ltrim($sql),0,7));
		$tmp[] = strtolower(substr(ltrim($sql),0,8));
		if(array_intersect($tmp,array('select','show','explan','describe')))
			return $this->_db->getArray($sql);
		else
			return $this -> _db -> query($sql);
		//return $this->_db->getArray($sql);
    }

    /**
     * 查询缓存
     * @access public
     * @param mixed $key
     * @param integer $expire
     * @param string $type
     * @return Model
     */
    public function cache($key=true,$expire='',$type=''){
        $this->options['cache']  =  array('key'=>$key,'expire'=>$expire,'type'=>$type);
        return $this;
    }
    /**
     * 查询SQL组装 join
     * @access public
     * @param mixed $join
     * @return Model
     */
    public function join($join) {
        if(is_array($join)) {
            $this->options['join'] =  $join;
        }elseif(!empty($join)) {
            $this->options['join'][]  =   $join;
        }
        return $this;
    }
    /**
     * 得到当前的数据对象名称
     * @access public
     * @return string
     */
    public function getModelName() {
    	if(empty($this->name))
    		$this->name =   substr(get_class($this),0,-5);
    	return $this->name;
    }

	/**
     * 返回分页列表数组
     * @param array()
     * @return array()
	 * 修改请保证向下兼容
     */
	public function getPageList ($param=array())
	{
		//处理参数，下面参数都是可选的
		$param['where']		= isset($param['where']) ? $param['where'] : array() ;	//条件 查询语句所有可用的条件
		$param['table']		= isset($param['table']) ? $param['table'] : '' ;		//表名
		$param['field']		= isset($param['field']) ? $param['field'] : '' ;		//需要哪些字段

		$param['sql']		= isset($param['sql']) ? $param['sql'] : '' ;			//连表分页时，自己传sql，不带limit限制
		$param['search']	= isset($param['search']) ? $param['search'] : array() ;//条件，一维array 在url上显示的条件
		$param['pagesize']	= isset($param['pagesize']) ? $param['pagesize'] : 20 ;	//一页多少条
		//查询总条数，构造基本sql语句
		if($param['sql'] == '')
		{
			$where = $this -> getWhereSql($param['where']);														//where条件 WHERE status = '1'
			$table = !empty($param['table']) ? $this -> tablePrefix.$param['table'] : $this -> trueTableName;	//表名
			$field = !empty($param['field']) ? $param['field'] : '*' ;											//字段
		 	$sql = 'SELECT '.$field.' FROM '.$table.' '.$where;													//基本的sql
			$result = $this->_db->getArray("SELECT COUNT(*) AS COUNTER FROM `".$table."` ".$where."");
			$count = $result[0]['COUNTER'];																		//获取带条件的总条数
		}
		else
		{
			$sql = $param['sql'];
			$count = count($this -> query($sql));
		}

		//构造分页，查询列表
		$pagesize = $param['pagesize'];											//一页多少条
		$page = new Page($count, $pagesize);									//分页对象
		$page->parameter = $param['search'];									//搜索条件
		$from = $page->firstRow;												//开始查询位置
		$plist['list'] = $this->query($sql.' limit '.$from.' , '.$pagesize);	//列表
		$plist['pagestr'] = $page->show();										//分页字符串
		!is_array($plist['list']) && ($plist['list'] = array());

		//返回其他附加信息
		$plist['pagesize'] = $pagesize;
		$plist['getTotalPages'] = $page->getTotalPages();
		$plist['getTotalRows'] = $page->getTotalRows();
		$plist['getNowPage'] = $page->getNowPage();
		return $plist;
	}

	/**
	 * 获取所有表
	 *
	 * @return tables
	 */
	public function getTables()
	{
		return $this->_db->getArray('SHOW TABLES');
		/*
			返回Array
			(
				[0] => Array
					(
						[Tables_in_test] => mo_test
					)

				[1] => Array
					(
						[Tables_in_test] => mo_user
					)
			)
		*/
	}

	/**
	 * 获取一个表的表信息
	 *
	 * @param $table
	 * @return table status string
	 */
	public function getTableStatus($table)
	{
		return $table ? current($this->_db->getArray('SHOW TABLE STATUS LIKE "'.$table.'"')) : array();
		/*
			返回Array
			(
				[Name] => mo_test
				[Engine] => InnoDB
				[Version] => 10
				[Row_format] => Compact
				[Rows] => 2
				[Avg_row_length] => 8192
				[Data_length] => 16384
				[Max_data_length] => 0
				[Index_length] => 0
				[Data_free] => 5242880
				[Auto_increment] => 12
				[Create_time] => 2012-10-26 11:39:53
				[Update_time] =>
				[Check_time] =>
				[Collation] => latin1_swedish_ci
				[Checksum] =>
				[Create_options] =>
				[Comment] => 测试表
			)
		*/
	}

	/**
	 * 获取create table 信息
	 *
	 * @param $table
	 * @return create table string
	 */
	public function getCreateTable($table)
	{
		return $table ? current($this->_db->getArray('SHOW CREATE TABLE `'.$table.'`')) : array();
		/*
			返回 Array
			(
				[Table] => mo_test
				[Create Table] => CREATE TABLE `mo_test` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` int(11) NOT NULL,
			  `sex` int(11) NOT NULL,
			  `age` int(11) NOT NULL,
			  `time` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='测试表'
			)
		*/
	}
	/**
	 * 获取所有字段
	 *
	 * @return tables
	 */
	public function getFields($tablename)
	{
		return $this->_db->getArray('SHOW FIELDS FROM '.$this->tablePrefix.$tablename);

	}
	/**
	 * 优化表
	 *
	 * @param string $tables table1,table2,table3....逗号分隔的表名
	 * @param bool 是否返回优化信息
	 * @return array() or bool
	 */
	public function optimizeTables($table,$return=false)
	{
		if($return)
		{
			return $table ? $this->_db->getArray('OPTIMIZE TABLE '.$table) : array();
		}
		else
		{
			return $this->_db->query('OPTIMIZE TABLE '.$table) ? true : false;
		}
		/*
			返回Array
			(
				[0] => Array
					(
						[Table] => test.mo_test
						[Op] => optimize
						[Msg_type] => note
						[Msg_text] => Table does not support optimize, doing recreate + analyze instead
					)

				[1] => Array
					(
						[Table] => test.mo_test
						[Op] => optimize
						[Msg_type] => status
						[Msg_text] => OK
					)

				[2] => Array
					(
						[Table] => test.mo_user
						[Op] => optimize
						[Msg_type] => note
						[Msg_text] => Table does not support optimize, doing recreate + analyze instead
					)

				[3] => Array
					(
						[Table] => test.mo_user
						[Op] => optimize
						[Msg_type] => status
						[Msg_text] => OK
					)
			)
		*/
	}

	/**
	 * 修复表
	 *
	 * @param string $tables table1,table2,table3....逗号分隔的表名
	 * @param bool 是否返回修复信息
	 * @return array() or bool
	 */
	public function repairTables($table,$return=false)
	{
		if($return)
		{
			return $table ? $this->_db->getArray('REPAIR TABLE '.$table.' EXTENDED') : array();
		}
		else
		{
			return $this->_db->query('REPAIR TABLE '.$table.' EXTENDED') ? true : false;
		}
		/*
			返回Array
			(
				[0] => Array
					(
						[Table] => test.mo_test
						[Op] => repair
						[Msg_type] => note
						[Msg_text] => The storage engine for the table doesn't support repair
					)

				[1] => Array
					(
						[Table] => test.mo_user
						[Op] => repair
						[Msg_type] => note
						[Msg_text] => The storage engine for the table doesn't support repair
					)
			)
		*/
	}

	/**
	 * 递归调取数据
	 * 注意要查询的表必须符合无限分类表的设计
	 *
	 * @param $pid            父级ID
	 * @param &$_quote_temp   用来存放查询结果的数组 此处传的引用
	 * @param $table          要查询的表
	 * @param $level          查询深度
	 * @param $field          需要的字段
	 * @param $pk_key         主键key
	 * @param $pid_key        父id key
	 * @param $level_key      表示级别的key
	 * @param $i              默认即可
	 * @return array()        具有子父级关系的array 不过子父级间是平级关系 每个信息里面有表示自己所在级别的字段$level_key
	 */
	public function recurseQueryTree(
		$pid=0,
		&$_quote_temp,
		$table='',
		$level=0,
		$field='*',
		$pk_key='id',
		$pid_key='pid',
		$level_key='level',
		$order = '',
		$i=-1)
	{
		$i++;
		//查询深度限制
		if($level && ($i>=$level))
		{
			return '';
		}

		//组织sql语句
		$sql = 'SELECT '.$field.' FROM `'.$this->tablePrefix.$table.'` WHERE '.$pid_key.'='.$pid.'';
		if($order)
		{
			$sql .= ' ORDER BY '.$order;
		}
		$data = $this->query($sql);
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$val[$level_key] = $i+1;
				$_quote_temp[$val[$pk_key]] = $val;
				$this -> recurseQueryTree(
					$val[$pk_key],
					$_quote_temp,
					$table,
					$level,
					$field,
					$pk_key,
					$pid_key,
					$level_key,
					$order,
					$i);
			}
		}
	}
}