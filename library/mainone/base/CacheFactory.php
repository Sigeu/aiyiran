<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CacheFactory.php  缓存工厂类
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-19 下午2:44:08
 * @filename   CacheFactory.php  UTF-8
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
class CacheFactory
{
	/**
	 * 当前缓存工厂类静态实例
	 */
	private static $cacheFactory;

	/**
	 * 缓存配置列表
	 */
	protected $cacheConfig = array();

	/**
	 * 缓存操作实例化列表
	*/
	protected static $cacheList = array();

	/**
	 * 构造函数
	*/
	public function __construct() {
	}

	/**
	 * 返回当前终级类对象的实例
	 * @param $cache_config 缓存配置
	 * @return object
	 */
	public static function getInstance($cache_config = '') {

		if(CacheFactory::$cacheFactory == '' || $cache_config !='') {
			CacheFactory::$cacheFactory = new CacheFactory();
			if(!empty($cache_config)) {
				CacheFactory::$cacheFactory->cacheConfig = $cache_config;
			}else
			{
				CacheFactory::$cacheFactory->cacheConfig = C('cache','cache');
			}
		}
		return CacheFactory::$cacheFactory;
	}

	/**
	 * 获取缓存操作实例
	 * @param $cache_name 缓存配置名称
	 */
	public function getCache($cache_name) {
		if(!isset(CacheFactory::$cacheList[$cache_name]) || !is_object(CacheFactory::$cacheList[$cache_name])) {
			CacheFactory::$cacheList[$cache_name] = $this->load($cache_name);
		}
		return CacheFactory::$cacheList[$cache_name];
	}

	/**
	 *  加载缓存驱动
	 * @param $cache_name 	缓存配置名称
	 * @return object
	 */
	public function load($cache_name) {
		$object = null;
		if(isset($this->cacheConfig[$cache_name]['type'])) {
			switch($this->cacheConfig[$cache_name]['type']) {
				case 'file' :
			        if (!defined('FILE_EXPIRE'))
			        {
			        	define('FILE_EXPIRE', $this->cacheConfig[$cache_name]['expire']);
			        }
					$object = Load::load_class('CacheFile',DIR_BF_ROOT.DS.'cache');
					break;
				case 'memcache' :
					define('MEMCACHE_HOST', $this->cacheConfig[$cache_name]['hostname']);
					define('MEMCACHE_PORT', $this->cacheConfig[$cache_name]['port']);
					define('MEMCACHE_TIMEOUT', $this->cacheConfig[$cache_name]['timeout']);
					define('MEMCACHE_DEBUG', $this->cacheConfig[$cache_name]['debug']);
					define('MEMCACHE_EXPIRE', $this->cacheConfig[$cache_name]['expire']);

					$object = Load::load_class('CacheMemcache',DIR_BF_ROOT.DS.'cache');
					break;
				default :
			        if (!defined('FILE_EXPIRE'))
			        {
			        	define('FILE_EXPIRE', $this->cacheConfig['file']['expire']);
			        }
					$object = Load::load_class('CacheFile',DIR_BF_ROOT.DS.'cache');
			}
		} else {
	        if (!defined('FILE_EXPIRE'))
	        {
	        	define('FILE_EXPIRE', $this->cacheConfig['file']['expire']);
	        }
			$object = Load::load_class('CacheFile',DIR_BF_ROOT.DS.'cache');
		}
		return $object;
	}

}
