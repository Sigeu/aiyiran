<?php return array (
'name' => 'goodsort',
'describe' => '商品列别标签',
'example'=>'
{mo:goodstype row="10" order="sortid" return="data"}
     {foreach $data  $key $value} 
         <a href="#">{$value["sortname"]}</a>
     {/foreach}
{/mo:goodstype}',
'params'=>array(
'row ="10"'=> '导航显示的条数:默认调取10条记录',
'id ="45"'=> '类别id:当type为"all 或者 top"的时候无效',
'order="sortid desc"'=> '排序方式：列别id排序(降序)',
'order="created"'=> '排序方式：发布时间(降序)',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>