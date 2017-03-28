<?php return array (
'name' => 'goodsalbum',
'describe' => '商品相册标签',
'example'=>'
{mo:goodsalbum row="10" id="45" order="goodsid"  return="data"}
     {foreach $data  $key $value} 
         <img src='."'".'{UPLOAD_PATH}/goods/{$value["'.'photo'.'"]}'."'".'/>
     {/foreach}
{/mo:goodsalbum}',
'params'=>array(
'row ="10"'=> '显示的条数:默认调取10条记录',
'id ="45"'=> '商品ID',
'order="goodsid desc"'=> '排序方式：商品id排序(降序)',
'order="created"'=> '排序方式：发布时间(降序)',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>