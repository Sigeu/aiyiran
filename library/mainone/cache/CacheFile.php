<?php
/**
 * 文件缓存类
 * @author wangrui
 *
 */
class CacheFile
{
	/*缓存默认配置*/
	protected $_setting = array(
			'suf' => '.cache.php',	    /*缓存文件后缀*/
			'type' => 'array',		/*缓存格式：array数组，serialize序列化，null字符串*/
	);

	/*缓存路径*/
	protected $filepath = '';

	/**
	 * 构造函数
	 * @param	array	$setting	缓存配置
	 * @return  void
	 */
	public function __construct($setting = '')
	{
		$this->_setting['expire'] = FILE_EXPIRE;
		$this->getSetting($setting);
	}

	/**
	 * 写入缓存
	 * @param	string	$name		缓存名称
	 * @param	mixed	$data		缓存数据
	 * @param	array	$expire  	过期时间
	 * @param	string	$type		缓存类型  data/view
	 * @param	string	$module		所属模块
	 * @return  mixed				缓存路径/false
	 */

	public function set($name, $data, $expire = 0, $type = 'data', $module = '',$app='')
	{
		if (!empty($expire))
		{
		    $this->getSetting(array('expire'=>$expire));
		}
		if(empty($type)) $type = 'data';
		if(empty($module)) $module = app::getModuleName();

		if (!empty($app))
		{
			$filepath = str_replace(DIR_ROOT, DIR_ROOT.$app.DS, DIR_CACHE.'caches_'.$module.DS.'caches_'.$type.DS);
			$filepath = str_replace(APPNAME.DS, '', $filepath);
			$filepath = str_replace('home'.DS, '', $filepath);
		}else
		{
			$filepath = DIR_CACHE.'caches_'.$module.DS.'caches_'.$type.DS;
		}
		$filename = $name.$this->_setting['suf'];
		if(!is_dir($filepath))
		{
			mkdir($filepath, 0777, true);
		}

		$datas = array('expire'=>$this->_setting['expire'],'data'=>$data);
		if($this->_setting['type'] == 'array')
		{
			$data = "<?php\nreturn ".var_export($datas, true).";\n";
		} elseif($this->_setting['type'] == 'serialize')
		{
			$data = serialize($datas);
		}
		//是否开启互斥锁
		if(get_config('cache','lock_ex'))
		{
			$file_size = file_put_contents($filepath.$filename, $data, LOCK_EX);
		} else
		{
			$file_size = file_put_contents($filepath.$filename, $data);
		}

		return $file_size ? $file_size : 'false';
	}

	/**
	 * 读取缓存
	 * @param	string	$name		缓存名称
	 * @param	array	$expire  	过期时间
	 * @param	string	$type		缓存类型data/view
	 * @param	string	$module		所属模型
	 * @return  mixed	$data		缓存数据
	 */
	public function get($name, $expire = 0, $type = 'data', $module = '',$app='')
	{
	    if (!empty($expire))
		{
		    $this->getSetting(array('expire'=>$expire));
		}
		if(empty($type)) $type = 'data';
		if(empty($module)) $module = app::getModuleName();
		if (!empty($app))
		{
		    $filepath = str_replace(DIR_ROOT, DIR_ROOT.$app.DS, DIR_CACHE.'caches_'.$module.DS.'caches_'.$type.DS);
			$filepath = str_replace(APPNAME.DS, '', $filepath);
			$filepath = str_replace('home'.DS, '', $filepath);
		}else
		{
    	    $filepath = DIR_CACHE.'caches_'.$module.DS.'caches_'.$type.DS;
		}
		$filename = $name.$this->_setting['suf'];
// 		dump($filepath.$filename);exit;
		if (!file_exists($filepath.$filename))
		{
			return false;
		}else
		{
			if($this->_setting['type'] == 'array')
			{
				$datas = @require($filepath.$filename);
			} elseif($this->_setting['type'] == 'serialize')
			{
				$datas = unserialize(file_get_contents($filepath.$filename));
			}
			$timeout = $datas['expire'];
			$data = $datas['data'];
			if ($this->isExpire($filepath.$filename,$timeout))
			{

				@unlink($filepath.$filename);
				return false;
			}

			return $data;
		}
	}

	/**
	 * 删除缓存
	 * @param	string	$name		缓存名称
	 * @param	array	$setting	缓存配置
	 * @param	string	$type		缓存类型 data view
	 * @param	string	$module		所属模型
	 * @return  bool
	 */
	public function delete($name, $setting = '', $type = 'data', $module = '')
	{
		$this->getSetting($setting);
		if(empty($type)) $type = 'data';
		if(empty($module)) $module = app::getModuleName();
		$filepath = DIR_CACHE.'caches_'.$module.'/caches_'.$type.'/';
		$filename = $name.$this->_setting['suf'];
		if(file_exists($filepath.$filename))
		{
			return @unlink($filepath.$filename) ? true : false;
		} else
		{
			return false;
		}
	}

	/**
	 * 清除缓存
	 */
	public function flush()
	{
		$cachepath = DIR_CACHE;

		return del_dir($cachepath)?true:false;
	}

	/**
	 * 和系统缓存配置对比获取自定义缓存配置
	 * @param	array	$setting	自定义缓存配置
	 * @return  array	$setting	缓存配置
	 */
	public function getSetting($setting = '')
	{
		if($setting)
		{
			$this->_setting = array_merge($this->_setting, $setting);
		}
	}

	/**
	 * 缓存文件是否过期
	 * @param sting $filepath  文件路径
	 * @param int    $expire   过期时间
	 */

	public function isExpire($filepath='',$expire=0)
	{
		if ($expire>0)
		{
		    if ($filepath != '' && file_exists($filepath))
		    {
			    $lasttime = filemtime($filepath);
			    $nowtime = time();
			    if ($nowtime>($lasttime+$expire))
			    {
			    	return true;
			    }else
			    {
			    	return false;
			    }
		    }

		}
	}


}
