<?php
/**
 * Memcache缓存类
 * @author wangrui
 *
 */
class CacheMemcache
{
	private $memcache = NULL; 
	
	public function __construct()
	{
		$this->memcache = new Memcache;
		$this->memcache->connect(MEMCACHE_HOST, MEMCACHE_PORT, MEMCACHE_TIMEOUT);
	}
	
	public function memcache() 
	{
		$this->__construct();
	}
	/**
	 * 读取缓存内容
	 * @param mixed   $name   缓存名称
	 * @return mixed          缓存内容
	 */
	public function get($name) 
	{
		$value = $this->memcache->get($name);
		return $value;
	}
	
	/**
	 * 写入缓存
	 * @param mixed   $name    缓存名称
	 * @param mixed   $value   缓存数据
	 * @param int     $expire  过期时间
	 * @param unknow  $ext1        扩展参数
	 * @param unknow  $ext2        扩展参数
	 */
	public function set($name, $value, $expire = 0, $ext1='', $ext2='') 
	{
		return $this->memcache->set($name, $value, false, $expire);
	}
	
	/**
	 * 删除缓存
	 * @param mixed   $name    缓存名称
	 */
	public function delete($name) 
	{
		return $this->memcache->delete($name);
	}
	
	/**
	 * 清除缓存
	 */
	public function flush() 
	{
		return $this->memcache->flush();
	}
}
