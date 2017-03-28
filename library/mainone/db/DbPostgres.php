<?php
/**
 * DbPostgres 数据库的驱动支持
 */
class DbPostgres {
	/**
	 * 数据库链接句柄
	 */
	public $link;
	
    // 事务指令数
    protected $transTimes      = 0;
	
	public function __construct()
	{
		
	}
	
	public function open($config)
	{
		
	}
	
	
	public function connect()
	{
		
	}
		
	public function excute($sql)
	{
		
	}
	
	public function query($sql)
	{
		
	}
	
	public function getArray($sql)
	{
	}
	
	public function newInsertId()
	{
	}
	
	public function getTable($tablename)
	{
	}
	/**
	 * 启动事务
	 * @access public
	 * @return void
	 * @throws ThinkExecption
	 */
	public function startTrans() {
		if ( !$this->link ) return false;
		//数据rollback 支持
		if ($this->transTimes == 0) {
			pg_exec($this->link,'begin;');
		}
		$this->transTimes++;
		return ;
	}
	
	/**
	 * 用于非自动提交状态下面的查询提交
	 * @access public
	 * @return boolen
	 * @throws ThinkExecption
	 */
	public function commit() {
		if ($this->transTimes > 0) {
			$result = pg_exec($this->link,'end;');
			if(!$result){
				throw_exception($this->error());
			}
			$this->transTimes = 0;
		}
		return true;
	}
	
	/**
	 * 事务回滚
	 * @access public
	 * @return boolen
	 * @throws ThinkExecption
	 */
	public function rollback() {
		if ($this->transTimes > 0) {
			$result = pg_exec($this->link,'abort;');
			if(!$result){
				throw_exception($this->error());
			}
			$this->transTimes = 0;
		}
		return true;
	}
	public function __val_escape($value)
	{
	}
	public function error()
	{
	}
	
	public function version()
	{
	}

	public function close()
	{
	
	}
	public function __destruct()
	{
		$this->close();
	}
	

	
}
