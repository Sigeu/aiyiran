<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 * 
 * 文件修改记录：
 * <br>申静  2013-3-26 下午2:23:05 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-3-26 下午2:23:05

 * @filename   FormModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: FormModel.php 808 2013-11-21 03:13:14Z wangrui $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
class FormModel extends Model
{
	public $pk = "id";
	public $tableName = "mix_model";
	
	/**
	 * @param $tableName string //需要创建的表名
	 */
	
	public function createTable($tableName,$message=false)
	{
		$ad_sql = '';
		$config = get_config('database','default');
		
		if( $message == true ) {
			
			$ad_sql = " title varchar(100)  NOT NULL,username varchar(50) NOT NULL,mess_infor text NOT NULL,";
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS `".$config['prefix'].$tableName."`(
				id int(11)  NOT NULL AUTO_INCREMENT,
				model_id int(11)  NOT NULL,".$ad_sql."
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		
		$result = $this->query($sql);
		return $result;
	}
	
	/**
	 * 表单添加字段时修改表结构
	 * @param $modelid       int     表单id
	 * @param $name          string  数据库字段名 
	 * @param $dbtype        string  数据库字段类型
	 * @param $maxlength     int     数据库字段最大值
	 * @param $defaultvalue  string  字段默认值
	 * @param $type          string  表单类别 “member” 会员表单，'message'留言板表单
	 */
	public function alterTable($modelid,$name,$dbtype ,$maxlength,$defaultvalue,$type)
	{

        $add_table = $this->tablePrefix.$type."_".$modelid;
 
        $maxlength = $maxlength ? $maxlength : 255;
        
        if (in_array($dbtype,array('float','int')))
        {
            $dbtype="varchar";
        	$maxlength = 11;
        	$defaultvalue = $defaultvalue ? intval($defaultvalue) : "''";
        	
        } else if ($dbtype == 'textarea') {
        		
        	$dbtype="text";
        	$defaultvalue = "''";
        	
        } else {
        	
        	$dbtype = "varchar";
        	$maxlength=255;
        	$defaultvalue = "'".$defaultvalue."'";
        }
        
        if($type=='checkbox'||$type=='redio'||$type=='select'||$type=='linkage'||$type=='image'||$type=='file'||$type=='images'||$type=='files')
        {
        	$defaultvalue='';
        }
        
        $sql = "ALTER TABLE `$add_table` ADD `$name` $dbtype($maxlength) DEFAULT $defaultvalue";

        $result = $this->query($sql);
        return $result;
	}
	
	/**
	 * 表单修改字段时修改表结构
	 * @param $modelid       int 表单id
	 * @param $name          string 数据库字段名 
	 * @param $newname       string 需要改成的字段名
	 * @param $dbtype        string 数据库字段类型
	 * @param $maxlength     int 数据库字段最大值
	 * @param $defaultvalue  string 字段默认值
	 * @param $type          string  表单类别 “member” 会员表单，'message'留言板表单
	 */
	public function updateTable($modelid,$name,$newname,$dbtype ,$maxlength,$defaultvalue,$type) 
	{
		
		$table = $this->tablePrefix.$type."_".$modelid;
		
		$maxlength = $maxlength ? $maxlength : 255;
		
		if (in_array($dbtype,array('float','int')))
		{
			$maxlength = 11;
			$defaultvalue = intval($defaultvalue);
		} else if ($dbtype == 'textarea'){
		
			$dbtype="text";
			$defaultvalue = "";
		} else {
			 
			$dbtype = "varchar";
			$defaultvalue = $defaultvalue;
		}
		
		$sql = "ALTER TABLE `$table` CHANGE `$name` `$newname` $dbtype( $maxlength )  DEFAULT '$defaultvalue'";

		$result = $this->query($sql);
		return $result;
	}
	/**
	 * 留言板添加默认属性
	 */
	public function addDefAttr($id) {
		$sql = "INSERT INTO ".$this->tablePrefix."attribute (`id`, `name`, `dataname`, `fieldtype`, `minval`, `maxval`, `ismain`, `uniqueness`, `isnessary`,`created`, `state`,`modelid`)
				VALUES('', '标题', 'title', 'text', '1', '100', '1', '1', '1', ".time().", '1',".$id."),
				('', '提交人', 'username', 'text', '1', '100', '1', '2', '1', ".time().", '1',".$id."),
				('', '内容', 'mess_infor', 'textarea', '', '', '1', '2', '1', ".time().", '1',".$id.")";

		return $this->query($sql);
	}
	/**
	 * 删除表的列
	 * @param $modelid int   表单id
	 * @param $fieldid string   需要删除的列字段
	 */
	public function deleteClumn($modelid,$fieldid) 
	{
		
		$tabName = $this->getTableName($modelid);//获取需要删除的表名的字段
		$fieldName = $this->deleField($modelid, $fieldid);
		
		foreach ($fieldName as $fk=>$fv) {
			
			$this->query("ALTER TABLE ". $tabName." DROP COLUMN `".$fv['dataname']."`");
		}
	}
	
	/**
	 * 获取需要删除字段的表名
	 * @param int $modelid  表单id
	 * @return $tabName string 表名
	 */
	public function getTableName($modelid)
	{
		$tabName = '';
		if (strpos($modelid,','))
		{
			$table = M("mixModel")->field('tablename')->select(array('where'=>array('in'=>array('id'=>$modelid))));
			foreach ($table as $tk => $tv)
			{
				$tabName .= "`".$this->tablePrefix.$tv['tablename']."`,";
			}
			
			$tabName = substr($tabName,0,-1);
			
		} else {
			
			$table = M("mixModel")->where(array('id'=>$modelid))->field('tablename')->getOne();
			$tabName = "`".$this->tablePrefix . $table['tablename']."`";
		}
		
		return $tabName;
	}
	
	/**
	 * 获取需要删除的表字段名
	 * @param $modelid int      表单id
	 * @param $fieldid string   需要删除的表字段id（多个用逗号分隔）
	 * @param $fieldName  array   
	 */
	public function deleField($modelid,$fieldid)
	{
		$fieldName = M("Attribute")->field('dataname')->select(array('where'=>array('in'=>array('id'=>$fieldid),'modelid'=>$modelid)));
		
		return $fieldName;
	}
	
	/**
	 * 删除表
	 * @param $tableid int 根据此id查找要删除的表
	 */
	public function deleteTable($tableid)
	{
		$table = $this->getTableName($tableid);
		
		$sql = "DROP  TABLE IF EXISTS $table";

		return $this->query($sql);
	}
	
	/**
	 * 一次添加多个列
	 * @param $sql string sql语句
	 * @param $table string 表名
	 */
	public function alertManyClumn($sql,$table) {
		
		$sql = "ALTER TABLE `".$this->tablePrefix.$table."` ADD(".substr($sql,0,-1).")";
		
		$this->query($sql);
	}
	
	
	/**
	 * 获取会员注册表单缓存列表
	 * 1.开启状态的会员注册表单
	 * 2.用于添加、修改会员分组会员注册表单下拉列表
	 * 
	 * @return array:$list array(id=>name)
	 * @author wr 2013.4.8
	 */
	public function  getMemberFormCacheList()
	{
		$list = array();
		$options  = array();
		$options['field'] = "id,name";
		$options['where'] = array('flag'=>2,'state'=>2);
		$options['order'] = "id ASC";
		$result = $this->select($options);
		foreach ($result as $row)
		{
			$list[$row['id']] = $row['name'];
		}
		set_cache('memberform', $list,'common');
		return $list;
	}
   /**
    *获取正在使用的和默认的表单
	*
    **/
	public function getUseForm($id){
	
	    $sql = "SELECT id FROM mo_mix_model WHERE id in (".$id.") OR def = '1' ";
        return $this->query($sql);
	}

}