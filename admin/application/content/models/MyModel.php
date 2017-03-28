<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MymodelModel.php
 *
 * 模型类
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-11 下午5:14:14
 * @filename   MymodelModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class MyModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "model";//表名


	/**
	 * 添加模型后，建从表，添加字段
	 */
	function addModel($lastInsertId,$tablename)
	{
		$tablepre = $this->tablePrefix;
		$createsql = file_get_contents(DIR_BF_ROOT.'sql/createtable.sql');
		$createsql = str_replace('$tablename',$tablepre.$tablename, $createsql);
		$createsql = str_replace('$maintable',$tablepre.'maintable', $createsql);
		$createsql = str_replace('charset',C('common','char_set') == 'utf-8' ? 'utf8' : 'gbk',$createsql);
		$flag = $this->query($createsql);
		if(!$flag) return $flag;

		$filedsql = file_get_contents(DIR_BF_ROOT.'sql/field.sql');
		$filedsql = str_replace('lastInsertId',$lastInsertId,$filedsql);
		$filedsql = str_replace('$field',$tablepre.'field', $filedsql);
		return $this->query($filedsql);
	}

	/**
	 * 获取复制模型的信息
	 */
	public function getNewModelInfo($modelid)
	{
		$oldModelInfo = $this->where(array('id'=>$modelid))->getOne(); //获取模型信息
		$maxId = $this->field('max(`id`) as maxId')->getOne();
		$newId = $maxId['maxId'] + 1;
		$arr = array(
			'id' => $newId,
			'oldid' => $maxId['maxId'],
			'name' => $oldModelInfo['name'].strval($newId),
			'tablename' => $oldModelInfo['tablename'].strval($newId),
			'category_template' => $oldModelInfo['category_template'],
			'list_template' => $oldModelInfo['list_template'],
			'content_template' => $oldModelInfo['content_template'],
		);
		return $arr;
	}

	/**
	 * 复制模型字段
	 * @param int $oldId 旧模型ID
	 * @param int $newId 新模型ID
	 *
	 */
	public function copyFields($oldId,$newId)
	{
		$tem = array();
		$FieldInfo = D('FieldModel')->where(array('modelid'=>$oldId))->select();
		foreach($FieldInfo as $key=>$value)
		{
			unset($value['id']);
			$value['modelid'] = $newId;
			D('FieldModel')->create($value);
		}
	}
	/**
	 * 复制表
	 * @param int $oldId
	 * @param string $newTable
	 */
	public function copyTable($oldId,$newTable)
	{
		$oldtable = D('ContentModel')->getTable($oldId);
		$arr = $this->query("SHOW CREATE TABLE {$this->tablePrefix}{$oldtable}");
      	$sql = $arr[0]['Create Table'];
      	$sql = preg_replace("/CREATE TABLE `{$this->tablePrefix}{$oldtable}`/iU","CREATE TABLE `{$this->tablePrefix}{$newTable}`",$sql);
      	$this->query($sql);
	}

	/**
	 * 删除模型下面的内容
	 */
	public function delContent($mid)
	{

		$ids = array();
		$ids = M('maintable')->where($mid)
							->join($this->tablePrefix.'category as c on c.id = '.$this->tablePrefix.'maintable.categoryid')
							->field($this->tablePrefix.'maintable.id as id')
							->select();
		foreach($ids as $key=>$value)
		{
			$temids[] = $value['id'];
		}

		if(isset($temids))
		{
			$ids = implode($temids,',');
			$ids = M('maintable')->delete(array('in'=>array('id'=>$ids)));//删除主表内容
			//附表的表删除了 所以内容不用管了
		}
		return true;
	}
}