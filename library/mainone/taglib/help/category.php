<?php return array (
'name' => 'category',
'describe' => '栏目标签',
'example'=>'
{mo:category row="10" cid="45" order="ordernum" type="son" return="data"}
     {foreach $data  $key $value} 
         <a href='."'".'{$value["'.'url'.'"]}'."'".'>{$value["catname"]}</a>
     {/foreach}
{/mo:category}',
'params'=>array(
'row ="10"'=> '导航显示的条数:默认调取10条记录',
'cid ="45"'=> '栏目ID:当type为"all 或者 top"的时候无效',
'type ="son"'=> '调用cid下面的子栏目',
'type ="parent"'=> '调用cid的父栏目',
'type ="self"'=> '调用cid的本身栏目',
'type ="top"'=> '调用一级栏目',
'type ="all"'=> '调用所有栏目',		
'order="ordernum"'=> '排序方式：默认按排序字段升序',
'order="id desc"'=> '排序方式：id排序(降序)',
'order="created"'=> '排序方式：发布时间(降序)',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>