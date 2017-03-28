<?php return array (
'name' => 'navigation',
'describe' => '导航标签',
'example'=>'
{mo:navigation row="10" order="ordernum" return="data"}
     {foreach $data  $key $value} 
         <a href='."'".'{$value["'.'url'.'"]}'."'".'>{$value["catname"]}</a>
     {/foreach}
{/mo:article}',
'params'=>array(
'row ="10"'=> '导航显示的条数:默认调取10条记录',
'order="ordernum"'=> '排序方式：默认按排序字段升序',
'order="id desc"'=> '排序方式：id排序(降序)',
'order="created"'=> '排序方式：发布时间(降序)',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>