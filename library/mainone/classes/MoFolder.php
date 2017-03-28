<?php
/**
 * 文件夹工具类
 *
 * @author Lei Shaojin <leishaojin2012@163.com>
 * @copyright ©2012-2112 b2b.cn
 * @license http://www.izhancms.com/license/
 * @version $Id: MoFolder.php 10 2013-08-09 07:32:02Z zhoulifeng $
 * @package utility
 */
class MoFolder
{
	const READ_ALL = 0;
	const READ_FILE = 1;
	const READ_DIR = 2;

	/**
	 * 获取文件列表
	 *
	 * @param string $dir
	 * @param boolean $mode 只读取文件列表,不包含文件夹
	 * @return array
	 */
	public static function read($dir, $mode = self::READ_ALL , $filter = array())
	{
		if (!$handle = @opendir($dir))
			return array();

		$files = array();
		while (false !== ($file = @readdir($handle)))
		{
			if ('.' === $file || '..' === $file || in_array($file,$filter))
				continue;

			if ($mode == self::READ_DIR)
			{
				if (self::isDir($dir . '/' . $file))
					$files[] = $file;
			}
			elseif ($mode == self::READ_FILE)
			{
				if (@is_file($dir . '/' . $file))
					$files[] = $file;
			}
			else
			{
				$files[] = $file;
			}
		}
		@closedir($handle);
		return $files;
	}

	/**
	 * 删除目录
	 *
	 * @param string $dir
	 * @param boolean $f 是否强制删除
	 * @return boolean
	 */
	public static function rm($dir, $f = false)
	{
		return $f ? self::clearRecur($dir, true) : @rmdir($dir);
	}

	/**
	 * 递归的删除目录
	 *
	 * @param string $dir 目录
	 * @param Boolean $del_folder 是否删除目录
	 */
	public static function clearRecur($dir, $del_folder = false)
	{
		if (!self::isDir($dir))
			return false;

		if (!$handle = @opendir($dir))
			return false;

		while (false !== ($file = readdir($handle)))
		{
			if ('.' === $file || '..' === $file)
				continue;
			$_path = $dir . '/' . $file;
			if (self::isDir($_path))
			{
				self::clearRecur($_path, $del_folder);
			}
			elseif (is_file($_path))
			{
				@unlink($_path);
			}
		}
		@closedir($handle);
		$del_folder && @rmdir($dir);
		return true;
	}

	/**
	 * 删除指定目录下的文件 不包含子文件夹里的文件 若存在子目录则本方法删不成功本目录
	 *
	 * @param string  $dir 目录
	 * @param boolean $del_folder 是否删除目录
	 * @return boolean
	 */
	public static function clear($dir, $del_folder = false)
	{
		if (!self::isDir($dir))
			return false;

		if (!$handle = @opendir($dir))
			return false;

		while (false !== ($file = readdir($handle)))
		{
			if ('.' === $file[0] || '..' === $file[0])
				continue;

			$filename = $dir . '/' . $file;
			if (is_file($filename))
				@unlink($filename);
		}
		@closedir($handle);
		$del_folder && @rmdir($dir);
		return true;
	}

	/**
	 * 判断输入是否为目录
	 *
	 * @param string $dir
	 * @return boolean
	 */
	public static function isDir($dir)
	{
		return $dir ? is_dir($dir) : false;
	}

	/**
	 * 取得目录信息
	 *
	 * @param string $dir 目录路径
	 * @return array
	 */
	public static function getInfo($dir)
	{
		return self::isDir($dir) ? stat($dir) : array();
	}

	/**
	 * 创建目录
	 *
	 * @param string $path 目录路径
	 * @param int $permissions 权限
	 * @return boolean
	 */
	public static function mk($path, $permissions = 0777)
	{
		return @mkdir($path, $permissions);
	}

	/**
	 * 获取目录下以某某字符串开头的文件
	 *
	 * @param string $path 目录路径
	 * @param int $permissions 权限
	 * @return boolean
	 */
	public static function readFileByPrefix($path, $prefix='',$ext='html',$mode = self::READ_FILE)
	{
		$file=array();
		$files = self::read($path,$mode);
		if($files)
		{
			foreach ($files as $key => $val )
			{
				if(preg_match('/^'.$prefix.'(.*)\.'.$ext.'$/',$val))
					$file[] = $val;
			}
		}
		return $file;
	}

	/**
	 * 递归的创建目录
	 *
	 * @param string $path 目录路径
	 * @param int $permissions 权限
	 * @return boolean
	 */
	public static function mkRecur($path, $permissions = 0777)
	{
		if (is_dir($path))
			return true;

		$_path = dirname($path);
		if ($_path !== $path)
			self::mkRecur($_path, $permissions);

		return self::mk($path, $permissions);
	}

	//扫描目录
	public static function recurFolder($pathname,$guolv=array('__example01.php','__example02.php','__example03.php'))
	{
		$result=array();
		$temp=array();
		//检查目录是否有效和可读
		if(!is_dir($pathname) || !is_readable($pathname))
		return array();
		//得到目录下的所有文件夹
		$allfiles=scandir($pathname);
		foreach($allfiles as $key => $filename)
		{
			//如果是“.”或者“..”的话则略过
			if(in_array($filename,array('.','..'))) continue;

			if(count($guolv)>0)
			{
				if(in_array($filename,$guolv)) continue;
			}

			//得到文件完整名字
			$fullname =$pathname . "/" .$filename;
			//如果该文件是目录的话，递归调用recurdir
			$temp[]=$fullname;
			if(is_dir($fullname))
			{
				$nowpath=explode("/",$fullname);
				if(count($guolv)>0)
				{
					if(in_array($nowpath[count($nowpath)-1],$guolv))
						continue;
				}
				$result[$filename] = self::recurFolder($fullname);
			}
		}
		//最后把临时数组中的内容添加到结果数组，确保目录在前，文件在后
		foreach($temp as $f){
			$result[]=$f;
		}
		return $result;
	}

	//获取所有文件
	public static function mergeFileList($ary,$modo=self::READ_ALL)
	{
		$lst = array();
		foreach( array_keys($ary) as $k )
		{
			$v = $ary[$k];
			if (is_array($v))
				$lst = array_merge( $lst, self::mergeFileList($v));
			else
				$lst[] = $v;
		}
		if($modo == self::READ_FILE)
		{
			foreach ($lst as $key => $val )
			{
				if(!is_file($val))
					unset($lst[$key]);
			}
		}
		else if ($modo == self::READ_DIR)
		{
			foreach ($lst as $key => $val )
			{
				if(!is_dir($val))
					unset($lst[$key]);
			}
		}
		return $lst;
	}

	/**
	 * 拷贝目录
	 * @param $source 源文件目录 末尾带 /
	 * @param $target 目标目录 末尾带 /
	 * @param $cover  文件存在是否覆盖
	 * @return null
	 */
	public static function copyFolder($source,$target,$cover=true,$modo=self::READ_ALL)
	{
		//转换路径到统一格式
		$source = str_replace(array('/','\\'),'/',$source);
		$target = str_replace(array('/','\\'),'/',$target);
		if(!is_dir($target)) self::mkRecur($target);

		//获取源文件数组包含目录
		$file_list = self::mergeFileList(self::recurFolder(rtrim($source,'/')),$modo);

		$fail = array();//拷贝失败的文件列表

		//循环拷贝
		foreach ($file_list as $val )
		{
			$target_file = str_replace($source,$target,$val);//目标文件
			if(file_exists($target_file))
			{
				if(is_file($target_file) && $cover)
				{
					if(!copy($val,$target_file))
						return false;
				}
				else
					self::mkRecur($target_file);
			}
			else
			{
				if(is_file($val))
				{
					self::mkRecur(dirname($target_file));
					if(!copy($val,$target_file))
						return false;
				}
				else
					self::mkRecur($target_file);
			}
		}
		return true;
	}

	/**
	 * 拷贝文件
	 * @param
	 * @return
	 */
	public static function copyFile ($source,$source_dir,$target,$cover=true)
	{
		if(!is_array($source) || empty($source_dir) || empty($target)) return false;
		//转换路径到统一格式
		$source_dir = str_replace(array('/','\\'),'/',$source_dir);
		$target = str_replace(array('/','\\'),'/',$target);
		if(!is_dir($target)) self::mkRecur($target);

		foreach ($source as $val)
		{
			$val = str_replace(array('/','\\'),'/',$val);
			if(file_exists($val)) //要备份的文件存在
			{
				$target_file = str_replace($source_dir,$target,$val);//目标文件
				if(is_file($val))
				{
					if(!is_dir($target_file))
						self::mkRecur(dirname($target_file));

					if($cover)
						@copy($val,$target_file);
				}
				else
				{
					self::mkRecur($target_file);
				}
			}
		}
	}
}