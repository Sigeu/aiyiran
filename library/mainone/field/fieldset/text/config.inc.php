<?php
return array(
		'fieldtype' => 'varchar', //字段数据库类型
		'issystem'  => 1,         //是否允许作为主表字段:即是否可以删除
		'minlength' => 0,		  //字符长度默认最小值
		'maxlength' => '',	      //字符长度默认最大值
		'defaultvalue'=> '',	  //默认值
		'issearch'  => 1,         //作为搜索条件
		'isunique'  => 1,	      //是否允许值唯一
		'isnull'    => 1,	      //是否必填项
		
)
?>