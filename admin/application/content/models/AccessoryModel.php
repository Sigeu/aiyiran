<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 附件表
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-26 11:50 创建此文件
 * <br>雷少进  2013-01-26 11:50 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   AccessoryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class AccessoryModel extends Model
{
	public $pk = 'id';//主键
	public $tableName = 'accessory';//表名

	/**
	 * 保存附件
	 */
	function saveAccessory ()
	{
			/*
			Array
			(
				[name] => 345345
				[mediatype] => 1
				[accessory] => Array
					(
						[1] => Array
							(
								[selfname] => 37d3d539b6003af35c991fc0352ac65c1038b66b.jpg
								[path] => /static/uploadfile/temp/{F5F5CDB5-51A8-14A9-CF5F-2F65F53F983E}.jpg
								[isimage] => 1
								[iswatermark] => 0
								[size] => 177116
							)
						[2] => Array
							(
								[selfname] => 384x209-002.jpg
								[path] => /static/uploadfile/temp/{0DC47D9E-B933-7408-C0B7-A78BF700D889}.jpg
								[isimage] => 1
								[iswatermark] => 0
								[size] => 12520
							)
					)
			)
			*/

		//基础数据
		$name = isset($_POST['name']) ? $_POST['name'] : '' ;                    //附件前缀名，用户用户区分一组附件，相当于分组
		$mediatype = isset($_POST['mediatype']) ? $_POST['mediatype'] : 1 ;      //附件类型
		$accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;//附件信息，二维数组

		//没传文件返回false
		if(empty($accessory))
			return false;

		//上传图片并入库
		$upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'accessory','time_name'=>true));
		foreach ($upload_info as $key => $val )
		{
			$info = array(
				'name'        =>$name,
				'selfname'    =>$val['selfname'],
				'trends_path' =>$val['trends_path'],
				'path'        =>$val['path'],
				'width'       =>$val['width'],
				'height'      =>$val['height'],
				'size'        =>$val['size'],
				'mediatype'   =>$mediatype,
				'extension'   =>$val['extension'],
				'created'     =>time()
			);
			$this -> create($info);
			admin_log('附件管理', '新增附件：'.$val['selfname']);
		}
		return true;
	}

	/**
	 * 附件管理分页列表
	 */
    public function getAccessoryList ($param = array())
    {
		$search = array();
		if(isset($param['search']))
		{
			$search = $param['search'];
		}
		$sql = 'SELECT *,concat(name,\'_\',selfname) AS ext_name FROM `'.$this -> trueTableName.'` WHERE 1 ';
		if(isset($search['name']) && $search['name'])
		{
			$sql .= 'AND (concat(name,\'_\',selfname) LIKE \'%'.$this -> __val_escape($search['name']).'%\') ';
		}
		if(isset($search['type']) && $search['type'])
		{
			$sql .= 'AND (`mediatype` = '.$search['type'].') ';
		}
		if(isset($search['start']) && $search['start'])
		{
			$sql .= 'AND (`created` >= '.strtotime($search['start'].' 00:00:00').') ';
		}
		if(isset($search['end']) && $search['end'])
		{
			$sql .= 'AND (`created` <= '.strtotime($search['end'].' 23:59:59').') ';
		}
		$sql .= 'ORDER BY `created` DESC';
		return $this -> getPageList(array('sql'=>$sql,'pagesize'=>20));
    }

	/**
	 * 删除附件
	 */
	function deleteAccessory ($ids)
	{
		$delinfo = $this -> findAll(array('in'=>array('id'=>$ids)),false,'name,path,selfname');
		$this -> delete(array('in'=>array('id'=>$ids)));
		$path = getFileSavePath('accessory');
		$path = $path['base'];
		foreach ($delinfo as $key => $val )
		{
			$_name = !empty($val['name']) ? $val['name'].'_'.$val['selfname'] : $val['selfname'];
			admin_log('附件管理', '删除了附件：'.$_name);
			@unlink($path.DIRECTORY_SEPARATOR.$val['path']);
		}
		return true;
	}

	/**
	 * 获取系统上传临时目录的文件数目或者文件列表
	 * @param $model amount(返回符合一定条件的的文件总数)，file(返回符合一定过期条件的文件列表)
	 * @return int or array()
	 */
	function getTempFile ($model='amount')
	{
		$pass_time = 7200;//文件上传时间大于7200秒的认为是垃圾文件，即可删除的文件
		$temp_path = getTempPath();
		$folder = MoFolder::recurFolder($temp_path);
		$file = MoFolder::mergeFileList($folder);
		foreach ($file as $key => $val )
		{
			if (file_exists($val) && ((time() - filemtime($val)) <= $pass_time))
				unset($file[$key]);
		}
		switch ($model)
		{
			case 'amount':
				return count($file);
				break;
			case 'file':
				return $file;
				break;
			default:
				return count($file);
				break;
		}
	}

	/**
	 * 删除上传临时文件方法
	 */
	function clearTempFile ()
	{
		$file = $this -> getTempFile('file');
		foreach ($file as $key => $val )
		{
			MoFile::del($val);
		}
		return true;
	}

	/**
	 * 自动清理临时文件
	 */
	function autoClearTempFile ($odds = 30)
	{
		//20%的概率自动清理临时文件
		if(percentDoAction($odds))
		{
			$this -> clearTempFile();
		}
	}
}