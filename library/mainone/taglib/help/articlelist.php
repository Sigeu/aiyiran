<?php return array (
'name' => 'articlelist',
'describe' => '文章列表标签',
'example'=>'
{mo:article row="10" cid="1" return="data"}
	{foreach $data  $key $value} 
	<tr><td>标题：<a href='."'".'{$value["'.'url'.'"]}'."'".'>{$value["title"]}</a> </td><td>时间：{date("Y-m-d",$value["time"])}  </td></tr>
	{/foreach}
{/mo:article}',
'params'=>array(
'row ="100"'=> '返回数目',
'from ="100"'=> '从第几条查询',
'pagesize ="100"'=> '分页数量',
'pagenum ="10"'=> '每页显示的页码（不能小于5）',
'cid ="10"'=> '调取某个栏目下的文章:栏目ID，没有type参数调用本身栏目下的文章列表',
'type ="son"'=> '调用cid下面的子栏目的文章列表',
'type ="parent"'=> '调用cid的父栏目的文章列表',
'type ="all"'=> '调用cid的子栏目以及本身栏目的文章列表',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>