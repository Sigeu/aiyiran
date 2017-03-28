<?php

class MessageModel extends Model
{
// 	public $trueTableName = 'mo_message';
	public $dbsetting = 'link1';
// 	public $tablePrefix = 'mo_';
// 	public $tablePrefix = ;

	
	public function  getList($count='')
	{
// 		$list = $this->findLimit('','','',0,$count);
		$sql = "select * from ".$this->tablePrefix."test";
		
		$list1 = $this->query($sql);
		return $list1;
	}
}