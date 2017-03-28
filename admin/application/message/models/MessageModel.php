<?php

class MessageModel extends Model
{
// 	public $trueTableName = 'mo_message';
// 	public $dbsetting = 'link1';
// 	public $tableName = 'test';
	public function  getList($count=10)
	{
		$list = $this->findLimit('','','',0,$count);
		
		
		return $list;
	}
	
	public function testsql()
	{
		$sql = "select c.*,m.* from mo_maintable as m left join mo_category as c on m.categoryid=c.id";
		$result = $this->query($sql);
		
		return $result;
		
	}
	
	
}