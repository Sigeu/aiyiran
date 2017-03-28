<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * Load.php
 *
 * 加载类文件的工具类
 *
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-19 下午2:40:56
 * @filename   Load.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 */

if (!defined('IN_MAINONE')) {
	exit('No Permission');
}
class Load
{
	public static  function load_class($classname,$path=NULL,$initialize=1)
	{
		static $classes = array();
		$name = false;
		//检查$classname(类或接口)是否已定义
		if (class_exists($classname, false) || interface_exists($classname, false))
		{
            return;
        }
		//检查$path是否正确

        if ((null !== $path) && !is_string($path) && !is_array($path)) {
        	return ;
        }

        if(null == $path){
        	$path = DIR_BF_ROOT;
        }
		$file_path = str_replace(DS.DS, DS, $path.DS.$classname.'.php');
        if (file_exists($file_path))
        {
        	$name = $classname;
        	require ($file_path);
			if ($initialize) {
				$classes[$classname] = new $name();
			} else {
				$classes[$classname] = true;
			}
			return $classes[$classname];
        } else {
        	return false;
        }
	}

	public static function loadModel($name='',$module='',$app='')
	{
		if (!empty($module))
		{
			$moduleName = strtolower($module);
		}else
		{
			$moduleName= app::getModuleName();
		}
		if (!empty($app))
		{
    		$app = strtolower($app);
			$dir_root = str_replace(APPNAME.DS, '', DIR_ROOT);
			if($app=='home')
			{
				$path =   $dir_root.'application'.DS.$moduleName.DS.'models'.DS;
			}
			else
			{
				$path = $dir_root.$app.DS.'application'.DS.$moduleName.DS.'models'.DS;
			}

		}else
		{
			$path = DIR_MODEL.$moduleName.DS.'models'.DS;
		}
		if (empty($name))
		{
			$name = ucfirst($moduleName);
		}else
		{
			$name = str_ireplace('model','',$name);
		}
		$modelname = $name.'Model';
		return self::load_class($modelname,$path);

	}

	public static  function load_tag($tagname,$path=DIR_TAG,$initialize=1)
	{
		static $tagclasses = array();
		$name = false;

		//检查$classname(类或接口)是否已定义

		//检查$path是否正确

		if ((null !== $path) && !is_string($path) && !is_array($path)) {
			return ;
		}

		$file_path = str_replace(DS.DS, DS, $path.DS.$tagname.'.lib.php');
		if (file_exists($file_path))
		{
			$name = $tagname;
			require_once ($file_path);
			if ($initialize) {
				$classes[$tagname] = new $name();

			} else {
				$classes[$tagname] = true;
			}
			return $classes[$tagname];
		} else {
			return false;
		}
	}
}