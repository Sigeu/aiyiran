<?php
defined('IN_MAINONE') or exit('No permission');
return array(
		'fieldtype' => 'int',      //字段数据库类型
		'issystem'  => 1,          //是否允许作为主表字段:即是否可以删除
		'minlength' => '',		   //字符长度默认最小值
		'maxlength' => '',	       //字符长度默认最大值
		'defaultvalue'=> '',	   //默认值
		'issearch'  => 2,          //作为搜索条件
		'isunique'  => 2,	       //是否允许值唯一
		'isnull'    => 2,	       //是否必填项
)
?>