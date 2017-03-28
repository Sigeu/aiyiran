<?php return array (
'name' => 'goods',
'describe' => '商品信息标签',
'example'=>'
{mo:goods row="10" id="45" order="brandid"  return="data"}
     {foreach $data  $key $value} 
         <a href='."'".'{$value["'.'url'.'"]}'."'".'>{$value["brandname"]}</a>
     {/foreach}
{/mo:goods}',
'params'=>array(
'row ="100"'=> '返回数目',
'pagesize ="10"'=> '每页显示条数',
'pagenum ="10"'=> '每页显示的页码（不能小于5）',
'from ="0"'=> '内容开始位置',
'id ="45"'=> '商品ID',
'cid ="1"'=> '栏目id',
'brandid ="1"'=> '品牌id',
'typeid ="1"'=> '类型id',
'sortid ="1"'=> '类别id',
'type ="son"'=> '调用cid下面的子栏目的商品列表',
'type ="all"'=> '调用cid的子栏目以及本身栏目的商品列表',
'order="hits desc"'=> '按点击量排序（降序）',
'order="created"'=> '排序方式：发布时间(升序)',
),
);?>