<?php return array (
'name' => 'hotkey',
'describe' => '热搜词标签',
'example'=>'
{mo:hotkey row="10" modelid="1" order="nums desc"  return="data"}
     {foreach $data  $key $value} 
         <a href='."'".'{$value["'.'url'.'"]}'."'".'>{$value["title"]}</a>
     {/foreach}
{/mo:goods}',
'params'=>array(
'row ="100"'=> '返回数目',
'from ="0"'=> '内容开始位置',
'order="nums desc"'=> '按排序ID（降序）',
),
);?>