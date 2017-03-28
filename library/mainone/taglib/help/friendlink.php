<?php return array (
'name' => 'friendlink.lib.php',
'describe' => '友情链接标签',
'example'=>'
{mo:friendlink row="10" return="data"}
	{foreach $data  $key $value} 
	<tr><td>名称：<a href='."'".'{$value["'.'com_url'.'"]}'."'".'>{$value["name"]}</a> 
	{/foreach}
{/mo:friendlink}',
'params'=>array(
'row ="100"'=> '返回数目',
'order ="sort"'=> '排序id',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>