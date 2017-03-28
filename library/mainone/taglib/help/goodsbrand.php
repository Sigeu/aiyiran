<?php return array (
'name' => 'goodsbrand',
'describe' => '商品品牌标签',
'example'=>'
{mo:goodsbrand row="10" id="45" order="brandid"  return="data"}
     {foreach $data  $key $value} 
         <a href='."'".'{$value["'.'url'.'"]}'."'".'>{$value["brandname"]}</a>
     {/foreach}
{/mo:goodsbrand}',
'params'=>array(
'row ="10"'=> '导航显示的条数:默认调取10条记录',
'id ="45"'=> '品牌id:当type为"all 或者 top"的时候无效',
'order="brandid desc"'=> '排序方式：id排序(降序)',
'order="created"'=> '排序方式：发布时间(降序)',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>