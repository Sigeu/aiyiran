<?php return array (
'name' => 'article',
'describe' => '文章标签',
'example'=>'
{mo:article row="10" cid="1" return="data"}
	{foreach $data  $key $value} 
	<tr><td>标题：<a href='."'".'{$value["'.'url'.'"]}'."'".'>{$value["title"]}</a> </td><td>时间：{date("Y-m-d",$value["time"])}  </td></tr>
	{/foreach}
{/mo:article}',
'params'=>array(
'row ="100"'=> '返回数目',
'cid ="10"'=> '栏目ID',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>