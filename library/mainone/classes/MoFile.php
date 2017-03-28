<?php
/**
 * 文件工具类
 *
 * @author Lei Shaojin <leishaojin2012@163.com>
 * @copyright ©2012-2112 b2b.cn
 * @license http://www.izhancms.com/license/
 * @version $Id: MoFile.php 162 2013-09-13 03:50:36Z wangshaochen $
 * @package utility
 */
class MoFile
{
	/**
	 * 以读的方式打开文件，具有较强的平台移植性
	 *
	 * @var string
	 */
	const READ = 'rb';
	/**
	 * 以读写的方式打开文件，具有较强的平台移植性
	 *
	 * @var string
	 */
	const READWRITE = 'rb+';
	/**
	 * 以写的方式打开文件，具有较强的平台移植性
	 *
	 * @var string
	 */
	const WRITE = 'wb';
	/**
	 * 以读写的方式打开文件，具有较强的平台移植性
	 *
	 * @var string
	 */
	const WRITEREAD = 'wb+';
	/**
	 * 以追加写入方式打开文件，具有较强的平台移植性
	 *
	 * @var string
	 */
	const APPEND_WRITE = 'ab';
	/**
	 * 以追加读写入方式打开文件，具有较强的平台移植性
	 *
	 * @var string
	 */
	const APPEND_WRITEREAD = 'ab+';

	/**
	 * 删除文件
	 *
	 * @param string $file_name 文件名称
	 * @return boolean
	 */
	public static function del($file_name)
	{
		return @unlink($file_name);
	}

	/**
	 * 保存文件
	 *
	 * @param string $file_name          保存的文件名
	 * @param mixed $data               保存的数据
	 * @param boolean $is_build_return    是否组装保存的数据是return $params的格式，如果没有则以变量声明的方式保存,默认为true则以return的方式保存
	 * @param string $method            打开文件方式，默认为rb+的形式
	 * @param boolean $ifLock           是否对文件加锁，默认为true即加锁
	 */
	public static function savePhpData($file_name, $data, $is_build_return = true, $method = self::READWRITE, $ifLock = true)
	{
		$temp = "<?php\r\n ";
		if (!$is_build_return && is_array($data))
		{
			foreach ($data as $key => $value)
			{
				if (!preg_match('/^\w+$/', $key))
					continue;

				$temp .= "\$" . $key . " = " . self::varToString($value) . ";\r\n";
			}
			$temp .= "\r\n?>";
		}
		else
		{
			($is_build_return) && $temp .= " return ";
			$temp .= self::varToString($data) . ";\r\n?>";
		}
		return self::write($file_name, $temp, $method, $ifLock);
	}

	/**
	 * 写文件
	 *
	 * @param string $file_name 文件绝对路径
	 * @param string $data 数据
	 * @param string $method 读写模式,默认模式为rb+
	 * @param bool $ifLock 是否锁文件，默认为true即加锁
	 * @param bool $if_check_path 是否检查文件名中的“..”，默认为true即检查
	 * @param bool $if_chmod 是否将文件属性改为可读写,默认为true
	 * @return int 返回写入的字节数
	 */
	public static function write($file_name, $data, $method = self::READWRITE, $ifLock = true, $if_check_path = true, $if_chmod = true)
	{
		@touch($file_name);
        
        if (!file_exists($file_name)) {
            return false;
        }
        
		if (!$handle = fopen($file_name, $method)) {
			return false;
        }

		$ifLock && flock($handle, LOCK_EX);
		$write_check = fwrite($handle, $data);
		$method == self::READWRITE && ftruncate($handle, strlen($data));
		fclose($handle);
		$if_chmod && @chmod($file_name, 0777);
		return $write_check;
	}

	/**
	 * 读取文件
	 *
	 * @param string $file_name 文件绝对路径
	 * @param string $method 读取模式默认模式为rb
	 * @return string 从文件中读取的数据
	 */
	public static function read($file_name, $method = self::READ)
	{
		$data = '';
		if (!$handle = fopen($file_name, $method))
			return false;

		while (!feof($handle))
			$data .= fgets($handle, 4096);
		fclose($handle);
		return $data;
	}

	/**
	 * 读取文件
	 *
	 * @param string $file_name 文件绝对路径
	 * @param string $method 读取模式默认模式为rb
	 * @return string 从文件中读取的数据
	 */
	public static function readPhpData($file_name)
	{
		if(!self::isFile($file_name) || self::getSuffix($file_name) !== 'php')
			return array();

		$data = include $file_name;
		return $data;
	}

	/**
	 * @param string $file_name
	 * @return boolean
	 */
	public static function isFile($file_name)
	{
		return $file_name ? is_file($file_name) : false;
	}

	/**
	 * 取得文件信息
	 *
	 * @param string $file_name 文件名字
	 * @return array 文件信息
	 */
	public static function getInfo($file_name)
	{
		return self::isFile($file_name) ? stat($file_name) : array();
	}

	/**
	 * 取得文件后缀
	 *
	 * @param string $file_name 文件名称
	 * @return string
	 */
	public static function getSuffix($file_name)
	{
		if (false === ($rpos = strrpos($file_name, '.')))
			return '';

		return substr($file_name, $rpos + 1);
	}

	/**
	 * 将变量的值转换为字符串
	 *
	 * @param mixed $input   变量
	 * @param string $indent 缩进,默认为''
	 * @return string
	 */
	public static function varToString($input, $indent = '')
	{
		switch (gettype($input))
		{
			case 'string':
				return "'" . str_replace(array("\\", "'"), array("\\\\", "\\'"), $input) . "'";
			case 'array':
				$output = "array(\r\n";
				foreach ($input as $key => $value)
				{
					$output .= $indent . "\t" . self::varToString($key, $indent . "\t") . ' => ' . self::varToString(
						$value, $indent . "\t");
					$output .= ",\r\n";
				}
				$output .= $indent . ')';
				return $output;
			case 'boolean':
				return $input ? 'true' : 'false';
			case 'NULL':
				return 'NULL';
			case 'integer':
			case 'double':
			case 'float':
				return "'" . (string) $input . "'";
		}
		return 'NULL';
	}

	static function moveFile($fileUrl, $aimUrl, $overWrite = "0")
	{
		if (!file_exists($fileUrl))
		{
			return "1";
		}
		if (file_exists($aimUrl) && $overWrite = "0")
		{
			return "1";
		}
		elseif (file_exists($aimUrl) && $overWrite = "1")
		{
			self::unlinkFile($aimUrl);
		}
		$aimDir = dirname($aimUrl);
		self::createDir($aimDir);
		if(@rename($fileUrl, $aimUrl))
		{
			touch($aimUrl);
			return "0";
		}
		else
		{
			return "1";
		}
	}

	static function createDir($aimUrl) {
		$aimUrl = str_replace('', '/', $aimUrl);
		$aimDir = '';
		$arr = explode('/', $aimUrl);
		array_filter($arr);
		foreach ($arr as $str) {
			$aimDir .= $str . '/';
			if (!file_exists($aimDir)) {
				@mkdir($aimDir,0777);
			}
		}
		if(file_exists($aimDir))
		{
			return "0";
		}
		else
		{
			return "1";
		}
	}

	static function unlinkFile($aimUrl)
	{
		if (file_exists($aimUrl))
		{
			if(@unlink($aimUrl))
				return '1';
			else
				return '0';
		}
		else
		{
			return "1";
		}
	}
}