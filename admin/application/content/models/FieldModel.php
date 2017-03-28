<?php 
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * FieldModel.php
 * 
 * 字段管理模型类
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
class FieldModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "field";//表名
	
	public function tabaleAddField($modelid , $name,$dbtype ,$maxlength,$defaultvalue,$fieldtype/*,$isempty,$isunique*/)
	{
		if(!$maxlength) $maxlength = 255;
		$maxlength = min($maxlength, 255);
		//$isempty = $isempty == 1 ? 'NOT NULL' : 'NULL';
		//$isunique = $isempty == 1 ? 'UNIQUE' : '';
		$tablename = $this->getTableName($modelid);
		if($dbtype == 'text') {$defaultvalue='';$maxlength=0;}		
		if($dbtype == 'varchar'){$maxlength=255;}
		if($dbtype == 'int' || $dbtype=='float'){$maxlength=11;$defaultvalue=0;}
		//$sql = "ALTER TABLE `$tablename` ADD `$name` $dbtype( $maxlength ) $isempty DEFAULT '$defaultvalue'";
		if($fieldtype=='checkbox'||$fieldtype=='redio'||$fieldtype=='select'||$fieldtype=='linkage'||$fieldtype=='image'||$fieldtype=='file'||$fieldtype=='images'||$fieldtype=='files')
		{$defaultvalue='';}
		$sql = "ALTER TABLE `$tablename` ADD `$name` $dbtype( $maxlength )  DEFAULT '$defaultvalue'";
		return $this->query($sql);
	}
	
	public function tabaleupdateField($modelid , $name,$newname,$dbtype ,$maxlength,$defaultvalue,$fieldtype)
	{
		if(!$maxlength) $maxlength = 255;
		$maxlength = min($maxlength, 255);
		$tablename = $this->getTableName($modelid);
		if($dbtype == 'text') {$defaultvalue='';$maxlength=0;}		
		if($dbtype == 'varchar'){$maxlength=255;}
		if($dbtype == 'int' || $dbtype=='float'){$maxlength=11;$defaultvalue=0;}
		if($fieldtype=='checkbox'||$fieldtype=='redio'||$fieldtype=='select'||$fieldtype=='linkage'||$fieldtype=='image'||$fieldtype=='file'||$fieldtype=='images'||$fieldtype=='files')
		{$defaultvalue='';}
		$sql = "ALTER TABLE `$tablename` CHANGE `$name` `$newname` $dbtype( $maxlength )  DEFAULT '$defaultvalue'";		
		return $this->query($sql);
	}
	
	/**
	 * 通过模型ID获取表名
	 */
	public function getTableName($modelid , $tablePrefix=true)
	{
		$modelinfo = M('Model')->where(array('id'=>$modelid))->field('tablename')->getOne();
		return $tablePrefix == true ? $this->tablePrefix . $modelinfo['tablename'] : $modelinfo['tablename'];
	}
	
	/**
	 *删除列
	 */
	public function deleteTableField($modelid , $field)
	{
		$tablename = $this->getTableName($modelid,false);
		$fields = $this->getFields($tablename);
		$flag = true;
		if(is_array($field))
		{
			foreach($fields as $key => $value)
			{
				$arr[]=$value['Field'];
			}
			foreach($field as $key => $value)
			{
				if(in_array($value , $arr))
				{
					$flag = $this->query("ALTER TABLE ".$this->tablePrefix . $tablename." DROP COLUMN `$value`;");
				}
				if(!$flag) return $flag;
			}
			return $flag;
		}
		else
		{
			return $this->query("ALTER TABLE ".$this->tablePrefix . $tablename." DROP COLUMN `$field`;"); 
		}
		
	}

	/*检查字段值唯一*/
	public function checkUnique($field,$value='',$modelid='')
	{
		$result = M('maintable')->field($this->tablePrefix.'maintable.id')->where(array($field=>$value))
				->join($this->tablePrefix.'category on model='.$modelid )
				->getOne();
		if(!empty($result))
		{
			return '1';
		}
		else
		{
			return '0';
		}
	}
}