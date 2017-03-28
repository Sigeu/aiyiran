<?php return array (
'name' => 'advertlist',
'describe' => '广告列表标签',
'example'=>'
{mo:advertlist row="5" adposid="115" order="`sort` ASC , `id` DESC" from="0" row="5" return="data" }
	{foreach $data  $key $value} 
	<td><a href="{$value[\'adimg\'][0][\'link\']}"><img src="{$upload_img_path}/{$value[\'adimg\'][0][\'img\'][\'path\']}" /></a></td>
	{/foreach}
{/mo:article}', 
'params'=>array(
'row ="5"'=> '记录数目',
'adposid ="115"'=> '广告位ID',
'order="`sort` ASC , `id` DESC"'=> '排序条件',
'return ="data"'=> '返回值名称：默认用data',	
'from="0"'=> '从开始开始记录' ,
'pagesize="10"'=> '每页显示10个' ,
),
);?>