<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 数据库管理DAO层
 *
 * 文件修改记录：
 * <br>雷少进  2012-12-24 14:54 创建此文件
 * <br>雷少进 2012-12-24 14:54 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   TableModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class TableModel extends Model
{
	/**
	 * 表备份时每多少条 一个插入语句，
	 * 推荐值 100 300 500 800 1000
	 * @var number
	 */
	const INSERT_SIZE = 500;

	/**
	 * 是否只保留一份备份文件
	 *
	 * @var number
	 */
	const ONLY_BACKUP_FILE = true;

	/**
	 * 每次写入文件数据 块的大小，单位M
	 * 不易太大，太大会造成内存不够用而备份失败
	 * @var number
	 */
	const MEMORY_LIMIT = 0.1;

	/**
	 * 获取所有表状态信息
	 * @return array
	 */
	public function getTableInfo ()
	{
		$tables = $this -> getTables();//获取表信息
		$status = array();
		foreach ($tables as $key => $val )
		{
			$tmp = $this->getTableStatus(current($val));
			$tmp['Data_length'] = round(($tmp['Data_length']/1024)/1024,2);
			$status[] = $tmp;
		}
		return $status;
	}

	/**
	 * 备份单张表
	 *
	 * @param $table      表名
	 * @param $dirname    备份路径
	 * @param $isCompress 是否压缩  暂不支持压缩
	 * @return bool
	 */
	public function backupTable($table, $dirname=null,$is_compress=false)
	{
		$is_compress = false;//暂不支持压缩
		//先把表结构写入文件
		$this -> trueTableName = $table;
		$create_sql = $this -> getCreateTableStr($table);
		if($dirname === null)
		{
			$dirname = $this -> getSavePath();//D:\wamp\www\mocms\admin\data\backupsql
		}
		$create_sql = $this->getBackupSeparator() . $create_sql . $this->getBackupSeparator();//创建表语句
		$file_name = self::ONLY_BACKUP_FILE ? $table : $this -> getRandFileName($table);//保存的文件名
		$dir_name = $this -> getTableDirName($table);
		$this->saveData($dirname.'/'.$dir_name,$file_name,$create_sql, $is_compress);//先写进去表结构

		//获取表信息
		$table_statu = $this -> getTableStatus($table);

		if(!$table_statu['Rows'])
			return true;

		//循环往文件里写入数据
		$data_size = ceil($table_statu['Data_length']/1048576);
		$query_number = ceil($data_size/self::MEMORY_LIMIT);
		$query_size = ceil($table_statu['Rows']/$query_number);//每次只能查询的条数
		$query_pages = ceil($table_statu['Rows']/$query_size);
		for ($i=1;$i<=$query_pages;$i++)
		{
			$data_str = $this -> getTableData($table,($i-1)*$query_size,$query_size);
			$this->saveData($dirname.'/tb_'.$table,$file_name,$data_str, $is_compress,MoFile::APPEND_WRITEREAD);
		}
		return true;
	}

	/**
	 * 整站备份数据库
	 *
	 * @param $table      表名
	 * @param $dirname    备份路径
	 * @param $isCompress 是否压缩  暂不支持压缩
	 * @return bool
	 */
	function backupDataBase ($table,$flag=0,$file_name,$dirname=null,$is_compress=false)
	{
		$is_compress = false;//暂不支持压缩
		$this -> trueTableName = $table;

		$create_sql = $this -> getCreateTableStr($table);
		if($dirname === null)
			$dirname = $this -> getSavePath();//D:\wamp\www\mocms\admin\data\backupsql

		$dir_name = $this -> getDbDirName('db');
		$create_sql = $this->getBackupSeparator() . $create_sql . $this->getBackupSeparator();
		$this->saveData($dirname.'/'.$dir_name,$file_name,$create_sql, $is_compress,$flag ? 'ab+' : 'rb+');//先写进去表结构

		//获取表信息
		$table_statu = $this -> getTableStatus($table);
		if(!$table_statu['Rows'])
			return true;

		//循环往文件里写入数据
		$data_size = ceil($table_statu['Data_length']/1048576);
		$query_number = ceil($data_size/self::MEMORY_LIMIT);
		$query_size = ceil($table_statu['Rows']/$query_number);//每次只能查询的条数
		$query_pages = ceil($table_statu['Rows']/$query_size);
		for ($i=1;$i<=$query_pages;$i++)
		{
			$data_str = $this -> getTableData($table,($i-1)*$query_size,$query_size);
			$this->saveData($dirname . '/db_database',$file_name, $data_str, $is_compress,MoFile::APPEND_WRITEREAD);
		}
		return true;
	}

	/**
	 * 获取表数据
	 *
	 * @param $table      表名
	 * @param $dirname    备份路径
	 * @param $isCompress 是否压缩
	 * @return bool
	 */
	public function getTableData ($table,$from,$size,$insert_size=self::INSERT_SIZE)
	{
		$data = $this -> findLimit(null,false,null,$from,$size);
		//获取表中字段  拼接INSERT 语句
		$fields = '(`'.implode('`,`',array_keys($data[0])).'`)';
		$data_str = '';
		$_data_str = 'INSERT INTO `'.$table.'` '.$fields.' VALUES ';
		$tmp=array();
		foreach ($data as $key => $val )
		{
			$tmp[] = '(\''.implode("','",array_values($val)).'\')';
		}

		//分页拼接数据
		$page_size = $insert_size;
		$page = 1;
		$pages = ceil(count($tmp)/$page_size);
		$_tmp = array();
		for ($i=1;$i<=$pages;$i++)
		{
			$_tmp[] = array_slice($tmp,($i-1)*$page_size,$page_size);
		}
		foreach ($_tmp as $key => $val )
		{
			$data_str .= $_data_str.implode(",",$val).';'."\n".$this->getBackupSeparator();
		}
		return $data_str;
	}

	/**
	 * 获取表结构字符串
	 *
	 * @param $table      表名
	 * @return string
	 */
	public function getCreateTableStr ($table)
	{
		$table_structure = $this -> getCreateTable($table);//获取表结构
		$create_sql = '';
		if(!empty($table_structure))
		{
			$create_sql .= 'DROP TABLE IF EXISTS `'.$table.'`;'."\n".$this -> getBackupSeparator();
			$table_structure['Create Table'] = str_replace($table_structure['Table'], $table, $table_structure['Create Table']);
			$create_sql .= $table_structure['Create Table'] . ";\n";
		}
		return $create_sql;
	}

	/**
	 * 保存数据到文件
	 *
	 * @param $file_path
	 * @param $data
	 * @param $is_compress
	 * @return bool
	 */
	public function saveData($file_path,$file_name,$data, $is_compress = false,$method = MoFile::READWRITE)
	{
		if (!trim($data) || !$file_path) return false;
		MoFolder::mkRecur($file_path);//创建保存目录
		$file_path = $file_path.'/'.$file_name.'.sql';
		if ($is_compress && $this->_checkZlib())
		{
			$zip_service = new MoZip();
			$zip_service->init();
			$zip_service->addFile($data, $file_name.'.sql');
			$data = $zip_service->getCompressedFile();
			$zipName = $file_name.'.zip';
			$file_path = dirname($file_path) . '/' . $zipName;
		}
		MoFile::write($file_path,$data,$method);
		return true;
	}

	/**
	 * 备份文件提示
	 *
	 * @return string
	 */
	public function getBackupTip()
	{
		return "--\n-- MOCMS SQL Dump\n-- version:" . app::version() . "\n-- time: " . date('Y-m-d H:i') . "\n-- MOCMS: ".app::powerby()."\n-- --------------------------------------------------------\n\n\n";
	}

	/**
	 * 备份分隔符 恢复数据库时的读取标记依据
	 *
	 * @return string
	 */
	public function getBackupSeparator()
	{
		return "/*_mocms_*/\n";
	}

	/**
	 * zlib扩展是否开启
	 *
	 * @return bool
	 */
	private function _checkZlib()
	{
		return (extension_loaded('zlib') && function_exists('gzcompress')) ? true : false;
	}

	/**
	 * 生成随机文件名
	 *
	 * @param $file_name
	 * @return string
	 */
	function getRandFileName ($file_name)
	{
		return $file_name.'_'.date('YmdHis').'_'.rand(100,999);
	}

	/**
	 * 生成单个表存放目录
	 *
	 * @param $file_name
	 * @return string
	 */
	function getTableDirName ($table)
	{
		return 'tb_'.$table;
	}

	/**
	 * 生成数据库存放目录
	 *
	 * @param $file_name
	 * @return string
	 */
	function getDbDirName ($pref='')
	{
		return $pref ? $pref.'_database' : 'database';
	}

	/**
	 * 获取总的存放目录
	 *
	 * @param $file_name
	 * @return string
	 */
	function getSavePath ()
	{
		return DIR_DATA.'backupsql';
	}

	/**
	 * 获取所有备份文件列表
	 *
	 * @param $file_name
	 * @return string
	 */
	function getBackupFileList ()
	{
		$file_dir = $this -> getSavePath();//D:\wamp\www\mocms\admin\data\backupsql
		$dir_list = MoFolder::read($file_dir,2);//所有子文件夹列表
		$tmp = array();
		if($dir_list)
		{
			foreach ($dir_list as $val )
			{
				$file_list = MoFolder::read($file_dir.'/'.$val,1);
				if($file_list)
				{
					foreach ($file_list as $v )
					{
						$tmp[] = array(
							'file_name'=>$v,
							'filec_time'=>date('Y-m-d H:i:s',@filectime($file_dir.'/'.$val.'/'.$v)),
							'file_size'=>ceil(@filesize($file_dir.'/'.$val.'/'.$v)/1024),
							'file_dir'=>$val
						);
					}
				}
			}
		}
		return $tmp;
	}

	/**
	 * 恢复单个表  逐行读取进行恢复 保证大数据量恢复成功
	 *
	 * @param $file_name
	 * @return bool
	 */
	function recoverData ($file_name)
	{
		if(!$file_name)
			return false;

		$save_path = $this -> getSavePath();
		$file_path = implode('/',array($save_path,str_replace('@',DIRECTORY_SEPARATOR,$file_name)));
		if( filesize($file_path) > 0 )
        {
			$separator = trim($this -> getBackupSeparator());
            $fp = @fopen($file_path, 'r');
			$tmp = '';
            while(!feof($fp))
            {
                $line = trim(fgets($fp, 1024*1024));//逐行读取进行恢复
                if($line==$separator)
				{
					if(trim($tmp) == '')
					{
						continue;
					}
					else
					{
						$this -> query($tmp);
						$tmp='';
					}
					$line = '';
				}
				$tmp .=$line;
            }
            fclose($fp);
			return true;
        }
	}

	/**
	 * 删除表
	 *
	 * @param $file_name
	 * @return bool
	 */
	function deleteTable ($file_name)
	{
		if(!$file_name)
			return false;

		$save_path = $this -> getSavePath();
		$file_path = implode('/',array($save_path,str_replace('@',DIRECTORY_SEPARATOR,$file_name)));
		MoFile::del($file_path);
		MoFolder::rm(dirname($file_path));
		return true;
	}
}