<?php return array (
'name' => 'goodstype',
'describe' => '商品类型标签',
'example'=>'
{mo:goodstype row="10" id="45" order="typeid" return="data"}
     {foreach $data  $key $value} 
         <a href="#">{$value["typename"]}</a>
     {/foreach}
{/mo:goodstype}',
'params'=>array(
'row ="10"'=> '导航显示的条数:默认调取10条记录',
'id ="45"'=> '类别id',
'order="typeid desc"'=> '排序方式：id排序(降序)',
'order="created"'=> '排序方式：发布时间(降序)',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>