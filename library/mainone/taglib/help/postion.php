<?php return array (
'name' => 'position',
'describe' => '推荐位标签',
'example'=>'
{mo:position id="1" row="10"  return="data"}
	{foreach $data  $key $value} 
	<tr><td>标题：{$value["title"]}</a> </td></tr>
	{/foreach}
{/mo:position}',
'params'=>array(
'row ="100"'=> '返回数目',
'id ="1"'=> '推荐位ID',
'from ="0"'=> '内容开始位置',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>