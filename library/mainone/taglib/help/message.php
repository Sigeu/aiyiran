<?php return array (
'name' => 'message',
'describe' => '留言标签',
'example'=>'
{mo:comment modelid="1" row="10"  return="data"}
	{foreach $data  $key $value} 
	<tr><td>内容：{$value["comment_content"]}</a> </td><td>时间：{date("Y-m-d",$value["reply_time"])}  </td></tr>
	{/foreach}
{/mo:comment}',
'params'=>array(
'row ="100"'=> '返回数目',
'modelid ="10"'=> '留言类别ID:必选',
'modelid ="1"'=> '模型ID',
'pagesize ="10"'=> '每页显示条数',
'pagenum ="10"'=> '每页显示的页码（不能小于5）',
'from ="0"'=> '内容开始位置',
'return ="data"'=> '返回值名称：默认用data',	
),
);?>